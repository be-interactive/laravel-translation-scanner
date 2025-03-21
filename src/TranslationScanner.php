<?php

namespace BeInteractive\TranslationScanner;

use BeInteractive\TranslationScanner\Actions\SynchronizeAction;
use BeInteractive\TranslationScanner\Concerns\CanHaveScanners;
use BeInteractive\TranslationScanner\Contracts\Scanner;
use Illuminate\Support\Arr;

class TranslationScanner
{
    use CanHaveScanners;

    public function getLanguageLines(): array
    {
        $languageLines = [];

        /** @var Scanner $scanner */
        foreach ($this->getScanners() as $scanner) {
            $languageLines = [
                ...$languageLines,
                ...$scanner->getLanguageLines(),
            ];
        }

        return $languageLines;
    }


    /**
     * OLD CODE WHICH CAN BE REMOVED LATER:
     */



    protected bool $filament = false;

    protected array $regexes = [];

    public function withFilament(): static
    {
        $this->filament = true;

        return $this;
    }

    public function withCustomRegex(string|array $regex): static
    {
        $this->regexes = [
            ...$this->regexes,
            ...Arr::wrap($regex),
        ];

        return $this;
    }

    public function scanFiles(): array
    {
        return SynchronizeAction::synchronize(filament: $this->filament);
    }
}
