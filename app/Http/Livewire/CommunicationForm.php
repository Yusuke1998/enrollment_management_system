<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\{
    CommunicationRecipient, 
    Communication,
    Course, Father
};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommunicationForm extends Component
{
    public $communicationId;
    public $title;
    public $message;
    public $criteria_course_id = '';
    public $criteria_min_age;
    public $criteria_max_age;
    public $searchTerm = '';
    public $selectedFathers = [];
    public $availableFathers = [];
    public $isEditing = false;
    
    protected $rules = [
        'title' => 'required|string|max:255',
        'message' => 'required|string',
        'criteria_course_id' => 'nullable|exists:courses,id',
        'criteria_min_age' => 'nullable|integer|min:0',
        'criteria_max_age' => 'nullable|integer|min:0|gt:criteria_min_age',
    ];

    public function mount($communicationId = null)
    {
        $this->availableFathers = Father::limit(20)->get();
        
        if ($communicationId) {
            $this->isEditing = true;
            $this->communicationId = $communicationId;
            $this->loadCommunicationData();
        }
    }

    protected function loadCommunicationData()
    {
        $communication = Communication::with('recipients')->findOrFail($this->communicationId);
        
        $this->title = $communication->title;
        $this->message = $communication->message;
        $this->criteria_course_id = $communication->criteria_course_id;
        $this->criteria_min_age = $communication->criteria_min_age;
        $this->criteria_max_age = $communication->criteria_max_age;
        
        // Cargar padres seleccionados
        $this->selectedFathers = $communication->recipients
            ->pluck('recipient_id')
            ->toArray();
    }

    public function render()
    {
        $courses = Course::all();
        return view('livewire.communication-form', [
            'courses' => $courses,
        ]);
    }

    public function searchFathers()
    {
        $this->availableFathers = Father::where('name', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('email', 'like', '%'.$this->searchTerm.'%')
            ->limit(20)
            ->get();
    }

    public function addFather($fatherId)
    {
        if (!in_array($fatherId, $this->selectedFathers)) {
            $this->selectedFathers[] = (int)$fatherId;
        }
    }

    public function removeFather($fatherId)
    {
        $this->selectedFathers = array_filter($this->selectedFathers, function($id) use ($fatherId) {
            return $id !== $fatherId;
        });
    }

    public function submit()
    {
        $this->validate();
        
        DB::beginTransaction();
        try {
            if ($this->isEditing) {
                $communication = Communication::findOrFail($this->communicationId);
                $communication->update([
                    'title' => $this->title,
                    'message' => $this->message,
                    'criteria_course_id' => $this->criteria_course_id,
                    'criteria_min_age' => $this->criteria_min_age,
                    'criteria_max_age' => $this->criteria_max_age,
                ]);
                
                // Eliminar recipients anteriores
                $communication->recipients()->delete();
            } else {
                $communication = Communication::create([
                    'title' => $this->title,
                    'message' => $this->message,
                    'criteria_course_id' => $this->criteria_course_id,
                    'criteria_min_age' => $this->criteria_min_age,
                    'criteria_max_age' => $this->criteria_max_age,
                    'sent_date' => now(),
                ]);
            }
    
            // Agregar nuevos recipients
            if (!empty($this->selectedFathers)) {
                foreach ($this->selectedFathers as $fatherId) {
                    CommunicationRecipient::create([
                        'communication_id' => $communication->id,
                        'recipient_id' => $fatherId,
                        'recipient_type' => Father::class,
                        'user_id' => auth()->id(),
                        'status' => 'pendiente',
                    ]);
                }
            } else {
                $fathersQuery = Father::query();
                if ($this->criteria_course_id) {
                    $fathersQuery->whereHas('students.enrollments', function($q) {
                        $q->where('course_id', $this->criteria_course_id);
                    });
                } else {
                    $fathersQuery->whereHas('students.enrollments', function($q) {
                        $q->where('course_id', '!=', null);
                    });
                }
                
                if ($this->criteria_min_age || $this->criteria_max_age) {
                    $fathersQuery->whereHas('students', function($q) {
                        if ($this->criteria_min_age) {
                            $minDate = now()->subYears($this->criteria_min_age);
                            $q->where('birth_date', '<=', $minDate);
                        }
                        if ($this->criteria_max_age) {
                            $maxDate = now()->subYears($this->criteria_max_age + 1);
                            $q->where('birth_date', '>=', $maxDate);
                        }
                    });
                }
                
                foreach ($fathersQuery->get() as $father) {
                    CommunicationRecipient::create([
                        'communication_id' => $communication->id,
                        'recipient_id' => $father->id,
                        'recipient_type' => Father::class,
                        'user_id' => auth()->id(),
                        'status' => 'pendiente',
                    ]);
                }
            }
            
            DB::commit();
            session()->flash('message', $this->isEditing 
                ? 'Comunicado actualizado correctamente' 
                : 'Comunicado creado y enviado correctamente');
            return redirect()->route('communications.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al '.($this->isEditing ? 'actualizar' : 'crear').' el comunicado: '.$e->getMessage());
            session()->flash('error', 'Error al '.($this->isEditing ? 'actualizar' : 'crear').' el comunicado: '.$e->getMessage());
            return;
        }
    }

    public function getSelectedFathersDetailsProperty()
    {
        if (empty($this->selectedFathers)) {
            return collect();
        }
        
        return Father::whereIn('id', $this->selectedFathers)->get();
    }

    public function getRecipientsSummaryProperty()
    {
        if (!empty($this->selectedFathers)) {
            return "Se enviará a ".count($this->selectedFathers)." padres seleccionados manualmente";
        }
        
        return "Seleccione criterios o padres específicos";
    }
}