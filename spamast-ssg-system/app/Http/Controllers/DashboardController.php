<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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
            function () {
                try {
                    $response = Http::timeout(5)->get(
                        'https://api.open-meteo.com/v1/forecast',
                        [
                            'latitude' => 6.41471,
                            'longitude' => 125.60991,
                            'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,weather_code,wind_speed_10m',
                            'timezone' => 'Asia/Manila',
                        ]
                    );

                    if ($response->successful()) {
                        $current = $response->json('current');

                        $description = match ($current['weather_code'] ?? -1) {
                            0 => 'Clear sky',
                            1, 2 => 'Mainly clear or partly cloudy',
                            3 => 'Overcast',
                            45, 48 => 'Fog',
                            51, 53, 55 => 'Drizzle',
                            61, 63, 65 => 'Rain',
                            71, 73, 75 => 'Snow',
                            80, 81, 82 => 'Rain showers',
                            95, 96, 99 => 'Thunderstorm',
                            default => 'Weather unavailable',
                        };

                        return [
                            'temperature' => round($current['temperature_2m'] ?? 0),
                            'humidity' => $current['relative_humidity_2m'] ?? 0,
                            'feels_like' => round($current['apparent_temperature'] ?? 0),
                            'wind_speed' => $current['wind_speed_10m'] ?? 0,
                            'description' => $description,
                        ];
                    }
                } catch (\Throwable $exception) {
                    report($exception);
                }

                return null;
            }
        );

        return [
            'user' => Auth::user(),
            'totalStudents' => $totalStudents,
            'weather' => $weather,
        ];
    }
}
