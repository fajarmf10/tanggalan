<?php

declare(strict_types=1);

namespace Tanggalan\Enum;

enum HijriMonth: int
{
    case Muharram = 1;
    case Safar = 2;
    case RabiulAwal = 3;
    case RabiulAkhir = 4;
    case JumadilAwal = 5;
    case JumadilAkhir = 6;
    case Rajab = 7;
    case Shaban = 8;
    case Ramadan = 9;
    case Shawwal = 10;
    case DhulQadah = 11;
    case DhulHijjah = 12;

    public function getArabicName(): string
    {
        return match ($this) {
            self::Muharram => 'مُحَرَّم',
            self::Safar => 'صَفَر',
            self::RabiulAwal => 'رَبِيع ٱلْأَوَّل',
            self::RabiulAkhir => 'رَبِيع ٱلثَّانِي',
            self::JumadilAwal => 'جُمَادَىٰ ٱلْأُولَىٰ',
            self::JumadilAkhir => 'جُمَادَىٰ ٱلثَّانِيَة',
            self::Rajab => 'رَجَب',
            self::Shaban => 'شَعْبَان',
            self::Ramadan => 'رَمَضَان',
            self::Shawwal => 'شَوَّال',
            self::DhulQadah => 'ذُو ٱلْقَعْدَة',
            self::DhulHijjah => 'ذُو ٱلْحِجَّة',
        };
    }

    public function getIndonesianName(): string
    {
        return match ($this) {
            self::Muharram => 'Muharram',
            self::Safar => 'Safar',
            self::RabiulAwal => 'Rabiul Awal',
            self::RabiulAkhir => 'Rabiul Akhir',
            self::JumadilAwal => 'Jumadil Awal',
            self::JumadilAkhir => 'Jumadil Akhir',
            self::Rajab => 'Rajab',
            self::Shaban => 'Syakban',
            self::Ramadan => 'Ramadan',
            self::Shawwal => 'Syawal',
            self::DhulQadah => 'Dzulkaidah',
            self::DhulHijjah => 'Dzulhijah',
        };
    }

    public function getEnglishName(): string
    {
        return match ($this) {
            self::Muharram => 'Muharram',
            self::Safar => 'Safar',
            self::RabiulAwal => "Rabi' al-Awwal",
            self::RabiulAkhir => "Rabi' al-Akhir",
            self::JumadilAwal => 'Jumada al-Ula',
            self::JumadilAkhir => 'Jumada al-Akhirah',
            self::Rajab => 'Rajab',
            self::Shaban => "Sha'ban",
            self::Ramadan => 'Ramadan',
            self::Shawwal => 'Shawwal',
            self::DhulQadah => "Dhu al-Qa'dah",
            self::DhulHijjah => 'Dhu al-Hijjah',
        };
    }

    public static function fromMonth(int $month): self
    {
        return match ($month) {
            1 => self::Muharram,
            2 => self::Safar,
            3 => self::RabiulAwal,
            4 => self::RabiulAkhir,
            5 => self::JumadilAwal,
            6 => self::JumadilAkhir,
            7 => self::Rajab,
            8 => self::Shaban,
            9 => self::Ramadan,
            10 => self::Shawwal,
            11 => self::DhulQadah,
            12 => self::DhulHijjah,
        };
    }
}
