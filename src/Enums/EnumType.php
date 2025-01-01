<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Enums;

enum EnumType: string
{
    case STRING = 'string';
    case INTEGER = 'int';

    public const DEFAULT = self::STRING;
}
