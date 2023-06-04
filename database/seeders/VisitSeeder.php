<?php

namespace Database\Seeders;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    private static $defaultRanges = [
        Carbon::MONDAY => [
            ['start' => '9', 'end' => '10'],
            ['start' => '10', 'end' => '11'],
            ['start' => '11', 'end' => '12'],
        ],
        Carbon::TUESDAY => [
            ['start' => '9', 'end' => '10'],
            ['start' => '10', 'end' => '11'],
            ['start' => '11', 'end' => '12'],
        ],
        Carbon::WEDNESDAY => [
            ['start' => '14', 'end' => '15'],
            ['start' => '15', 'end' => '16'],
        ],
        Carbon::THURSDAY => [
            ['start' => '14', 'end' => '15'],
            ['start' => '15', 'end' => '16'],
        ],
        Carbon::FRIDAY => [
            ['start' => '9', 'end' => '10'],
            ['start' => '10', 'end' => '11'],
            ['start' => '11', 'end' => '12'],
        ],
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
        $todayRange = self::$defaultRanges[$date->dayOfWeek];
        $timeRanges = [];

        // Generate a random amount of time ranges for the given day
        $amount = mt_rand(1, count($todayRange));
        while (count($timeRanges) < $amount) {
            $randomIndex = array_rand($todayRange);
            $selectedTimeRange = $todayRange[$randomIndex];
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
                'start_date' => $date->setTime($timeRange['start'], 0, 0),
                'end_date' => $date->setTime($timeRange['end'], 0, 0),
            ]);
        }

        return $visits;
    }
}
