<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Enums;

enum InputOptionType: string
{
    case ENUM = 'enum';
    case MODEL = 'model';
    case NESTED_SET = 'nestedSet';
}
