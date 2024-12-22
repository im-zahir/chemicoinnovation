<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SecureFile implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $allowedMimes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        $allowedExtensions = [
            'jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'
        ];

        // Check file size (10MB max)
        if ($value->getSize() > 10 * 1024 * 1024) {
            $fail('The file size must not exceed 10MB.');
            return;
        }

        // Check MIME type
        if (!in_array($value->getMimeType(), $allowedMimes)) {
            $fail('The file type is not allowed.');
            return;
        }

        // Check file extension
        $extension = strtolower($value->getClientOriginalExtension());
        if (!in_array($extension, $allowedExtensions)) {
            $fail('The file extension is not allowed.');
            return;
        }

        // Additional security checks
        if ($this->containsPhpCode($value)) {
            $fail('The file contains potentially malicious content.');
            return;
        }
    }

    /**
     * Check if file contains PHP code
     */
    private function containsPhpCode($file): bool
    {
        $content = file_get_contents($file->getRealPath());
        $phpPatterns = [
            '/<\?php/i',
            '/<\?=/i',
            '/<\?/i',
            '/eval\s*\(/i',
            '/system\s*\(/i',
            '/exec\s*\(/i',
            '/shell_exec\s*\(/i',
        ];

        foreach ($phpPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }
}
