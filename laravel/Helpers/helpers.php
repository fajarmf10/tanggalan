<?php

declare(strict_types=1);

use Tanggalan\Tanggalan;
use Tanggalan\ValueObject\HijriDate;
use Tanggalan\ValueObject\JavaneseDate;
use Tanggalan\ValueObject\Weton;

if (!function_exists('to_hijri')) {
    /**
     * Convert Gregorian date to Hijri date
     *
     * @param DateTimeImmutable|string $date
     * @return HijriDate
     */
    function to_hijri(DateTimeImmutable|string $date): HijriDate
    {
        return Tanggalan::toHijri($date);
    }
}

if (!function_exists('to_javanese')) {
    /**
     * Convert Gregorian date to Javanese date
     *
     * @param DateTimeImmutable|string $date
     * @return JavaneseDate
     */
    function to_javanese(DateTimeImmutable|string $date): JavaneseDate
    {
        return Tanggalan::toJavanese($date);
    }
}

if (!function_exists('get_weton')) {
    /**
     * Get weton for a Gregorian date
     *
     * @param DateTimeImmutable|string $date
     * @return Weton
     */
    function get_weton(DateTimeImmutable|string $date): Weton
    {
        return Tanggalan::getWeton($date);
    }
}

if (!function_exists('from_hijri')) {
    /**
     * Convert Hijri date to Gregorian date
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @return DateTimeImmutable
     */
    function from_hijri(int $year, int $month, int $day): DateTimeImmutable
    {
        return Tanggalan::fromHijri($year, $month, $day);
    }
}
