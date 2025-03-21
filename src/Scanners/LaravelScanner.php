<?php

namespace BeInteractive\TranslationScanner\Scanners;

use BeInteractive\TranslationScanner\Contracts\Scanner;

class LaravelScanner implements Scanner
{
    /**
     * @return array{group: string, key: string, text: array{string, string}}
     */
    public function getLanguageLines(): array
    {
        $regex = '/(?:\$t|\btrans|__)\(([\'"])(?\'key\'[^\'"]+?)\1\)/';

        return (new RegexScanner($regex))
            ->getLanguageLines();
    }
}
