<?php

declare(strict_types=1);

namespace Tanggalan\ValueObject;

use DateTimeImmutable;
use Tanggalan\Enum\HijriMonth;
use Tanggalan\Exception\InvalidDateException;

readonly class HijriDate
{
    public function __construct(
        public int $year,
        public int $month,
        public int $day,
        public HijriMonth $monthEnum,
    ) {
        if ($month < 1 || $month > 12) {
            throw InvalidDateException::invalidHijriDate($year, $month, $day);
        }

        if ($day < 1 || $day > 30) {
            throw InvalidDateException::invalidHijriDate($year, $month, $day);
        }
    }

    public static function create(int $year, int $month, int $day): self
    {
        return new self(
            year: $year,
            month: $month,
            day: $day,
            monthEnum: HijriMonth::fromMonth($month)
        );
    }

    public function format(string $format = 'd F Y H', string $locale = 'id'): string
    {
        $monthName = match ($locale) {
            'ar' => $this->monthEnum->getArabicName(),
            'en' => $this->monthEnum->getEnglishName(),
            default => $this->monthEnum->getIndonesianName(),
        };

        return str_replace(
            ['d', 'F', 'Y', 'H'],
            [$this->day, $monthName, $this->year, 'H'],
            $format
        );
    }

    public function toArray(): array
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'month_name' => $this->monthEnum->getIndonesianName(),
        ];
    }

    public function __toString(): string
    {
        return $this->format();
    }
}
