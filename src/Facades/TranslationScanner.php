<?php

namespace BeInteractive\TranslationScanner\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BeInteractive\TranslationScanner\TranslationScanner
 */
class TranslationScanner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BeInteractive\TranslationScanner\TranslationScanner::class;
    }
}
