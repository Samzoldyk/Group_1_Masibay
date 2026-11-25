<?php

namespace App\Policies;

use App\Models\Student;

class StudentPolicy
{
    public function view(Student $user, Student $student): bool
    {
        return $user->id === $student->id;
    }

    public function update(Student $user, Student $student): bool
    {
        return $user->id === $student->id;
    }

    public function delete(Student $user, Student $student): bool
    {
        return false;
    }
}