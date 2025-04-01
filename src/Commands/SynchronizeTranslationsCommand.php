<?php

namespace BeInteractive\TranslationScanner\Commands;

use BeInteractive\TranslationScanner\Actions\SynchronizeAction;
use BeInteractive\TranslationScanner\Facades\TranslationScanner;
use Illuminate\Console\Command;

class SynchronizeTranslationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:synchronize {filament?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize all application translations';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->components->info('Starting synchronization.');

        $scanner = TranslationScanner::laravel();

        if ($this->argument('filament')) {
            $scanner->filament();
        }

        $storeResult = $scanner->store();

        $this->newLine();

        $this->components->bulletList([
            'synced translations: ' . $storeResult['total_count'],
            'purged translations: ' . $storeResult['deleted_count'],
        ]);

        $this->newLine();

        $this->components->info('Synchronization finished!');
    }
}
