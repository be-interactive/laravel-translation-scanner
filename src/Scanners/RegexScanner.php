<?php

namespace BeInteractive\TranslationScanner\Scanners;

use BeInteractive\TranslationScanner\Concerns\CanFindFiles;
use BeInteractive\TranslationScanner\Contracts\Scanner;

class RegexScanner implements Scanner
{
    use CanFindFiles;

    protected readonly string $regex;

    protected readonly array $findIn;

    protected readonly array $findPatterns;

    public function __construct(string $regex, ?array $findIn = null, ?array $findPatterns = null)
    {
        $this->regex = $regex;

        $this->findIn = $findIn ?? config('translation-scanner.default_search_in_paths');

        $this->findPatterns = $findPatterns ?? [
            '*.php',
            '*.js',
            '*.vue',
            '*.ts',
        ];
    }

    /**
     * @return array{group: string, key: string, text: array{string, string}}
     */
    public function getLanguageLines(): array
    {
        $languageLines = collect();

        foreach ($this->getFiles($this->findIn, $this->findPatterns) as $file) {
            preg_match_all($this->regex, $file->getContents(), $matches);

            $matches = $matches['key'];

            foreach ($matches as $match) {
                // Ignore keys that contain ::
                if (str($match)->contains('::')) {
                    continue;
                }

                if (is_null($languageLines->where('key', $match)->first())) {
                    $languageLines->add([
                        'group' => '*',
                        'key' => $match,
                        'text' => [
                            'en' => $match,
                        ],
                    ]);
                }
            }
        }

        return $languageLines->toArray();
    }
}
