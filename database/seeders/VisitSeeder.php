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
    ];

    public function run(): void
    {
        // Generate a random amount of visits for each day of the week
        $this->generateVisitsPerDay(5);
    }

    /**
     * Generate a random amount of visits for a specified number of days
     *
     * @param int $numVisits The number of days to generate visits for.
     * @return array An array of generated visits.
     */
    public function generateVisitsPerDay(int $numVisits): array
    {
        $visits = [];
        $date = Carbon::now();
        for ($i = 0; $i < $numVisits; $i++) {
            $visits[] = $this->generateVisits($date);
            $date->addDay();
        }

        return $visits;
    }


    /**
     * Generate a random amount of visits for a specified date, if no date is specified, the current date is used.
     *
     * @param int $numVisits The number of days to generate visits for.
     * @return array An array of generated visits.
     */
    public function generateVisits(Carbon $date = null): array
    {
        if (is_null($date)) {
            $date = Carbon::now();
        }

        // Generate a random amount of time ranges
        $timeRanges = $this->timeRangeGenerator($date, rand(0, sizeof(self::$defaultRanges)));

        $visits = [];
        // Create visits with different time ranges
        foreach ($timeRanges as $timeRange) {
            $visits[] = Visit::factory()->create([
                'start_date' => $timeRange['start'],
                'end_date' => $timeRange['end'],
            ]);
        }

        return $visits;
    }

    /**
     * Generate a random amount of time ranges for a specified date, if no date is specified, the current date is used.
     *
     * @param Carbon $date The date to generate time ranges for.
     * @param int $numVisits The number of time ranges to generate.
     * @return array An array of generated time ranges.
     */
    public function timeRangeGenerator(Carbon $date, int $numVisits): array
    {
        $timeRanges = [];
        $size = sizeof($timeRanges);
        while ($size != $numVisits) {
            // Pick a random time range
            $range = self::$defaultRanges[rand(0, sizeof(self::$defaultRanges) - 1)];
            $timeRange = [
                'start' => $date->copy()->setTime($range['start'], '0', '0'),
                'end' => $date->copy()->setTime($range['end'], '0', '0')
            ];

            $overlap = false;
            foreach ($timeRanges as $previousTimeRange) {
                if ($timeRange['start'] < $previousTimeRange['end'] && $timeRange['end'] > $previousTimeRange['start']) {
                    $overlap = true;
                    break;
                }
            }

            // Add time range if it doesn't overlap with any other time range
            if (!$overlap) {
                $timeRanges[] = $timeRange;
            }

            // Update size
            $size = sizeof($timeRanges);
        }
        return $timeRanges;
    }
}
