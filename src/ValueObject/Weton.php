<?php

declare(strict_types=1);

namespace Tanggalan\ValueObject;

use Tanggalan\Enum\JavaneseDay;
use Tanggalan\Enum\PasaranDay;

readonly class Weton
{
    public function __construct(
        public JavaneseDay $day,
        public PasaranDay $pasaran,
    ) {
    }

    public function getNeptu(): int
    {
        return $this->day->getNeptu() + $this->pasaran->getNeptu();
    }

    public function format(string $locale = 'id'): string
    {
        $dayName = match ($locale) {
            'jv' => $this->day->getJavaneseName(),
            'en' => $this->day->getEnglishName(),
            default => $this->day->getIndonesianName(),
        };

        $pasaranName = $this->pasaran->name;

        return "{$dayName} {$pasaranName}";
    }

    public function toArray(): array
    {
        return [
            'day' => $this->day->getIndonesianName(),
            'day_javanese' => $this->day->getJavaneseName(),
            'pasaran' => $this->pasaran->name,
            'neptu' => $this->getNeptu(),
        ];
    }

    public function __toString(): string
    {
        return $this->format();
    }
}
