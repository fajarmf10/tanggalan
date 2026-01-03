<?php

declare(strict_types=1);

namespace Tanggalan\Converter;

use DateTimeImmutable;
use Tanggalan\Algorithm\AlgorithmInterface;
use Tanggalan\Exception\InvalidDateException;

/**
 * Converts Hijri dates to Gregorian dates
 *
 * Follows Dependency Inversion Principle: depends on AlgorithmInterface abstraction
 */
final class HijriToGregorianConverter implements ConverterInterface
{
    /**
     * @param AlgorithmInterface $algorithm The Hijri algorithm to use
     */
    public function __construct(
        private readonly AlgorithmInterface $algorithm
    ) {
    }

    /**
     * Convert Hijri date to Gregorian date
     *
     * @param array{year: int, month: int, day: int}|string $date Hijri date as array or string
     * @return DateTimeImmutable The converted Gregorian date
     * @throws InvalidDateException
     */
    public function convert(DateTimeImmutable|string $date): DateTimeImmutable
    {
        // This method signature is for interface compatibility
        // Use convertFromComponents for actual conversion
        throw new \BadMethodCallException(
            'Use convertFromComponents() method for Hijri to Gregorian conversion'
        );
    }

    /**
     * Convert Hijri date components to Gregorian date
     */
    public function convertFromComponents(int $year, int $month, int $day): DateTimeImmutable
    {
        if ($month < 1 || $month > 12) {
            throw InvalidDateException::invalidHijriDate($year, $month, $day);
        }

        if ($day < 1 || $day > 30) {
            throw InvalidDateException::invalidHijriDate($year, $month, $day);
        }

        return $this->algorithm->toGregorian($year, $month, $day);
    }
}
