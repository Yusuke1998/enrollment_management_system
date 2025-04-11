<?php

namespace App\Http\Livewire;

use App\Models\{
    Academy, Course, Student, Enrollment
};
use Livewire\Component;
use App\Mail\EnrollmentConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnrollFormSteps extends Component
{
    public $currentStep = 1;
    public $totalSteps = 3;
    
    // Paso 1: Academia y Curso
    public $academies, $courses;
    public $academy, $course;
    
    // Paso 2: Datos del estudiante
    public $first_name = '';
    public $last_name = '';
    public $birth_date = '';
    public $email = '';
    public $phone = '';
    public $message = '';
    
    // Paso 3: Datos de pago (simplificado para el ejemplo)
    public $paymentMethod = '';
    public $cardNumber = '';
    public $expiryDate = '';
    public $cvv = '';
    
    public $isFromCallToAction = false;

    protected $rules = [
        // Paso 1
        'academy' => 'required',
        'course' => 'required',
        
        // Paso 2
        'first_name' => 'required|min:3',
        'last_name' => 'required|min:3',
        'email' => 'required|email',
        'birth_date' => 'required|date',
        'phone' => 'required',
        
        // Paso 3
        'paymentMethod' => 'required',
        'cardNumber' => 'required_if:paymentMethod,card|digits:16',
        'expiryDate' => 'required_if:paymentMethod,card',
        'cvv' => 'required_if:paymentMethod,card|digits:3',
    ];

    protected $messages = [
        'academy.required' => 'Debes seleccionar una academia',
        'course.required' => 'Debes seleccionar un curso',
        'paymentMethod.required' => 'Debes seleccionar un método de pago',
        'cardNumber.required_if' => 'El número de tarjeta es requerido',
        'expiryDate.required_if' => 'La fecha de expiración es requerida',
        'cvv.required_if' => 'El CVV es requerido',
    ];

    public function mount()
    {
        $this->isFromCallToAction = request()->has('cta') && request()->input('cta') === 'landing';
        $this->academies = collect();
        $this->courses = collect();
        $this->loadAcademies();
        
        if (!$this->isFromCallToAction && request()->has('course_id')) {
            $course = Course::find(request()->input('course_id'));
            if ($course) {
                $this->academy = $course->academy_id;
                $this->loadCourses();
                $this->course = $course->id;
                $this->currentStep = 2; // Saltar al paso 2 si viene con curso seleccionado
            }
        }
    }

    public function loadAcademies()
    {
        $this->academies = Academy::select('id', 'name')->get();
    }

    public function loadCourses()
    {
        $this->courses = $this->academy 
            ? Course::where('academy_id', $this->academy)->get() 
            : collect();
    }

    public function updatedAcademy($value)
    {
        $this->course = null;
        $this->loadCourses();
    }

    public function nextStep()
    {
        $rules = [];
        if ($this->currentStep === 1) {
            $rules = ['academy' => 'required', 'course' => 'required'];
        } elseif ($this->currentStep === 2) {
            $rules = [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|email',
                'birth_date' => 'required|date',
                'phone' => 'required',
            ];
        }
        
        $this->validate($rules);
        $this->currentStep++;
    }

    public function prevStep()
    {
        $this->currentStep--;
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $student = Student::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'birth_date' => $this->birth_date,
                'email' => $this->email,
                'phone' => $this->phone,
                'father_id' => auth()->user()->father->id,
            ]);
            
            $enrollment = Enrollment::create([
                'course_id' => $this->course,
                'student_id' => $student->id,
            ]);

            // Aquí podrías agregar la lógica para el pago
            $pay = $enrollment->pays()->create([
                'method' => $this->paymentMethod,
                'amount' => 100, // Ejemplo de monto
                'payment_date' => now(),
            ]);
            DB::commit();
            
            try {
                // Enviar email de confirmación
                Mail::to($this->email)
                ->cc(auth()->user()->email) // Copia al padre
                ->send(new EnrollmentConfirmation($enrollment));
            } catch (\Exception $e) {
                Log::error('Error al enviar el correo de confirmación: ' . $e->getMessage());
                // Manejar el error de envío de correo si es necesario
            }

            session()->flash('success', '¡Inscripción exitosa! Nos pondremos en contacto contigo pronto.');
            return redirect()->route('enrollment.confirmation', $enrollment->id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al procesar la inscripción: ' . $e->getMessage());
            $this->addError('enrollment_error', 'Hubo un error al procesar tu inscripción. Por favor, intenta nuevamente.');
            return;
        }
        
    }

    public function render()
    {
        return view('livewire.enroll-form-steps')
            ->extends('layouts.app_custom', [
                'title' => 'Formulario de Inscripción - Sistema de Gestión de Academias',
                'description' => 'Complete el formulario paso a paso para inscribir a su hijo'
            ]);
    }
}