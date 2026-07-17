<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IndonesianPhone implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $clean = preg_replace('/[\s\-\.\+]/', '', $value);

        if (str_starts_with($clean, '628')) {
            $clean = '0' . substr($clean, 2);
        }

        if (str_starts_with($clean, '62')) {
            $clean = '0' . substr($clean, 2);
        }

        $pattern = '/^08(11|12|13|14|15|16|17|18|19|21|22|23|27|28|31|32|33|38|51|52|53|55|56|57|58|59|77|78|81|82|83|84|85|86|87|88|89|95|96|97|98|99)[0-9]{6,9}$/';

        if (!preg_match($pattern, $clean)) {
            $fail('Format nomor telepon tidak valid. Gunakan format: 08xxxxxxxxxx');
        }
    }
}
