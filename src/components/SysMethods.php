<?php

namespace Components;

class SysMethods
{

    /**
     * Генерація токену
     * @return string
     */
    public static function generateToken(int $length = 32)
    {
        if ($length < 10) {
            $chars = 'abdefhiknrstyz23456789';
        } else {
            $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        }

        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }

        return $string;
    }
}
