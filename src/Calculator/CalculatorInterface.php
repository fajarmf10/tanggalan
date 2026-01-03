<?php

declare(strict_types=1);

namespace Tanggalan\Calculator;

/**
 * Base interface for date calculators
 */
interface CalculatorInterface
{
    /**
     * Calculate a specific aspect of a date
     */
    public function calculate(mixed $input): mixed;
}
