<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return match (Auth::user()->role) {
            'officer' => redirect()->route('officer.dashboard'),
            'adviser' => redirect()->route('adviser.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default => abort(403, 'Unauthorized role.'),
        };
    }

    public function officer()
    {
        return view('officer.dashboard', $this->dashboardData());
    }

    public function adviser()
    {
        return view('adviser.dashboard', $this->dashboardData());
    }

    public function student()
    {
        return view('student.dashboard', $this->dashboardData());
    }

    private function dashboardData(): array
    {
        return [
            'user' => Auth::user(),
            'totalStudents' => Student::count(),
        ];
    }
}