<?php

namespace BeInteractive\TranslationScanner\Concerns;

trait CanParseLanguageLines
{
    /**
     * Per-scan accumulator for parsed language lines.
     *
     * This is intentionally an instance property (not a class static) so that the
     * parsed keys never leak across scans/requests on a long-lived worker (e.g. Octane).
     *
     * @var array<int, array{group: string, key: string, text: array<string, string>}>
     */
    protected array $allGroupsAndKeys = [];

    protected function parseTranslation(array $translationArray, string $locale, string $groupName, ?string $parentKey = null): void
    {
        foreach ($translationArray as $key => $value) {
            $currentKey = $parentKey ? $parentKey.'.'.$key : $key;

            if (is_array($value)) {
                $this->parseTranslation($value, $locale, $groupName, $currentKey);
            } else {
                $found = false;

                // Check if the translation is already present and append it
                foreach ($this->allGroupsAndKeys as &$groupAndKey) {
                    if ($groupAndKey['group'] === $groupName && $groupAndKey['key'] === $currentKey) {
                        $groupAndKey['text'][$locale] = $value;
                        $found = true;
                    }
                }

                // Add this group and key pair to the array
                if (! $found) {
                    $this->allGroupsAndKeys[] = [
                        'group' => $groupName,
                        'key' => $currentKey,
                        'text' => [$locale => $value],
                    ];
                }
            }
        }
    }
}
