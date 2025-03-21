<?php

namespace BeInteractive\TranslationScanner\Concerns;

trait CanParseLanguageLines
{
    protected static array $allGroupsAndKeys = [];

    protected static function parseTranslation(array $translationArray, string $locale, string $groupName, ?string $parentKey = null): void
    {
        foreach ($translationArray as $key => $value) {
            $currentKey = $parentKey ? $parentKey.'.'.$key : $key;

            if (is_array($value)) {
                self::parseTranslation($value, $locale, $groupName, $currentKey);
            } else {
                $found = false;

                // Check if the translation is already present and append it
                foreach (self::$allGroupsAndKeys as &$groupAndKey) {
                    if ($groupAndKey['group'] === $groupName && $groupAndKey['key'] === $currentKey) {
                        $groupAndKey['text'][$locale] = $value;
                        $found = true;
                    }
                }

                // Add this group and key pair to the array
                if (! $found) {
                    self::$allGroupsAndKeys[] = [
                        'group' => $groupName,
                        'key' => $currentKey,
                        'text' => [$locale => $value],
                    ];
                }
            }
        }
    }
}
