{{-- Boost guideline for be-interactive/laravel-translation-scanner. Update when the public API changes. --}}
# Translation Scanner (syncs found keys to DB)

- Scans code and lang files for translation keys, storing them as spatie/laravel-translation-loader `LanguageLine` rows.

## Structure

- `BeInteractive\TranslationScanner\Facades\TranslationScanner` — fluent entry point.
- `BeInteractive\TranslationScanner\Contracts\Scanner` — implement `getLanguageLines(): array` returning rows of `group`, `key`, `text` (locale-keyed).
- Built-in scanners: lang files (always on), `laravel()` (`__`/`trans` calls), `filament()` (`::make('...')` keys), `regex($pattern)` (needs a named `key` group).

## Using it

- Chain scanners, then store: `TranslationScanner::laravel()->filament()->with(new MyScanner)->store()`.
- `store()` deletes rows whose `group` or `key` appears nowhere in the scan results — pass `deleteLinesThatWereNotScanned: false` to keep them. Existing rows are never overwritten.
- Config `translation-scanner.default_search_in_paths`: dirs the regex-based scanners search.

## Pitfalls

- **The `translations:synchronize {filament?}` command ships unregistered** — call the facade or register it yourself.
- **Manual `language_lines` rows survive `store()` only if the scan finds both their `group` and `key`** — otherwise the purge deletes them.
