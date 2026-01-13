<?php

if (!function_exists('smart_bangla')) {

    function smart_bangla($text)
    {
        // 1️⃣ HTML entity decode
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // 2️⃣ If already Unicode Bangla → return as is
        if (preg_match('/[\x{0980}-\x{09FF}]/u', $text)) {
            return $text;
        }

        // 3️⃣ If normal English → return as is
        if (preg_match('/^[\x00-\x7F\s\p{P}]+$/u', $text)) {
            return $text;
        }

        // 4️⃣ Bijoy → Unicode map (basic but safe)
        $bijoyMap = [
            'Av' => 'আ','B'=>'ই','C'=>'ঈ','D'=>'উ','E'=>'ঊ','F'=>'ঋ',
            'G'=>'এ','H'=>'ঐ','I'=>'ও','J'=>'ঔ','K'=>'ক','L'=>'খ',
            'M'=>'গ','N'=>'ঘ','O'=>'ঙ','P'=>'চ','Q'=>'ছ','R'=>'জ',
            'S'=>'ঝ','T'=>'ঞ','U'=>'ট','V'=>'ঠ','W'=>'ড','X'=>'ঢ',
            'Y'=>'ণ','Z'=>'ত','_'=>'থ','`'=>'দ','a'=>'ধ','b'=>'ন',
            'c'=>'প','d'=>'ফ','e'=>'ব','f'=>'ভ','g'=>'ম','h'=>'য',
            'i'=>'র','j'=>'ল','k'=>'শ','l'=>'ষ','m'=>'স','n'=>'হ',
            'o'=>'ড়','p'=>'ঢ়','q'=>'য়','r'=>'ৎ','s'=>'ং','t'=>'ঃ','u'=>'ঁ',
        ];

        return strtr($text, $bijoyMap);
    }
}
