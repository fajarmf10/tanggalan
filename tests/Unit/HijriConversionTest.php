<?php

declare(strict_types=1);

namespace Tanggalan\Tests\Unit;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Tanggalan\Algorithm\UmAlQuraAlgorithm;
use Tanggalan\Converter\GregorianToHijriConverter;
use Tanggalan\Converter\HijriToGregorianConverter;
use Tanggalan\Exception\InvalidDateException;
use Tanggalan\Tests\Fixtures\DateFixtures;

final class HijriConversionTest extends TestCase
{
    private GregorianToHijriConverter $toHijriConverter;
    private HijriToGregorianConverter $fromHijriConverter;

    protected function setUp(): void
    {
        $algorithm = new UmAlQuraAlgorithm();
        $this->toHijriConverter = new GregorianToHijriConverter($algorithm);
        $this->fromHijriConverter = new HijriToGregorianConverter($algorithm);
    }

    /**
     * @dataProvider hijriConversionProvider
     */
    public function test_gregorian_to_hijri_conversion(
        string $gregorian,
        array $expectedHijri,
        string $expectedFormatted
    ): void {
        $hijri = $this->toHijriConverter->convert($gregorian);

        $this->assertSame($expectedHijri['year'], $hijri->year);
        $this->assertSame($expectedHijri['month'], $hijri->month);
        $this->assertSame($expectedHijri['day'], $hijri->day);
        $this->assertSame($expectedFormatted, $hijri->format('d F Y H', 'id'));
    }

    /**
     * @dataProvider hijriConversionProvider
     */
    public function test_hijri_to_gregorian_conversion(
        string $expectedGregorian,
        array $hijri
    ): void {
        $gregorian = $this->fromHijriConverter->convertFromComponents(
            $hijri['year'],
            $hijri['month'],
            $hijri['day']
        );

        $this->assertSame($expectedGregorian, $gregorian->format('Y-m-d'));
    }

    public function test_hijri_conversion_with_datetime_immutable(): void
    {
        $date = new DateTimeImmutable('2025-01-04');
        $hijri = $this->toHijriConverter->convert($date);

        $this->assertSame(1446, $hijri->year);
        $this->assertSame(7, $hijri->month);
    }

    public function test_invalid_gregorian_date_throws_exception(): void
    {
        $this->expectException(InvalidDateException::class);
        $this->toHijriConverter->convert('invalid-date');
    }

    public function test_hijri_date_to_array(): void
    {
        $hijri = $this->toHijriConverter->convert('2025-01-04');
        $array = $hijri->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('year', $array);
        $this->assertArrayHasKey('month', $array);
        $this->assertArrayHasKey('day', $array);
        $this->assertArrayHasKey('month_name', $array);
    }

    public function test_hijri_date_to_string(): void
    {
        $hijri = $this->toHijriConverter->convert('2025-01-04');
        $string = (string) $hijri;

        $this->assertStringContainsString('1446', $string);
        $this->assertStringContainsString('Rajab', $string);
    }

    public static function hijriConversionProvider(): array
    {
        return array_map(fn($data) => [
            $data['gregorian'],
            $data['hijri'],
            $data['hijri_formatted'],
        ], DateFixtures::hijriConversions());
    }
}
