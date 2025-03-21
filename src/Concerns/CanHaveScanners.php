<?php

namespace BeInteractive\TranslationScanner\Concerns;

use BeInteractive\TranslationScanner\Contracts\Scanner;
use BeInteractive\TranslationScanner\Scanners\FilamentScanner;
use BeInteractive\TranslationScanner\Scanners\LaravelScanner;

trait CanHaveScanners
{
    public array $scanners = [];

    public function laravel(): static
    {
        $this->scanners[] = new LaravelScanner();

        return $this;
    }

    public function filament(): static
    {
        $this->scanners[] = new FilamentScanner();

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
