<?php

declare(strict_types=1);

namespace Tanggalan\Exception;

class UnsupportedCalendarException extends TanggalanException
{
    public static function unsupportedCalendar(string $calendar): self
    {
        return new self("Unsupported calendar type: {$calendar}");
    }
}
