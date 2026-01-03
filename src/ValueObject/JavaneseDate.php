<?php

declare(strict_types=1);

namespace Tanggalan\ValueObject;

use DateTimeImmutable;
use Tanggalan\Enum\JavaneseDay;
use Tanggalan\Enum\PasaranDay;

readonly class JavaneseDate
{
    public function __construct(
        public DateTimeImmutable $gregorianDate,
        public Weton $weton,
        public JavaneseDay $day,
        public PasaranDay $pasaran,
    ) {
    }

    public static function create(
        DateTimeImmutable $gregorianDate,
        JavaneseDay $day,
        PasaranDay $pasaran
    ): self {
        return new self(
            gregorianDate: $gregorianDate,
            weton: new Weton($day, $pasaran),
            day: $day,
            pasaran: $pasaran
        );
    }

    public function getWeton(): Weton
    {
        return $this->weton;
    }

    public function getNeptu(): int
    {
        return $this->weton->getNeptu();
    }

    public function format(string $locale = 'id'): string
    {
        return $this->weton->format($locale);
    }

    public function toArray(): array
    {
        return [
            'gregorian_date' => $this->gregorianDate->format('Y-m-d'),
            'weton' => $this->weton->format(),
            'day' => $this->day->getIndonesianName(),
            'pasaran' => $this->pasaran->name,
            'neptu' => $this->getNeptu(),
        ];
    }

    public function __toString(): string
    {
        return $this->format();
    }
}
