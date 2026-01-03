<?php

declare(strict_types=1);

namespace Tanggalan\Converter;

use DateTimeImmutable;

/**
 * Base interface for date converters
 */
interface ConverterInterface
{
    /**
     * Convert a date from one calendar system to another
     */
    public function convert(DateTimeImmutable|string $date): mixed;
}
