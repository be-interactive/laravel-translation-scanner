<?php

namespace BeInteractive\TranslationScanner\Contracts;

interface Scanner
{
    /**
     * @return array{group: string, key: string, text: array{string, string}}
     */
    public static function getLanguageLines(): array;
}
