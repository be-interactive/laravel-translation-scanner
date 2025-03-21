<?php

namespace BeInteractive\TranslationScanner\Scanners;

use BeInteractive\TranslationScanner\Contracts\Scanner;

class FilamentScanner implements Scanner
{

    /**
     * @return array{group: string, key: string, text: array{string, string}}
     */
    public function getLanguageLines(): array
    {
        return [

        ];
    }
}
