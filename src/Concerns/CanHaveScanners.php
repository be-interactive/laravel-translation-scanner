<?php

namespace BeInteractive\TranslationScanner\Concerns;

use BeInteractive\TranslationScanner\Contracts\Scanner;
use BeInteractive\TranslationScanner\Scanners\FilamentScanner;
use BeInteractive\TranslationScanner\Scanners\LaravelScanner;
use BeInteractive\TranslationScanner\Scanners\RegexScanner;
use Illuminate\Support\Arr;

trait CanHaveScanners
{
    public array $scanners = [];

    public function laravel($enabled = true): static
    {
        if ($enabled) {
            $this->scanners[] = new LaravelScanner;
        }

        return $this;
    }

    public function filament($enabled = true): static
    {
        if ($enabled) {
            $this->scanners[] = new FilamentScanner;
        }

        return $this;
    }

    public function regex(string $regex): static
    {
        $this->scanners[] = new RegexScanner($regex);

        return $this;
    }

    public function with(Scanner|array $scanner): static
    {
        $this->scanners = [
            ...$this->scanners,
            ...Arr::wrap($scanner),
        ];

        return $this;
    }

    public function getScanners(): array
    {
        return $this->scanners;
    }
}
