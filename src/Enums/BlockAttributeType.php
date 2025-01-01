<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Enums;

enum BlockAttributeType: string
{
    case STRING = 'string';
    case INTEGER = 'int';
    case FLOAT = 'float';
    case BOOLEAN = 'boolean';

    public const DEFAULT = self::STRING;
}
