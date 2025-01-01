<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Enums;

enum MediaType: string
{
    case FILE = 'file';
    case IMAGE = 'image';

    public const DEFAULT = self::IMAGE;
}
