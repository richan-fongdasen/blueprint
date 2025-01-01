<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Enums;

enum InputType: string
{
    /**
     * Basic HTML input types.
     */
    case TEXT = 'text';
    case EMAIL = 'email';
    case NUMBER = 'number';
    case TELEPHONE = 'tel';
    case URL = 'url';
    case PASSWORD = 'password';
    case SELECT = 'select';
    case RADIO = 'radio';
    case CHECKBOX = 'checkbox';
    case TEXTAREA = 'textarea';
    case FILE = 'file';

    /**
     * Special input types.
     */
    case DATE = 'date';
    case TIME = 'time';
    case DATETIME = 'datetime';
    case TOGGLE = 'toggle';
    case RICH_TEXT = 'rich-text';
    case MARKDOWN = 'markdown';
    case SELECT2 = 'select2';
    case TAGS = 'tags';

    public const DEFAULT = self::TEXT;
}
