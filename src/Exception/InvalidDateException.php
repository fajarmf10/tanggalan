<?php

declare(strict_types=1);

namespace Tanggalan\Exception;

class InvalidDateException extends TanggalanException
{
    public static function invalidGregorianDate(string $date): self
    {
        return new self("Invalid Gregorian date: {$date}");
    }

    public static function invalidHijriDate(int $year, int $month, int $day): self
    {
        return new self("Invalid Hijri date: {$year}-{$month}-{$day}");
    }

    public static function invalidJavaneseDate(string $date): self
    {
        return new self("Invalid Javanese date: {$date}");
    }
}
