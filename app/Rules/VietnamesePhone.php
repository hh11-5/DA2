<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VietnamesePhone implements Rule
{
    public function passes($attribute, $value)
    {
        // Clean the phone number
        $cleanPhone = preg_replace('/[^0-9]/', '', $value);

        // Convert 84 prefix to 0
        if (str_starts_with($cleanPhone, '84')) {
            $cleanPhone = '0' . substr($cleanPhone, 2);
        }

        // Check pattern
        return preg_match('/^0[3|5|7|8|9][0-9]{8}$/', $cleanPhone);
    }

    public function message()
    {
        return 'Số điện thoại không đúng định dạng Việt Nam.';
    }
}
