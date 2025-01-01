<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Enums;

/**
 * The enum of entity attribute types.
 *
 * This enum class is used to define the available types of entity attributes,
 * which can be used to determine the data type of the entity attribute in the migration file.
 */
enum EntityAttributeType: string
{
    case BIG_INTEGER = 'bigInteger';
    case BOOLEAN = 'boolean';
    case CHAR = 'char';
    case DATE = 'date';
    case DATETIME = 'dateTime';
    case DOUBLE = 'double';
    case FLOAT = 'float';
    case INTEGER = 'integer';
    case IP_ADDRESS = 'ipAddress';
    case JSON = 'json';
    case LONG_TEXT = 'longText';
    case MAC_ADDRESS = 'macAddress';
    case MEDIUM_INTEGER = 'mediumInteger';
    case MEDIUM_TEXT = 'mediumText';
    case SMALL_INTEGER = 'smallInteger';
    case STRING = 'string';
    case TEXT = 'text';
    case TIME = 'time';
    case TIMESTAMP = 'timestamp';
    case TINY_INTEGER = 'tinyInteger';
    case TINY_TEXT = 'tinyText';
    case UNSIGNED_BIG_INTEGER = 'unsignedBigInteger';
    case UNSIGNED_INTEGER = 'unsignedInteger';
    case UNSIGNED_MEDIUM_INTEGER = 'unsignedMediumInteger';
    case UNSIGNED_SMALL_INTEGER = 'unsignedSmallInteger';
    case UNSIGNED_TINY_INTEGER = 'unsignedTinyInteger';
    case ULID = 'ulid';
    case UUID = 'uuid';
    case YEAR = 'year';

    public const DEFAULT = self::STRING;
}
