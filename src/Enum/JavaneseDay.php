<?php

declare(strict_types=1);

namespace Tanggalan\Enum;

enum JavaneseDay: int
{
    case Senin = 1;      // Monday
    case Selasa = 2;     // Tuesday
    case Rabu = 3;       // Wednesday
    case Kamis = 4;      // Thursday
    case Jumat = 5;      // Friday
    case Sabtu = 6;      // Saturday
    case Minggu = 7;     // Sunday

    public function getNeptu(): int
    {
        return match ($this) {
            self::Senin => 4,
            self::Selasa => 3,
            self::Rabu => 7,
            self::Kamis => 8,
            self::Jumat => 6,
            self::Sabtu => 9,
            self::Minggu => 5,
        };
    }

    public function getIndonesianName(): string
    {
        return $this->name;
    }

    public function getJavaneseName(): string
    {
        return match ($this) {
            self::Senin => 'Senén',
            self::Selasa => 'Selasa',
            self::Rabu => 'Rebo',
            self::Kamis => 'Kemis',
            self::Jumat => 'Jumungah',
            self::Sabtu => 'Setu',
            self::Minggu => 'Ngahad',
        };
    }

    public function getEnglishName(): string
    {
        return match ($this) {
            self::Senin => 'Monday',
            self::Selasa => 'Tuesday',
            self::Rabu => 'Wednesday',
            self::Kamis => 'Thursday',
            self::Jumat => 'Friday',
            self::Sabtu => 'Saturday',
            self::Minggu => 'Sunday',
        };
    }

    public static function fromDayOfWeek(int $dayOfWeek): self
    {
        return match ($dayOfWeek) {
            1 => self::Senin,
            2 => self::Selasa,
            3 => self::Rabu,
            4 => self::Kamis,
            5 => self::Jumat,
            6 => self::Sabtu,
            7, 0 => self::Minggu,
        };
    }
}
