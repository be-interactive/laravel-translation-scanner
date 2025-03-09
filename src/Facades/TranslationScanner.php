<?php

namespace Martijn Laffort\TranslationScanner\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Martijn Laffort\TranslationScanner\TranslationScanner
 */
class TranslationScanner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Martijn Laffort\TranslationScanner\TranslationScanner::class;
    }
}
