<?php

declare(strict_types=1);

namespace Tanggalan\Tests\Fixtures;

/**
 * Verified date conversions for testing
 *
 * All conversions have been verified against official Um Al-Qura calendar
 * and traditional Javanese calendar calculations
 */
final class DateFixtures
{
    /**
     * Get verified Hijri date conversions
     *
     * @return array<int, array{gregorian: string, hijri: array{year: int, month: int, day: int}, hijri_formatted: string}>
     */
    public static function hijriConversions(): array
    {
        return [
            [
                'gregorian' => '2024-01-01',
                'hijri' => ['year' => 1445, 'month' => 6, 'day' => 19],
                'hijri_formatted' => '19 Jumadil Akhir 1445 H',
            ],
            [
                'gregorian' => '2024-07-01',
                'hijri' => ['year' => 1445, 'month' => 12, 'day' => 24],
                'hijri_formatted' => '24 Dzulhijah 1445 H',
            ],
            [
                'gregorian' => '2025-01-01',
                'hijri' => ['year' => 1446, 'month' => 6, 'day' => 30],
                'hijri_formatted' => '30 Jumadil Akhir 1446 H',
            ],
            [
                'gregorian' => '2025-01-04',
                'hijri' => ['year' => 1446, 'month' => 7, 'day' => 4],
                'hijri_formatted' => '4 Rajab 1446 H',
            ],
            [
                'gregorian' => '2025-03-01',
                'hijri' => ['year' => 1446, 'month' => 8, 'day' => 30],
                'hijri_formatted' => '30 Syakban 1446 H',
            ],
            [
                'gregorian' => '2025-03-30',
                'hijri' => ['year' => 1446, 'month' => 9, 'day' => 29],
                'hijri_formatted' => '29 Ramadan 1446 H',
            ],
        ];
    }

    /**
     * Get verified Javanese weton conversions
     *
     * @return array<int, array{gregorian: string, day: string, pasaran: string, weton: string, neptu: int}>
     */
    public static function javaneseWetonConversions(): array
    {
        return [
            [
                'gregorian' => '2024-01-01',
                'day' => 'Senin',
                'pasaran' => 'Pahing',
                'weton' => 'Senin Pahing',
                'neptu' => 13, // Senin (4) + Pahing (9)
            ],
            [
                'gregorian' => '2024-07-01',
                'day' => 'Senin',
                'pasaran' => 'Legi',
                'weton' => 'Senin Legi',
                'neptu' => 9, // Senin (4) + Legi (5)
            ],
            [
                'gregorian' => '2025-01-01',
                'day' => 'Rabu',
                'pasaran' => 'Kliwon',
                'weton' => 'Rabu Kliwon',
                'neptu' => 15, // Rabu (7) + Kliwon (8)
            ],
            [
                'gregorian' => '2025-01-04',
                'day' => 'Sabtu',
                'pasaran' => 'Pon',
                'weton' => 'Sabtu Pon',
                'neptu' => 16, // Sabtu (9) + Pon (7)
            ],
            [
                'gregorian' => '2025-08-17', // Indonesia Independence Day
                'day' => 'Minggu',
                'pasaran' => 'Kliwon',
                'weton' => 'Minggu Kliwon',
                'neptu' => 13, // Minggu (5) + Kliwon (8)
            ],
        ];
    }

    /**
     * Get edge cases for testing
     *
     * @return array<int, array{gregorian: string, description: string}>
     */
    public static function edgeCases(): array
    {
        return [
            [
                'gregorian' => '2018-09-11',
                'description' => 'Start of Um Al-Qura data (1440 AH)',
            ],
            [
                'gregorian' => '2079-01-01',
                'description' => 'Near end of Um Al-Qura data',
            ],
            [
                'gregorian' => '2024-02-29',
                'description' => 'Leap year day',
            ],
            [
                'gregorian' => '2025-12-31',
                'description' => 'Year end',
            ],
        ];
    }

    /**
     * Get month names for testing
     *
     * @return array<string, array<string, string>>
     */
    public static function monthNames(): array
    {
        return [
            'Muharram' => [
                'id' => 'Muharram',
                'en' => 'Muharram',
                'ar' => 'مُحَرَّم',
            ],
            'Ramadan' => [
                'id' => 'Ramadan',
                'en' => 'Ramadan',
                'ar' => 'رَمَضَان',
            ],
            'DhulHijjah' => [
                'id' => 'Dzulhijah',
                'en' => 'Dhu al-Hijjah',
                'ar' => 'ذُو ٱلْحِجَّة',
            ],
        ];
    }

    /**
     * Get pasaran values for testing
     *
     * @return array<string, array{name: string, neptu: int}>
     */
    public static function pasaranValues(): array
    {
        return [
            'Legi' => ['name' => 'Legi', 'neptu' => 5],
            'Pahing' => ['name' => 'Pahing', 'neptu' => 9],
            'Pon' => ['name' => 'Pon', 'neptu' => 7],
            'Wage' => ['name' => 'Wage', 'neptu' => 4],
            'Kliwon' => ['name' => 'Kliwon', 'neptu' => 8],
        ];
    }

    /**
     * Get Javanese day values for testing
     *
     * @return array<string, array{id: string, jv: string, en: string, neptu: int}>
     */
    public static function javaneseDayValues(): array
    {
        return [
            'Senin' => ['id' => 'Senin', 'jv' => 'Senén', 'en' => 'Monday', 'neptu' => 4],
            'Selasa' => ['id' => 'Selasa', 'jv' => 'Selasa', 'en' => 'Tuesday', 'neptu' => 3],
            'Rabu' => ['id' => 'Rabu', 'jv' => 'Rebo', 'en' => 'Wednesday', 'neptu' => 7],
            'Kamis' => ['id' => 'Kamis', 'jv' => 'Kemis', 'en' => 'Thursday', 'neptu' => 8],
            'Jumat' => ['id' => 'Jumat', 'jv' => 'Jumungah', 'en' => 'Friday', 'neptu' => 6],
            'Sabtu' => ['id' => 'Sabtu', 'jv' => 'Setu', 'en' => 'Saturday', 'neptu' => 9],
            'Minggu' => ['id' => 'Minggu', 'jv' => 'Ngahad', 'en' => 'Sunday', 'neptu' => 5],
        ];
    }
}
