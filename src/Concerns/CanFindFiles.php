<?php

namespace BeInteractive\TranslationScanner\Concerns;

use Iterator;
use Symfony\Component\Finder\Finder;

trait CanFindFiles
{
    public function getFiles(array $in, array $patterns): Iterator
    {
        return Finder::create()
            ->files()
            ->ignoreDotFiles(true)
            ->name($patterns)
            ->in($in)
            ->getIterator();
    }
}
