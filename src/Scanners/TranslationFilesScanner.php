<?php

namespace BeInteractive\TranslationScanner\Scanners;

use BeInteractive\TranslationScanner\Concerns\CanParseLanguageLines;
use BeInteractive\TranslationScanner\Contracts\Scanner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TranslationFilesScanner implements Scanner
{
    use CanParseLanguageLines;

    /**
     * @return array{group: string, key: string, text: array{string, string}}
     */
    public function getLanguageLines(): array
    {
        return array_merge_recursive(
            self::fromPhpLangFiles(),
            self::fromJsonLangFiles(),
        );
    }

    private static function fromPhpLangFiles(): array
    {
        if (! is_dir(lang_path())) {
            return [];
        }

        $files = File::allFiles(lang_path());

        // Loop through all groups
        foreach ($files as $file) {
            // Skip any other files than .php language files e.g. JSON files
            if ($file->getExtension() != 'php') {
                continue;
            }

            // Sanitize the file name and explode to allow checking
            $name = Str::replace('.php', '', $file->getRelativePathname());
            $nameParts = explode(DIRECTORY_SEPARATOR, $name);

            if ($nameParts[0] == 'vendor') {
                continue;
            }

            $groupName = $file->getFilenameWithoutExtension();

            // Load the data from the file
            self::parseTranslation(require $file, $nameParts[0], $groupName);
        }

        return self::$allGroupsAndKeys;
    }

    private static function fromJsonLangFiles(): array
    {
        if (! is_dir(lang_path())) {
            return [];
        }

        $files = File::allFiles(lang_path());

        $translations = collect();

        // Loop through all groups
        foreach ($files as $file) {
            // Skip any other files than .php language files e.g. JSON files
            if ($file->getExtension() !== 'json') {
                continue;
            }

            $locale = $file->getFilenameWithoutExtension();

            $jsonArray = json_decode(file_get_contents($file), true);

            foreach ($jsonArray as $original => $translationItem) {
                $currentTranslation = $translations->get($original, function () use ($original) {
                    return [
                        'group' => '*',
                        'key' => $original,
                        'text' => [],
                    ];
                });

                $currentTranslation['text'][$locale] = $translationItem;

                $translations->put($original, $currentTranslation);
            }
        }

        return $translations->values()->toArray();
    }
}
