<?php

declare(strict_types=1);

namespace Tanggalan\Calculator;

use DateTimeImmutable;
use Tanggalan\Enum\JavaneseDay;
use Tanggalan\Enum\PasaranDay;
use Tanggalan\ValueObject\Weton;

/**
 * Calculator for Javanese Weton (combination of 7-day week and 5-day Pasaran cycle)
 *
 * Uses Zeller's congruence adaptation for calculating day of week,
 * combined with modulo arithmetic for the 5-day Pasaran cycle
 */
final class WetonCalculator implements CalculatorInterface
{
    /**
     * Pasaran epoch: The pasaran cycle starts on a known date
     * Using January 1, 1900 as reference (Kliwon)
     */
    private const PASARAN_EPOCH_TIMESTAMP = -2208988800;
    private const PASARAN_EPOCH_VALUE = 5; // Kliwon

    public function calculate(mixed $input): Weton
    {
        if (!$input instanceof DateTimeImmutable) {
            $input = new DateTimeImmutable($input);
        }

        $javaneseDay = $this->calculateJavaneseDay($input);
        $pasaranDay = $this->calculatePasaranDay($input);

        return new Weton($javaneseDay, $pasaranDay);
    }

    /**
     * Calculate the Javanese day (7-day week) for a given date
     */
    private function calculateJavaneseDay(DateTimeImmutable $date): JavaneseDay
    {
        // Get day of week (1 = Monday, 7 = Sunday)
        $dayOfWeek = (int) $date->format('N');

        return JavaneseDay::fromDayOfWeek($dayOfWeek);
    }

    /**
     * Calculate the Pasaran day (5-day cycle) for a given date
     *
     * The Pasaran follows a continuous 5-day cycle: Legi, Pahing, Pon, Wage, Kliwon
     */
    private function calculatePasaranDay(DateTimeImmutable $date): PasaranDay
    {
        $timestamp = $date->getTimestamp();

        // Calculate days since epoch
        $daysSinceEpoch = (int) (($timestamp - self::PASARAN_EPOCH_TIMESTAMP) / 86400);

        // Calculate position in 5-day cycle
        $pasaranIndex = (($daysSinceEpoch % 5) + self::PASARAN_EPOCH_VALUE) % 5;

        // Adjust to 1-based index
        $pasaranValue = $pasaranIndex === 0 ? 5 : $pasaranIndex;

        return PasaranDay::fromDayNumber($pasaranValue);
    }

    /**
     * Calculate weton from a date string
     */
    public function calculateFromString(string $date): Weton
    {
        return $this->calculate(new DateTimeImmutable($date));
    }
}
