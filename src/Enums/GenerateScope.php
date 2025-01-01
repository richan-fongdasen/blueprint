<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Enums;

enum GenerateScope: string
{
    case MIGRATION = 'migration';
    case FACTORY = 'factory';
    case SEEDER = 'seeder';
    case MODEL = 'model';
    case API = 'api';
    case CMS = 'cms';
}
