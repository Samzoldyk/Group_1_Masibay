<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $student = $request->user();

        Gate::authorize('view', $student);

        $institutes = Institute::with('programs')
            ->orderBy('name')
            ->get();

        return view('profile.edit', compact('student', 'institutes'));
    }

    public function update(Request $request)
    {
        $student = $request->user();

        Gate::authorize('update', $student);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student->id),
            ],
            'program_id' => [
                'nullable',
                'integer',
                Rule::exists('programs', 'id'),
            ],
            'year_level' => ['required', 'string', 'max:20'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'current_password' => [
                'required_with:password',
                'current_password',
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        if (!empty($data['program_id'])) {
            $program = Program::findOrFail($data['program_id']);
            $data['course'] = $program->name;
        } else {
            unset($data['program_id']);
        }

        unset($data['current_password']);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $student->update($data);

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated.');
    }
}
