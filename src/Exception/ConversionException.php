<?php

declare(strict_types=1);

namespace Tanggalan\Exception;

class ConversionException extends TanggalanException
{
    public static function failedToConvert(string $from, string $to, string $reason = ''): self
    {
        $message = "Failed to convert from {$from} to {$to}";

        if ($reason) {
            $message .= ": {$reason}";
        }

        return new self($message);
    }
}
