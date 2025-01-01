<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Enums;

enum DataFormat: string
{
    case ACTIVE_URL = 'active_url';
    case ALPHA = 'alpha:ascii';
    case ALPHA_DASH = 'alpha_dash:ascii';
    case ALPHA_NUM = 'alpha_num:ascii';
    case BOOLEAN = 'boolean';
    case DATE = 'date_format:Y-m-d';
    case DATETIME = 'date_format:Y-m-d H:i';
    case EMAIL = 'email';
    case FILE = 'file';
    case IMAGE = 'image';
    case INTEGER = 'integer';
    case IPV4 = 'ipv4';
    case IPV6 = 'ipv6';
    case LOWERCASE = 'lowercase';
    case MAC_ADDRESS = 'mac_address';
    case NUMERIC = 'numeric';
    case STRING = 'string';
    case TIME = 'date_format:H:i:s';
    case UPPERCASE = 'uppercase';
    case URL = 'url';
    case ULID = 'ulid';
    case UUID = 'uuid';

    public const DEFAULT = self::STRING;
}
