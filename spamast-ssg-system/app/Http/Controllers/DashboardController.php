<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
        $totalStudents = Cache::remember(
            'dashboard.total_students',
            now()->addMinutes(5),
            fn () => Student::count()
        );

        $weather = Cache::remember(
            'spamast.weather',
            now()->addMinutes(10),
            fn () => app(WeatherService::class)->current()
        );

        return [
            'user' => Auth::user(),
            'totalStudents' => $totalStudents,
            'weather' => $weather,
        ];
    }
}
