<?php

namespace App\Services;

use App\Services\JsonArrayService;

class FlightService
{
    public function getFlights()
    {
        $path = __DIR__ . '/../../var/input.jsonl';

        $flightArray = JsonArrayService::jsonToArray($path);

        $topFlights = [];
        $missedFlightList = [];
        $overNightStays = [];
        $overNightTo = [];

        foreach ($flightArray as $flight) {
            $flight->real_duration = strtotime($flight->actual_end) - strtotime($flight->actual_start);
            // calculating maximum flight length
            $this->checkMaximumLength($topFlights, $flight);

            // most flights missed filling array
            $this->checkBiggestLater($missedFlightList, $flight);

            // overnight stays
            $this->checkBiggestOvernight($overNightStays, $overNightTo, $flight);
        }
        // getting overnight name
        $overnightKey = array_search(max($overNightTo), $overNightTo);
        // getting most lates
        $landingKey = array_search(max($missedFlightList), $missedFlightList);
        // concatenating string for printing
        $unitedString = "Top 3 flights:\n" .
            $topFlights[0]->registration . " | " . $topFlights[0]->from . "-" . $topFlights[0]->to . " | " . $topFlights[0]->actual_start . " | " . $topFlights[0]->actual_end . "\n" .
            $topFlights[1]->registration . " | " . $topFlights[1]->from . "-" . $topFlights[1]->to . " | " . $topFlights[1]->actual_start . " | " . $topFlights[1]->actual_end . "\n" .
            $topFlights[2]->registration . " | " . $topFlights[2]->from . "-" . $topFlights[2]->to . " | " . $topFlights[2]->actual_start . " | " . $topFlights[2]->actual_end . "\n";
        $unitedString .= "------------------------------------\n";
        $unitedString .= "Most landings missed: " . $landingKey . ";\n";
        $unitedString .= "------------------------------------\n";
        $unitedString .= "Most overnight destination: " . $overnightKey . ";\n";
        $unitedString .= "------------------------------------";

        return $unitedString;
    }

    protected function checkMaximumLength(&$topFlights, &$flight)
    {
        if (count($topFlights) === 3) {
            $durationArray = array_column($topFlights, 'real_duration');
            $minValue = min($durationArray);
            if ($flight->real_duration > $minValue) {
                $keys = array_keys($durationArray, $minValue);
                $topFlights[$keys[0]] = $flight;
            }
        } else {
            $topFlights[] = $flight;
        }
    }

    protected function checkBiggestLater(&$missedFlightList, &$flight)
    {
        $minutesAllowed = 300;
        $realLate = strtotime($flight->actual_end) - strtotime($flight->scheduled_end);

        if ($realLate > $minutesAllowed) {
            $unitedName = $flight->registration . "|" . $flight->from . "-" . $flight->to;

            if (!array_key_exists($unitedName, $missedFlightList)) {
                $missedFlightList[$unitedName] = 1;
            } else {
                $missedFlightList[$unitedName] += 1;
            }
        }
    }

    protected function checkBiggestOvernight(&$overNightStays, &$overNightTo, $flight)
    {
        $takeoffDate = (new \DateTime($flight->actual_start))->modify('-1 day')->format('Y-m-d');

        $landingDate = (new \DateTime($flight->actual_end))->format('Y-m-d');

        $unitedStartingKey = $flight->registration . "-" . $flight->from . "-" . $takeoffDate;

        $unitedLandingKey = $flight->registration . "-" . $flight->to . "-" . $landingDate;

        if (isset($overNightStays[$unitedStartingKey])) {
            if (!isset($overNightTo[$flight->from])) {
                $overNightTo[$flight->from] = 1;
            } else {
                $overNightTo[$flight->from] += 1;
            }
        }

        if (!isset($overNightStays[$unitedLandingKey])) {
            $overNightStays[$unitedLandingKey] = true;
        }
    }
}
