<?php

namespace BeInteractive\TranslationScanner;

use BeInteractive\TranslationScanner\Actions\SynchronizeAction;

class TranslationScanner
{
    protected bool $filament = false;

    public function filament(): static
    {
        $this->filament = true;

        return $this;
    }

    public function scanFiles()
    {
        SynchronizeAction::synchronize(filament: $this->filament);
    }
}
