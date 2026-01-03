<?php

declare(strict_types=1);

namespace Tanggalan\Converter;

use DateTimeImmutable;
use Tanggalan\Calculator\WetonCalculator;
use Tanggalan\Enum\JavaneseDay;
use Tanggalan\Exception\InvalidDateException;
use Tanggalan\ValueObject\JavaneseDate;

/**
 * Converts Gregorian dates to Javanese dates with Weton
 *
 * Follows Single Responsibility: Only handles Gregorian to Javanese conversion
 * Follows Dependency Inversion: Depends on WetonCalculator abstraction
 */
final class GregorianToJavaneseConverter implements ConverterInterface
{
    /**
     * @param WetonCalculator $wetonCalculator Calculator for weton and pasaran
     */
    public function __construct(
        private readonly WetonCalculator $wetonCalculator
    ) {
    }

    /**
     * @param DateTimeImmutable|string $date The Gregorian date to convert
     * @return JavaneseDate The converted Javanese date with weton
     * @throws InvalidDateException
     */
    public function convert(DateTimeImmutable|string $date): JavaneseDate
    {
        if (is_string($date)) {
            try {
                $date = new DateTimeImmutable($date);
            } catch (\Exception $e) {
                throw InvalidDateException::invalidGregorianDate($date);
            }
        }

        $weton = $this->wetonCalculator->calculate($date);
        $dayOfWeek = (int) $date->format('N');
        $javaneseDay = JavaneseDay::fromDayOfWeek($dayOfWeek);

        return JavaneseDate::create(
            gregorianDate: $date,
            day: $javaneseDay,
            pasaran: $weton->pasaran
        );
    }
}
