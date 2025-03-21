<?php

namespace BeInteractive\TranslationScanner\Scanners;

use BeInteractive\TranslationScanner\Contracts\Scanner;

class Laravel implements Scanner
{

    /**
     * @return array{group: string, key: string, text: array{string, string}}
     */
    public static function getLanguageLines(): array
    {
        return [

        ];
    }
}
