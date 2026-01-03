<?php

declare(strict_types=1);

namespace Tanggalan\Converter;

use DateTimeImmutable;
use Tanggalan\Algorithm\AlgorithmInterface;
use Tanggalan\Exception\InvalidDateException;
use Tanggalan\ValueObject\HijriDate;

/**
 * Converts Gregorian dates to Hijri dates
 *
 * Follows Dependency Inversion Principle: depends on AlgorithmInterface abstraction
 */
final class GregorianToHijriConverter implements ConverterInterface
{
    /**
     * @param AlgorithmInterface $algorithm The Hijri algorithm to use (Um Al-Qura, Tabular, etc.)
     */
    public function __construct(
        private readonly AlgorithmInterface $algorithm
    ) {
    }

    /**
     * @param DateTimeImmutable|string $date The Gregorian date to convert
     * @return HijriDate The converted Hijri date
     * @throws InvalidDateException
     */
    public function convert(DateTimeImmutable|string $date): HijriDate
    {
        if (is_string($date)) {
            try {
                $date = new DateTimeImmutable($date);
            } catch (\Exception $e) {
                throw InvalidDateException::invalidGregorianDate($date);
            }
        }

        return $this->algorithm->toHijri($date);
    }
}
