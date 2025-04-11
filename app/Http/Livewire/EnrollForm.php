<?php

namespace App\Http\Livewire;

use App\Models\Academy;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class EnrollForm extends Component
{
    public $academies, $courses;
    public $academy, $course;

    public $name = '';
    public $email = '';
    public $phone = '';
    public $message = '';

    public $isFromCallToAction = false;

    protected $layout = 'layouts.app_custom';

    public function mount()
    {
        $this->isFromCallToAction = request()->has('cta') && request()->input('cta') === 'landing';

        $this->academies = collect();
        $this->courses = collect();
        
        if ($this->isFromCallToAction) {
            $this->loadAcademies();
            $this->course = "";
            $this->courses = collect();
        } else {
            $courseId = request()->input('course_id');
            if ($courseId) {
                $course = Course::find($courseId);
                if ($course) {
                    $this->academy = $course->academy_id;
                    $this->loadAcademies();
                    $this->course = $courseId;
                    $this->loadCourses();
                } else {
                    session()->flash('error', 'Curso no encontrado.');
                }
            } else {
                $this->loadAcademies();
            }
        }
    }

    public function loadAcademies()
    {
        try {
            $this->academies = Academy::select('id', 'name')->get()->toArray();
        } catch (\Exception $e) {
            $this->academies = [];
            session()->flash('error', 'Error al cargar las academias: ' . $e->getMessage());
        }
    }

    public function loadCourses()
    {
        if ($this->academy) {
            $this->courses = Course::where('academy_id', $this->academy)
                ->select('id', 'name')
                ->get();
        } else {
            $this->courses = collect();
        }
    }

    public function updatedAcademy($value)
    {
        $this->course = '';
        $this->loadCourses();
    }

    public function updatedCourse($value)
    {
        dd('updatedCourse', $value);
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required|min:10',
            'course' => 'required'
        ]);

        $enrollment = Enrollment::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'course_id' => $this->course
        ]);

        session()->flash('message', '¡Inscripción exitosa! Nos pondremos en contacto contigo pronto.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.enroll-form')
            ->extends('layouts.app_custom', [
                'title' => 'Formulario de Inscripción - Sistema de Gestión de Academias',
                'description' => 'Complete el formulario para inscribir a su hijo en el curso seleccionado'
            ]);
    }
} 