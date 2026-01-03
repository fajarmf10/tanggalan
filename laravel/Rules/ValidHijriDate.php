<?php

declare(strict_types=1);

namespace Tanggalan\Laravel\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Tanggalan\Exception\InvalidDateException;
use Tanggalan\Tanggalan;

/**
 * Validation rule for Hijri dates
 *
 * Usage: 'field' => ['required', new ValidHijriDate()]
 */
class ValidHijriDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            if (!is_string($value)) {
                $fail("The {$attribute} must be a valid date string.");
                return;
            }

            // Try to convert the date to Hijri
            Tanggalan::toHijri($value);
        } catch (InvalidDateException $e) {
            $fail("The {$attribute} is not a valid Gregorian date.");
        } catch (\Exception $e) {
            $fail("The {$attribute} is not a valid date.");
        }
    }
}
