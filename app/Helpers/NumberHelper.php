<?php

namespace App\Helpers;

class NumberHelper
{
    public static function numberToWords($num)
    {
        $num = (float) $num;
        
        if ($num == 0) {
            return "zero";
        }

        $ones = array(
            "", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten",
            "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", 
            "eighteen", "nineteen"
        );
        
        $tens = array(
            "", "", "twenty", "thirty", "forty", "fifty", "sixty", "seventy", "eighty", "ninety"
        );

        if ($num < 20) {
            return $ones[(int)$num];
        } elseif ($num < 100) {
            return $tens[(int)($num / 10)] . " " . $ones[(int)($num % 10)];
        } elseif ($num < 1000) {
            return $ones[(int)($num / 100)] . " hundred " . self::numberToWords($num % 100);
        } elseif ($num < 100000) {
            return self::numberToWords((int)($num / 1000)) . " thousand " . self::numberToWords($num % 1000);
        } elseif ($num < 10000000) {
            return self::numberToWords((int)($num / 100000)) . " lakh " . self::numberToWords($num % 100000);
        } else {
            return self::numberToWords((int)($num / 10000000)) . " crore " . self::numberToWords($num % 10000000);
        }
    }
}