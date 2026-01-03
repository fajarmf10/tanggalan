<?php

declare(strict_types=1);

namespace Tanggalan\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use DateTimeImmutable;
use Tanggalan\ValueObject\HijriDate;
use Tanggalan\ValueObject\JavaneseDate;
use Tanggalan\ValueObject\Weton;

/**
 * Tanggalan Laravel Facade
 *
 * @method static HijriDate toHijri(DateTimeImmutable|string $date)
 * @method static JavaneseDate toJavanese(DateTimeImmutable|string $date)
 * @method static Weton getWeton(DateTimeImmutable|string $date)
 * @method static DateTimeImmutable fromHijri(int $year, int $month, int $day)
 * @method static \Tanggalan\Tanggalan withAdjustment(int $adjustment)
 *
 * @see \Tanggalan\Tanggalan
 */
class Tanggalan extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \Tanggalan\Tanggalan::class;
    }
}
