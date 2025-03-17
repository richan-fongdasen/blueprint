<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Commands;

use Illuminate\Console\Command;
use RichanFongdasen\Blueprint\Contracts\ConsoleCommand;
use RichanFongdasen\Blueprint\Facades\Blueprint;

class ValidateBlueprintCommand extends Command implements ConsoleCommand
{
    public $signature = 'blueprint:validate {path?}';

    public $description = 'Validate the blueprint files';

    public function handle(): int
    {
        $path = $this->argument('path') ?? base_path('blueprints');

        if (! is_string($path)) {
            $this->error('The path argument must be a string.');

            return self::FAILURE;
        }

        Blueprint::load($path, $this);

        $this->comment('The blueprint files are valid.');

        return self::SUCCESS;
    }
}
