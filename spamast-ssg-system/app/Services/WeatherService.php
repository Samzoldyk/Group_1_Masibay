<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    /**
     * Get the current weather for Malita from Open-Meteo.
     * Returns null when the service cannot be reached.
     */
    public function current(): ?array
    {
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

                return [
                    'temperature' => round($current['temperature_2m'] ?? 0),
                    'humidity' => $current['relative_humidity_2m'] ?? 0,
                    'feels_like' => round($current['apparent_temperature'] ?? 0),
                    'wind_speed' => $current['wind_speed_10m'] ?? 0,
                    'description' => $this->describe($current['weather_code'] ?? -1),
                ];
            }
        } catch (\Throwable $exception) {
            report($exception);
        }

        return null;
    }

    private function describe(int $code): string
    {
        return match ($code) {
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
    }
}
