<?php

namespace Creative2LLC\FilamentFilter\Commands;

use Illuminate\Console\Command;

class FilamentFilterCommand extends Command
{
    public $signature = 'filament-filter';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
