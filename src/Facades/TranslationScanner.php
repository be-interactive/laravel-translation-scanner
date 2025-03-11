<?php

namespace MartijnLaffort\TranslationScanner\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MartijnLaffort\TranslationScanner\TranslationScanner
 */
class TranslationScanner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MartijnLaffort\TranslationScanner\TranslationScanner::class;
    }
}
