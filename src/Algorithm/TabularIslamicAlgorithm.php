<?php

declare(strict_types=1);

namespace Tanggalan\Algorithm;

use DateTimeImmutable;
use Tanggalan\ValueObject\HijriDate;

/**
 * Tabular Islamic Calendar Algorithm
 *
 * Pure mathematical algorithm - NO hardcoded lookup tables!
 * Based on the arithmetical calendar used in some Muslim communities
 *
 * This algorithm is predictable and works for ANY date, but may differ
 * by ±1 day from Um Al-Qura (which uses actual moon observations)
 *
 * Uses the 30-year cycle with 11 leap years
 */
final class TabularIslamicAlgorithm implements AlgorithmInterface
{
    // Hijri epoch: July 16, 622 CE (Julian) = July 19, 622 CE (Gregorian)
    private const HIJRI_EPOCH_JULIAN_DAY = 1948440;

    /**
     * @param int $adjustment Day adjustment (-1, 0, or +1)
     */
    public function __construct(
        private readonly int $adjustment = 0
    ) {
    }

    public function toHijri(DateTimeImmutable $date): HijriDate
    {
        // Calculate Julian Day Number
        $jdn = $this->dateToJulianDay($date) + $this->adjustment;

        // Calculate Hijri date using pure mathematics
        $daysSinceEpoch = $jdn - self::HIJRI_EPOCH_JULIAN_DAY;

        // Calculate the year (30-year cycle)
        $cycle = floor($daysSinceEpoch / 10631);
        $remaining = $daysSinceEpoch % 10631;

        $year = 30 * $cycle;

        // Find the year within the cycle
        $yearInCycle = 0;
        $daysInCycle = 0;

        for ($y = 1; $y <= 30; $y++) {
            $daysInYear = $this->isLeapYear($y) ? 355 : 354;

            if ($daysInCycle + $daysInYear > $remaining) {
                $yearInCycle = $y;
                break;
            }

            $daysInCycle += $daysInYear;
        }

        $year += $yearInCycle;
        $dayOfYear = $remaining - $daysInCycle + 1;

        // Find the month and day
        [$month, $day] = $this->dayOfYearToMonthDay((int) $year, (int) $dayOfYear);

        return HijriDate::create((int) $year, $month, $day);
    }

    public function toGregorian(int $year, int $month, int $day): DateTimeImmutable
    {
        // Calculate days since Hijri epoch
        $daysSinceEpoch = $this->hijriToJulianDay($year, $month, $day) - self::HIJRI_EPOCH_JULIAN_DAY;

        // Calculate Julian Day Number
        $jdn = self::HIJRI_EPOCH_JULIAN_DAY + $daysSinceEpoch - $this->adjustment;

        // Convert Julian Day to Gregorian date
        return $this->julianDayToDate($jdn);
    }

    public function supports(int $hijriYear): bool
    {
        // Tabular algorithm works for ANY year - no limitations!
        return $hijriYear > 0 && $hijriYear < 10000;
    }

    /**
     * Check if a Hijri year is a leap year (355 days instead of 354)
     *
     * In a 30-year cycle, years 2, 5, 7, 10, 13, 16, 18, 21, 24, 26, 29 are leap years
     */
    private function isLeapYear(int $year): bool
    {
        $yearInCycle = $year % 30;

        return in_array($yearInCycle, [2, 5, 7, 10, 13, 16, 18, 21, 24, 26, 29], true);
    }

    /**
     * Get month lengths for a Hijri year (pure calculation)
     */
    private function getMonthLengths(int $year): array
    {
        $isLeap = $this->isLeapYear($year);

        // Odd months: 30 days, Even months: 29 days
        // Last month (Dhu al-Hijjah) has 30 days in leap years
        return [
            30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 30, $isLeap ? 30 : 29
        ];
    }

    /**
     * Convert day of year to month and day
     */
    private function dayOfYearToMonthDay(int $year, int $dayOfYear): array
    {
        $monthLengths = $this->getMonthLengths($year);
        $remaining = $dayOfYear;

        for ($month = 1; $month <= 12; $month++) {
            if ($remaining <= $monthLengths[$month - 1]) {
                return [$month, $remaining];
            }
            $remaining -= $monthLengths[$month - 1];
        }

        return [12, $monthLengths[11]]; // Last day of year
    }

    /**
     * Calculate Julian Day Number from Hijri date
     */
    private function hijriToJulianDay(int $year, int $month, int $day): int
    {
        // Calculate days from complete years
        $completeYears = $year - 1;
        $completeCycles = floor($completeYears / 30);
        $yearsInCycle = $completeYears % 30;

        $days = $completeCycles * 10631; // Days in complete 30-year cycles

        // Add days from incomplete cycle
        for ($y = 1; $y <= $yearsInCycle; $y++) {
            $days += $this->isLeapYear($y) ? 355 : 354;
        }

        // Add days from complete months
        $monthLengths = $this->getMonthLengths($year);
        for ($m = 1; $m < $month; $m++) {
            $days += $monthLengths[$m - 1];
        }

        // Add remaining days
        $days += $day;

        return self::HIJRI_EPOCH_JULIAN_DAY + $days - 1;
    }

    /**
     * Convert Gregorian date to Julian Day Number
     */
    private function dateToJulianDay(DateTimeImmutable $date): int
    {
        $year = (int) $date->format('Y');
        $month = (int) $date->format('m');
        $day = (int) $date->format('d');

        $a = floor((14 - $month) / 12);
        $y = $year + 4800 - $a;
        $m = $month + 12 * $a - 3;

        $jdn = $day + floor((153 * $m + 2) / 5) + 365 * $y + floor($y / 4) - floor($y / 100) + floor($y / 400) - 32045;

        return (int) $jdn;
    }

    /**
     * Convert Julian Day Number to Gregorian date
     */
    private function julianDayToDate(int $jdn): DateTimeImmutable
    {
        $a = $jdn + 32044;
        $b = floor((4 * $a + 3) / 146097);
        $c = $a - floor((146097 * $b) / 4);

        $d = floor((4 * $c + 3) / 1461);
        $e = $c - floor((1461 * $d) / 4);
        $m = floor((5 * $e + 2) / 153);

        $day = $e - floor((153 * $m + 2) / 5) + 1;
        $month = $m + 3 - 12 * floor($m / 10);
        $year = 100 * $b + $d - 4800 + floor($m / 10);

        return new DateTimeImmutable(sprintf('%04d-%02d-%02d', $year, $month, $day));
    }
}
