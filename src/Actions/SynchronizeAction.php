<?php

namespace BeInteractive\TranslationScanner\Actions;

use BeInteractive\TranslationScanner\Commands\SynchronizeTranslationsCommand;
use BeInteractive\TranslationScanner\Helpers\Scanner;
use Illuminate\Support\Facades\File;
use Spatie\TranslationLoader\LanguageLine;
use Symfony\Component\Finder\Finder;

class SynchronizeAction
{
    public static function synchronize(?SynchronizeTranslationsCommand $command = null): array
    {
        // Extract all translation groups, keys and text
        $groupsAndKeys = Scanner::scan();

        // Now we add the JSON translations here
        $groupsAndKeys = array_merge_recursive($groupsAndKeys, self::getJsonTranslationGroupsKeys());

        // And now we actually scan the codebase for all translations added
        $groupsAndKeys = self::scanFiles($groupsAndKeys);

        $result = [];
        $result['total_count'] = 0;

        // Find and delete old LanguageLines that no longer exist in the translation files
        $result['deleted_count'] = LanguageLine::query()
            ->whereNotIn('group', array_column($groupsAndKeys, 'group'))
            ->orWhereNotIn('key', array_column($groupsAndKeys, 'key'))
            ->delete();

        // Create new LanguageLines for the groups and keys that don't exist yet
        foreach ($groupsAndKeys as $groupAndKey) {
            $startTime = microtime(true);

            $existingItem = LanguageLine::where('group', $groupAndKey['group'])
                ->where('key', $groupAndKey['key'])
                ->first();

            if (! $existingItem) {
                LanguageLine::create([
                    'group' => $groupAndKey['group'],
                    'key' => $groupAndKey['key'],
                    'text' => $groupAndKey['text'],
                ]);

                $result['total_count'] += 1;

                $runTime = number_format((microtime(true) - $startTime) * 1000, 2);
                $command?->components()->twoColumnDetail($groupAndKey['group'] . '.' . $groupAndKey['key'], "<fg=gray>{$runTime} ms</> <fg=green;options=bold>DONE</>");
            }
        }

        return $result;
    }

    private static function getJsonTranslationGroupsKeys(): array
    {
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

    private static function scanFiles(array $currentGroupsAndKeys): array
    {
        $files = Finder::create()
            ->files()
            ->ignoreDotFiles(true)
            ->name('*.php')
            ->in(app_path())
            ->in(resource_path());

        $translations = collect($currentGroupsAndKeys);

        foreach ($files as $file) {
            preg_match_all('/(?:\$t|\btrans|__)\(([\'"])(?\'key\'[^\'"]+?)\1\)/', $file->getContents(), $matches);

            preg_match_all('/([a-zA-Z\\\\]+)::make\(\'([^\']+)\'\)/', $file->getContents(), $matchesTranslate);

            $allMatches = array_merge($matches['key'], $matchesTranslate[2]);

            foreach ($allMatches as $key) {
                if (str($key)->contains('::')) {
                    continue;
                }

                if (is_null($translations->where('key', $key)->first())) {
                    $translations->add([
                        'group' => '*',
                        'key' => $key,
                        'text' => [
                            'en' => $key,
                        ],
                    ]);
                }
            }
        }

        return $translations->toArray();
    }
}
