<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function index()
    {
        $institutes = Institute::with('programs')
            ->orderBy('name')
            ->get();

        return view('register', compact('institutes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'string', 'max:50', 'unique:students,student_id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'program_id' => [
                'required',
                'integer',
                Rule::exists('programs', 'id'),
            ],
            'year_level' => ['nullable', 'string', 'max:50'],
            'contact_number' => ['nullable', 'string', 'max:20'],
        ]);

        $program = Program::findOrFail($validated['program_id']);

        Student::create([
            'student_id' => $validated['student_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'course' => $program->name,
            'program_id' => $program->id,
            'year_level' => $validated['year_level'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
        ]);

        Cache::forget('dashboard.total_students');

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please login.');
    }
}
