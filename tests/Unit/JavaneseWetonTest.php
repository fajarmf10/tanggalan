<?php

declare(strict_types=1);

namespace Tanggalan\Tests\Unit;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Tanggalan\Calculator\WetonCalculator;
use Tanggalan\Calculator\NeptuCalculator;
use Tanggalan\Converter\GregorianToJavaneseConverter;
use Tanggalan\Tests\Fixtures\DateFixtures;

final class JavaneseWetonTest extends TestCase
{
    private WetonCalculator $wetonCalculator;
    private GregorianToJavaneseConverter $javaneseConverter;
    private NeptuCalculator $neptuCalculator;

    protected function setUp(): void
    {
        $this->wetonCalculator = new WetonCalculator();
        $this->javaneseConverter = new GregorianToJavaneseConverter($this->wetonCalculator);
        $this->neptuCalculator = new NeptuCalculator();
    }

    /**
     * @dataProvider javaneseWetonProvider
     */
    public function test_weton_calculation(
        string $gregorian,
        string $expectedDay,
        string $expectedPasaran,
        string $expectedWeton,
        int $expectedNeptu
    ): void {
        $weton = $this->wetonCalculator->calculate($gregorian);

        $this->assertSame($expectedDay, $weton->day->getIndonesianName());
        $this->assertSame($expectedPasaran, $weton->pasaran->name);
        $this->assertSame($expectedWeton, $weton->format('id'));
        $this->assertSame($expectedNeptu, $weton->getNeptu());
    }

    /**
     * @dataProvider javaneseWetonProvider
     */
    public function test_javanese_date_conversion(
        string $gregorian,
        string $expectedDay,
        string $expectedPasaran,
        string $expectedWeton,
        int $expectedNeptu
    ): void {
        $javanese = $this->javaneseConverter->convert($gregorian);

        $this->assertSame($expectedDay, $javanese->day->getIndonesianName());
        $this->assertSame($expectedPasaran, $javanese->pasaran->name);
        $this->assertSame($expectedWeton, $javanese->getWeton()->format('id'));
        $this->assertSame($expectedNeptu, $javanese->getNeptu());
    }

    public function test_weton_format_in_javanese(): void
    {
        $weton = $this->wetonCalculator->calculate('2025-01-04');
        $formatted = $weton->format('jv');

        $this->assertStringContainsString('Setu', $formatted); // Javanese for Saturday
        $this->assertStringContainsString('Pon', $formatted);
    }

    public function test_weton_to_array(): void
    {
        $weton = $this->wetonCalculator->calculate('2025-01-04');
        $array = $weton->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('day', $array);
        $this->assertArrayHasKey('day_javanese', $array);
        $this->assertArrayHasKey('pasaran', $array);
        $this->assertArrayHasKey('neptu', $array);
    }

    public function test_javanese_date_to_array(): void
    {
        $javanese = $this->javaneseConverter->convert('2025-01-04');
        $array = $javanese->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('gregorian_date', $array);
        $this->assertArrayHasKey('weton', $array);
        $this->assertArrayHasKey('neptu', $array);
    }

    public function test_neptu_calculation(): void
    {
        $weton = $this->wetonCalculator->calculate('2025-01-04');
        $neptu = $this->neptuCalculator->calculate($weton);

        $this->assertIsInt($neptu);
        $this->assertGreaterThan(0, $neptu);
        $this->assertLessThan(20, $neptu); // Max neptu is 17 (Sabtu 9 + Kliwon 8)
    }

    public function test_neptu_with_interpretation(): void
    {
        $weton = $this->wetonCalculator->calculate('2025-01-04');
        $result = $this->neptuCalculator->calculateWithInterpretation($weton);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('neptu', $result);
        $this->assertArrayHasKey('interpretation', $result);
        $this->assertIsString($result['interpretation']);
    }

    public static function javaneseWetonProvider(): array
    {
        return array_map(fn($data) => [
            $data['gregorian'],
            $data['day'],
            $data['pasaran'],
            $data['weton'],
            $data['neptu'],
        ], DateFixtures::javaneseWetonConversions());
    }
}
