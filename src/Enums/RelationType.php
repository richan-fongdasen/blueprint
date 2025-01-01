<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Enums;

enum RelationType: string
{
    case BELONGS_TO = 'belongsTo';
    case BELONGS_TO_MANY = 'belongsToMany';
    case HAS_MANY = 'hasMany';
    case HAS_MANY_THROUGH = 'hasManyThrough';
    case HAS_ONE = 'hasOne';
    case HAS_ONE_THROUGH = 'hasOneThrough';
}
