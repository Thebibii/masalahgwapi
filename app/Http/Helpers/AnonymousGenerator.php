<?php

namespace App\Http\Helpers;

use App\Models\User;

class AnonymousGenerator
{
    public static function generateUniqueCode()
    {
        $code = 'lu-';

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);

        // Generate a random code with maximum length of 4 characters
        for ($i = 0; $i < 4; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }

        if (ctype_lower($code)) {
            // If all characters are lowercase, convert one of them to uppercase
            $position = rand(0, 3); // Select a random position in the string
            $code[$position] = strtoupper($code[$position]);
        }
        // Check if the generated code already exists in the database
        if (User::where('anonymous', $code)->exists()) {
            // If code already exists, regenerate it
            return self::generateUniqueCode();
        }

        return $code;
    }
}
