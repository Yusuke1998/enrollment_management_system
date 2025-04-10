<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Pay;
use App\Models\Communication;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function indexAcademies(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 6;
        $offset = ($page - 1) * $perPage;
        
        $academies = Academy::with('courses')
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take($perPage)
            ->get();
            
        $total = Academy::count();
        $hasMore = $total > ($offset + $perPage);
            
        return response()->json([
            'success' => true,
            'data' => $academies,
            'total' => $total,
            'has_more' => $hasMore,
            'current_page' => (int)$page
        ]);
    }

    public function storeAcademy(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $academy = Academy::create($validated);
        return response()->json($academy, 201);
    }

    public function updateAcademy(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $academy = Academy::find($id);
        if (!$academy) {
            return response()->json(['message' => 'Academy not found'], 404);
        }
        $academy->update($validated);
        return response()->json($academy, 200);
    }

    public function destroyAcademy($id)
    {
        $academy = Academy::find($id);
        if (!$academy) {
            return response()->json(['message' => 'Academy not found'], 404);
        }
        $academy->delete();
        return response()->json(['message' => 'Academy deleted'], 200);
    }

    public function storeEnrollment(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $enrollment = Enrollment::create($validated);
        return response()->json($enrollment, 201);
    }

    public function updateEnrollment(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $enrollment = Enrollment::create($validated);
        return response()->json($enrollment, 201);
    }

    public function destroyEnrollment($id)
    {
        $enrollment = Enrollment::find($id);
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }
        $enrollment->delete();
        return response()->json(['message' => 'Enrollment deleted'], 200);
    }

    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'method' => 'required|string',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'enrollment_id' => 'required|exists:enrollments,id',
        ]);
        $pay = Pay::create($validated);
        return response()->json($pay, 201);
    }

    public function sendCommunication(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'sent_date' => 'required|date',
            'communicable_id' => 'required',
            'communicable_type' => 'required|string',
        ]);
        $communication = Communication::create($validated);
        return response()->json($communication, 201);
    }

    public function getCommunications()
    {
        return response()->json(Communication::all(), 200);
    }

    public function indexCourses(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 6;
        $offset = ($page - 1) * $perPage;
        
        $courses = Course::with('academy')
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take($perPage)
            ->get();
            
        $total = Course::count();
        $hasMore = $total > ($offset + $perPage);
            
        return response()->json([
            'success' => true,
            'data' => $courses,
            'total' => $total,
            'has_more' => $hasMore,
            'current_page' => (int)$page
        ]);
    }

    public function showAcademy($id)
    {
        $academy = Academy::with('courses')->find($id);
        
        if (!$academy) {
            return response()->json([
                'success' => false,
                'message' => 'Academy not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'academy' => $academy,
                'courses' => $academy->courses
            ]
        ]);
    }

    public function showCourse($id)
    {
        $course = Course::with('academy')->find($id);
        // dd("ShowCourse", $id, $course);
        
        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'course' => $course,
                'academy' => $course->academy
            ]
        ]);
    }
}