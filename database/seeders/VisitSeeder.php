<?php

namespace Database\Seeders;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    private static $defaultRanges = [
        ['start' => '9', 'end' => '10'],
        ['start' => '10', 'end' => '11'],
        ['start' => '11', 'end' => '12'],
        ['start' => '12', 'end' => '13'],
        ['start' => '13', 'end' => '14'],
        ['start' => '14', 'end' => '15'],
        ['start' => '15', 'end' => '16'],
        ['start' => '16', 'end' => '17'],
    ];

    public function run(): void
    {
        // Generate a random amount of visits for each day of the week
        $this->generateVisitsPerDay(80);
    }

    /**
     * Generate a random amount of visits for each day of the week.
     * @param int $numVisits The number of visits to generate per day.
     * @return array An array of generated visits.
     */
    public function generateVisitsPerDay(int $numVisits): array
    {
        $visits = [];
        // Start from a month ago
        $date = Carbon::now()->subMonth();
        for ($i = 0; $i < $numVisits; $i++) {
            // Skip weekends and move to Monday
            if ($date->isWeekend()) {
                $date->next(Carbon::MONDAY);
            }

            $visits = array_merge($visits, $this->generateVisits($date));
            $date->addDay();
        }

        return $visits;
    }

    /**
     * Generate a random amount of visits for a given date.
     * @param Carbon $date The date to generate visits for.
     * @return array An array of generated visits.
     */
    public function generateVisits(Carbon $date): array
    {
        $defaultRanges = self::$defaultRanges;
        $timeRanges = [];

        // Generate a random amount of time ranges for the given day
        $amount = mt_rand(1, count($defaultRanges));
        while (count($timeRanges) < $amount) {
            $randomIndex = array_rand($defaultRanges);
            $selectedTimeRange = $defaultRanges[$randomIndex];
            $isDuplicate = false;

            // Check if the time range is already in the array
            foreach ($timeRanges as $time) {
                if ($time['start'] === $selectedTimeRange['start']) {
                    $isDuplicate = true;
                    break;
                }
            }

            // If the time range is not a duplicate, add it to the array
            if (!$isDuplicate) {
                $timeRanges[] = [
                    'start' => $selectedTimeRange['start'],
                    'end' => $selectedTimeRange['end'],
                ];
            }
        }

        $visits = [];

        foreach ($timeRanges as $timeRange) {
            $visits[] = Visit::factory()->create([
                'start_date' => $date->copy()->setTime($timeRange['start'], 0, 0),
                'end_date' => $date->copy()->setTime($timeRange['end'], 0, 0),
            ]);
        }

        return $visits;
    }
}
