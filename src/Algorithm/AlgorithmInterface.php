<?php

declare(strict_types=1);

namespace Tanggalan\Algorithm;

use DateTimeImmutable;
use Tanggalan\ValueObject\HijriDate;

/**
 * Interface for Hijri calendar conversion algorithms
 */
interface AlgorithmInterface
{
    /**
     * Convert Gregorian date to Hijri date
     */
    public function toHijri(DateTimeImmutable $date): HijriDate;

    /**
     * Convert Hijri date to Gregorian date
     */
    public function toGregorian(int $year, int $month, int $day): DateTimeImmutable;

    /**
     * Check if this algorithm supports the given Hijri year
     */
    public function supports(int $hijriYear): bool;
}
