<?php

declare(strict_types=1);

namespace Tanggalan\Calculator;

use Tanggalan\ValueObject\Weton;

/**
 * Calculator for Neptu values
 *
 * Neptu is the sum of the day value and pasaran value,
 * used in Javanese numerology and divination
 */
final class NeptuCalculator implements CalculatorInterface
{
    public function calculate(mixed $input): int
    {
        if (!$input instanceof Weton) {
            throw new \InvalidArgumentException('Input must be a Weton instance');
        }

        return $input->getNeptu();
    }

    /**
     * Calculate neptu and return interpretation
     */
    public function calculateWithInterpretation(Weton $weton): array
    {
        $neptu = $weton->getNeptu();

        return [
            'neptu' => $neptu,
            'interpretation' => $this->getInterpretation($neptu),
        ];
    }

    /**
     * Get traditional Javanese interpretation of neptu value
     */
    private function getInterpretation(int $neptu): string
    {
        // Traditional Javanese neptu interpretations
        return match (true) {
            $neptu <= 9 => 'Sri (Makmur/Prosperous)',
            $neptu <= 12 => 'Lungguh (Tenang/Calm)',
            $neptu <= 15 => 'Lara (Sengsara/Suffering)',
            $neptu <= 18 => 'Pati (Kematian/Death)',
            default => 'Sri (Makmur/Prosperous)',
        };
    }
}
