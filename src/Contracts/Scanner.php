<?php

namespace BeInteractive\TranslationScanner\Contracts;

interface Scanner
{
    /**
     * @return array{group: string, key: string, text: array{string, string}}
     */
    public function getLanguageLines(): array;
}
