<?php

declare(strict_types=1);

namespace Tanggalan\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tanggalan\Enum\HijriMonth;
use Tanggalan\Enum\JavaneseDay;
use Tanggalan\Enum\PasaranDay;
use Tanggalan\Tests\Fixtures\DateFixtures;

final class EnumTest extends TestCase
{
    public function test_hijri_month_names_in_indonesian(): void
    {
        $this->assertSame('Muharram', HijriMonth::Muharram->getIndonesianName());
        $this->assertSame('Ramadan', HijriMonth::Ramadan->getIndonesianName());
        $this->assertSame('Dzulhijah', HijriMonth::DhulHijjah->getIndonesianName());
    }

    public function test_hijri_month_names_in_english(): void
    {
        $this->assertSame('Muharram', HijriMonth::Muharram->getEnglishName());
        $this->assertSame('Ramadan', HijriMonth::Ramadan->getEnglishName());
        $this->assertSame('Dhu al-Hijjah', HijriMonth::DhulHijjah->getEnglishName());
    }

    public function test_hijri_month_names_in_arabic(): void
    {
        $monthNames = DateFixtures::monthNames();

        $this->assertSame($monthNames['Muharram']['ar'], HijriMonth::Muharram->getArabicName());
        $this->assertSame($monthNames['Ramadan']['ar'], HijriMonth::Ramadan->getArabicName());
    }

    public function test_hijri_month_from_month_number(): void
    {
        $this->assertSame(HijriMonth::Muharram, HijriMonth::fromMonth(1));
        $this->assertSame(HijriMonth::Ramadan, HijriMonth::fromMonth(9));
        $this->assertSame(HijriMonth::DhulHijjah, HijriMonth::fromMonth(12));
    }

    public function test_pasaran_day_neptu_values(): void
    {
        $pasaranValues = DateFixtures::pasaranValues();

        $this->assertSame($pasaranValues['Legi']['neptu'], PasaranDay::Legi->getNeptu());
        $this->assertSame($pasaranValues['Pahing']['neptu'], PasaranDay::Pahing->getNeptu());
        $this->assertSame($pasaranValues['Pon']['neptu'], PasaranDay::Pon->getNeptu());
        $this->assertSame($pasaranValues['Wage']['neptu'], PasaranDay::Wage->getNeptu());
        $this->assertSame($pasaranValues['Kliwon']['neptu'], PasaranDay::Kliwon->getNeptu());
    }

    public function test_pasaran_day_from_day_number(): void
    {
        $this->assertSame(PasaranDay::Legi, PasaranDay::fromDayNumber(1));
        $this->assertSame(PasaranDay::Pahing, PasaranDay::fromDayNumber(2));
        $this->assertSame(PasaranDay::Pon, PasaranDay::fromDayNumber(3));
        $this->assertSame(PasaranDay::Wage, PasaranDay::fromDayNumber(4));
        $this->assertSame(PasaranDay::Kliwon, PasaranDay::fromDayNumber(5));
    }

    public function test_javanese_day_neptu_values(): void
    {
        $dayValues = DateFixtures::javaneseDayValues();

        $this->assertSame($dayValues['Senin']['neptu'], JavaneseDay::Senin->getNeptu());
        $this->assertSame($dayValues['Sabtu']['neptu'], JavaneseDay::Sabtu->getNeptu());
        $this->assertSame($dayValues['Minggu']['neptu'], JavaneseDay::Minggu->getNeptu());
    }

    public function test_javanese_day_names(): void
    {
        $dayValues = DateFixtures::javaneseDayValues();

        $this->assertSame($dayValues['Senin']['id'], JavaneseDay::Senin->getIndonesianName());
        $this->assertSame($dayValues['Senin']['jv'], JavaneseDay::Senin->getJavaneseName());
        $this->assertSame($dayValues['Senin']['en'], JavaneseDay::Senin->getEnglishName());
    }

    public function test_javanese_day_from_day_of_week(): void
    {
        $this->assertSame(JavaneseDay::Senin, JavaneseDay::fromDayOfWeek(1));
        $this->assertSame(JavaneseDay::Minggu, JavaneseDay::fromDayOfWeek(7));
        $this->assertSame(JavaneseDay::Minggu, JavaneseDay::fromDayOfWeek(0));
    }
}
