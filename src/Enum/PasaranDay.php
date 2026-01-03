<?php

declare(strict_types=1);

namespace Tanggalan\Enum;

enum PasaranDay: int
{
    case Legi = 1;
    case Pahing = 2;
    case Pon = 3;
    case Wage = 4;
    case Kliwon = 5;

    public function getNeptu(): int
    {
        return match ($this) {
            self::Legi => 5,
            self::Pahing => 9,
            self::Pon => 7,
            self::Wage => 4,
            self::Kliwon => 8,
        };
    }

    public function getIndonesianName(): string
    {
        return $this->name;
    }

    public function getJavaneseName(): string
    {
        return $this->name;
    }

    public static function fromDayNumber(int $dayNumber): self
    {
        $index = (($dayNumber - 1) % 5) + 1;

        return match ($index) {
            1 => self::Legi,
            2 => self::Pahing,
            3 => self::Pon,
            4 => self::Wage,
            5 => self::Kliwon,
        };
    }
}
