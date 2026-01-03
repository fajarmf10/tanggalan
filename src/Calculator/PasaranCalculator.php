<?php

declare(strict_types=1);

namespace Tanggalan\Calculator;

use DateTimeImmutable;
use Tanggalan\Enum\PasaranDay;

/**
 * Calculator specifically for Pasaran (5-day Javanese market week)
 *
 * Single Responsibility: Calculate only the Pasaran component
 */
final class PasaranCalculator implements CalculatorInterface
{
    private const PASARAN_EPOCH_TIMESTAMP = -2208988800; // January 1, 1900
    private const PASARAN_EPOCH_VALUE = 5; // Kliwon

    public function calculate(mixed $input): PasaranDay
    {
        if (!$input instanceof DateTimeImmutable) {
            $input = new DateTimeImmutable($input);
        }

        $timestamp = $input->getTimestamp();

        // Calculate days since epoch
        $daysSinceEpoch = (int) (($timestamp - self::PASARAN_EPOCH_TIMESTAMP) / 86400);

        // Calculate position in 5-day cycle
        $pasaranIndex = (($daysSinceEpoch % 5) + self::PASARAN_EPOCH_VALUE) % 5;

        // Adjust to 1-based index
        $pasaranValue = $pasaranIndex === 0 ? 5 : $pasaranIndex;

        return PasaranDay::fromDayNumber($pasaranValue);
    }
}
