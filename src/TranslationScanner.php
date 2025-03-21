<?php

namespace BeInteractive\TranslationScanner;

use BeInteractive\TranslationScanner\Actions\SynchronizeAction;
use BeInteractive\TranslationScanner\Concerns\CanHaveScanners;
use BeInteractive\TranslationScanner\Contracts\Scanner;
use BeInteractive\TranslationScanner\Scanners\TranslationFilesScanner;
use Illuminate\Support\Arr;
use Spatie\TranslationLoader\LanguageLine;

class TranslationScanner
{
    use CanHaveScanners;

    public function __construct()
    {
        $this->with(new TranslationFilesScanner);
    }

    public function getLanguageLines(): array
    {
        $languageLines = [];

        /** @var Scanner $scanner */
        foreach ($this->getScanners() as $scanner) {
            $languageLines = array_merge_recursive(
                $languageLines,
                $scanner->getLanguageLines(),
            );
        }

        return $languageLines;
    }

    public function store(bool $deleteLinesThatWereNotScanned = true): array
    {
        $groupsAndKeys = $this->getLanguageLines();

        $result = [
            'total_count' => 0,
        ];

        if ($deleteLinesThatWereNotScanned) {
            $result['deleted_count'] = LanguageLine::query()
                ->whereNotIn('group', array_column($groupsAndKeys, 'group'))
                ->orWhereNotIn('key', array_column($groupsAndKeys, 'key'))
                ->delete();
        } else {
            $result['deleted_count'] = 0;
        }

        $existingLanguageLines = LanguageLine::whereIn('group', array_column($groupsAndKeys, 'group'))
            ->orWhereIn('key', array_column($groupsAndKeys, 'key'))
            ->get();

        foreach ($groupsAndKeys as $groupAndKey) {
            $existingItem = $existingLanguageLines->where('group', $groupAndKey['group'])
                ->where('key', $groupAndKey['key'])
                ->first();

            if (is_null($existingItem)) {
                LanguageLine::create([
                    'group' => $groupAndKey['group'],
                    'key' => $groupAndKey['key'],
                    'text' => $groupAndKey['text'],
                ]);

                $result['total_count'] += 1;
            }
        }

        return $result;
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
