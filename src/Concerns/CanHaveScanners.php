<?php

namespace BeInteractive\TranslationScanner\Concerns;

use BeInteractive\TranslationScanner\Contracts\Scanner;
use BeInteractive\TranslationScanner\Scanners\Filament;
use BeInteractive\TranslationScanner\Scanners\Laravel;

trait CanHaveScanners
{
    public array $scanners = [];

    public function laravel(): static
    {
        $this->scanners[] = new Laravel();

        return $this;
    }

    public function filament(): static
    {
        $this->scanners[] = new Filament();

        return $this;
    }

    public function with(Scanner $scanner): static
    {
        $this->scanners[] = $scanner;

        return $this;
    }

    public function getScanners(): array
    {
        return $this->scanners;
    }
}
