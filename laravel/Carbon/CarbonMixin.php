<?php

declare(strict_types=1);

namespace Tanggalan\Laravel\Carbon;

use DateTimeImmutable;
use Tanggalan\Tanggalan;
use Tanggalan\ValueObject\HijriDate;
use Tanggalan\ValueObject\JavaneseDate;
use Tanggalan\ValueObject\Weton;

/**
 * Carbon Mixin for Tanggalan
 *
 * Extends Carbon with Hijri and Javanese calendar methods
 *
 * @mixin \Carbon\Carbon
 */
class CarbonMixin
{
    /**
     * Convert Carbon instance to Hijri date
     *
     * @return \Closure
     */
    public function toHijri()
    {
        return function (): HijriDate {
            /** @var \Carbon\Carbon $this */
            return Tanggalan::toHijri($this->toDateTimeImmutable());
        };
    }

    /**
     * Convert Carbon instance to Javanese date
     *
     * @return \Closure
     */
    public function toJavanese()
    {
        return function (): JavaneseDate {
            /** @var \Carbon\Carbon $this */
            return Tanggalan::toJavanese($this->toDateTimeImmutable());
        };
    }

    /**
     * Get Weton for Carbon instance
     *
     * @return \Closure
     */
    public function getWeton()
    {
        return function (): Weton {
            /** @var \Carbon\Carbon $this */
            return Tanggalan::getWeton($this->toDateTimeImmutable());
        };
    }

    /**
     * Create Carbon instance from Hijri date
     *
     * @return \Closure
     */
    public function createFromHijri()
    {
        return function (int $year, int $month, int $day): \Carbon\Carbon {
            $gregorian = Tanggalan::fromHijri($year, $month, $day);
            return \Carbon\Carbon::instance($gregorian);
        };
    }

    /**
     * Format Carbon instance as Hijri date
     *
     * @return \Closure
     */
    public function formatHijri()
    {
        return function (string $format = 'd F Y H', string $locale = 'id'): string {
            /** @var \Carbon\Carbon $this */
            $hijri = Tanggalan::toHijri($this->toDateTimeImmutable());
            return $hijri->format($format, $locale);
        };
    }

    /**
     * Format Carbon instance as Javanese date with Weton
     *
     * @return \Closure
     */
    public function formatJavanese()
    {
        return function (string $locale = 'id'): string {
            /** @var \Carbon\Carbon $this */
            $javanese = Tanggalan::toJavanese($this->toDateTimeImmutable());
            return $javanese->format($locale);
        };
    }
}
