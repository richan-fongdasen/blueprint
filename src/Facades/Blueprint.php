<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RichanFongdasen\Blueprint\BlueprintService
 */
class Blueprint extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \RichanFongdasen\Blueprint\BlueprintService::class;
    }
}
