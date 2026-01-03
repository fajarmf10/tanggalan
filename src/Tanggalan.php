<?php

declare(strict_types=1);

namespace Tanggalan;

use DateTimeImmutable;
use Tanggalan\Algorithm\AlgorithmInterface;
use Tanggalan\Algorithm\TabularIslamicAlgorithm;
use Tanggalan\Algorithm\UmAlQuraAlgorithm;
use Tanggalan\Calculator\WetonCalculator;
use Tanggalan\Converter\GregorianToHijriConverter;
use Tanggalan\Converter\GregorianToJavaneseConverter;
use Tanggalan\Converter\HijriToGregorianConverter;
use Tanggalan\ValueObject\HijriDate;
use Tanggalan\ValueObject\JavaneseDate;
use Tanggalan\ValueObject\Weton;

/**
 * Main Tanggalan facade class
 *
 * Provides a clean, simple API for date conversions
 * Follows Facade pattern: Simplifies complex subsystem interactions
 */
final class Tanggalan
{
    private GregorianToHijriConverter $gregorianToHijriConverter;
    private HijriToGregorianConverter $hijriToGregorianConverter;
    private GregorianToJavaneseConverter $gregorianToJavaneseConverter;
    private WetonCalculator $wetonCalculator;

    /**
     * @param int $hijriAdjustment Day adjustment for Hijri calendar (-1, 0, or +1)
     * @param AlgorithmInterface|null $algorithm Custom algorithm (defaults to UmAlQura)
     */
    public function __construct(
        private readonly int $hijriAdjustment = 0,
        ?AlgorithmInterface $algorithm = null
    ) {
        // Dependency Injection: Create dependencies
        $algorithm = $algorithm ?? new UmAlQuraAlgorithm($this->hijriAdjustment);
        $this->wetonCalculator = new WetonCalculator();

        $this->gregorianToHijriConverter = new GregorianToHijriConverter($algorithm);
        $this->hijriToGregorianConverter = new HijriToGregorianConverter($algorithm);
        $this->gregorianToJavaneseConverter = new GregorianToJavaneseConverter($this->wetonCalculator);
    }

    /**
     * Convert Gregorian date to Hijri date
     *
     * @param DateTimeImmutable|string $date The Gregorian date (e.g., '2025-01-04')
     * @return HijriDate The Hijri date
     */
    public static function toHijri(DateTimeImmutable|string $date): HijriDate
    {
        $instance = new self();
        return $instance->gregorianToHijriConverter->convert($date);
    }

    /**
     * Convert Gregorian date to Javanese date with Weton
     *
     * @param DateTimeImmutable|string $date The Gregorian date
     * @return JavaneseDate The Javanese date with weton
     */
    public static function toJavanese(DateTimeImmutable|string $date): JavaneseDate
    {
        $instance = new self();
        return $instance->gregorianToJavaneseConverter->convert($date);
    }

    /**
     * Get Weton for a Gregorian date
     *
     * @param DateTimeImmutable|string $date The Gregorian date
     * @return Weton The weton (day + pasaran combination)
     */
    public static function getWeton(DateTimeImmutable|string $date): Weton
    {
        $instance = new self();
        return $instance->wetonCalculator->calculate($date);
    }

    /**
     * Convert Hijri date to Gregorian date
     *
     * @param int $year Hijri year
     * @param int $month Hijri month (1-12)
     * @param int $day Hijri day (1-30)
     * @return DateTimeImmutable The Gregorian date
     */
    public static function fromHijri(int $year, int $month, int $day): DateTimeImmutable
    {
        $instance = new self();
        return $instance->hijriToGregorianConverter->convertFromComponents($year, $month, $day);
    }

    /**
     * Create instance with custom Hijri adjustment
     *
     * Useful for regional differences in moon sighting
     *
     * @param int $adjustment Day adjustment (-1, 0, or +1)
     * @return static
     */
    public static function withAdjustment(int $adjustment): static
    {
        return new self($adjustment);
    }

    /**
     * Create instance with Tabular Islamic Calendar algorithm
     *
     * Pure mathematical algorithm - works for any date!
     * May differ by ±1 day from Um Al-Qura (which uses observations)
     *
     * @param int $adjustment Day adjustment (-1, 0, or +1)
     * @return static
     */
    public static function withTabularAlgorithm(int $adjustment = 0): static
    {
        return new self($adjustment, new TabularIslamicAlgorithm($adjustment));
    }

    /**
     * Create instance with custom algorithm
     *
     * @param AlgorithmInterface $algorithm Custom Hijri algorithm
     * @return static
     */
    public static function withAlgorithm(AlgorithmInterface $algorithm): static
    {
        return new self(0, $algorithm);
    }
}
