<?php

use Illuminate\Validation\ValidationException;
use RichanFongdasen\Blueprint\Blueprints\EntityRelationBlueprint;
use RichanFongdasen\Blueprint\Enums\RelationType;

it('raises exception if the name property is missing', function () {
    EntityRelationBlueprint::make([
        'relatedEntity' => 'User',
        'type'          => RelationType::BELONGS_TO->value,
    ]);
})->throws(ValidationException::class);

it('raises exception if the relatedEntity property is missing', function () {
    EntityRelationBlueprint::make([
        'name' => 'roles',
        'type' => RelationType::HAS_MANY->value,
    ]);
})->throws(ValidationException::class);

it('raises exception if the type property is missing', function () {
    EntityRelationBlueprint::make([
        'name'          => 'roles',
        'relatedEntity' => 'Role',
    ]);
})->throws(ValidationException::class);

it('raises exception if the pivotTable property is missing for belongsToMany relation', function () {
    EntityRelationBlueprint::make([
        'name'          => 'roles',
        'relatedEntity' => 'Role',
        'type'          => RelationType::BELONGS_TO_MANY->value,
    ]);
})->throws(ValidationException::class);

it('raises exception if the throughEntity property is missing for hasManyThrough relation', function () {
    EntityRelationBlueprint::make([
        'name'          => 'roles',
        'relatedEntity' => 'Role',
        'type'          => RelationType::HAS_MANY_THROUGH->value,
    ]);
})->throws(ValidationException::class);

it('raises exception if the throughEntity property is missing for hasOneThrough relation', function () {
    EntityRelationBlueprint::make([
        'name'          => 'roles',
        'relatedEntity' => 'Role',
        'type'          => RelationType::HAS_ONE_THROUGH->value,
    ]);
})->throws(ValidationException::class);

it('can be instantiated with minimum required properties', function () {
    $blueprint = EntityRelationBlueprint::make([
        'name'          => 'roles',
        'relatedEntity' => 'Role',
        'type'          => RelationType::HAS_MANY->value,
    ]);

    expect($blueprint->name)->toBe('roles')
        ->and($blueprint->relatedEntity)->toBe('Role')
        ->and($blueprint->type)->toBe(RelationType::HAS_MANY)
        ->and($blueprint->pivotTable)->toBeNull()
        ->and($blueprint->throughEntity)->toBeNull();
});

it('can be instantiated with all properties', function () {
    $blueprint = EntityRelationBlueprint::make([
        'name'          => 'roles',
        'relatedEntity' => 'Role',
        'type'          => RelationType::HAS_MANY_THROUGH->value,
        'throughEntity' => 'User',
    ]);

    expect($blueprint->name)->toBe('roles')
        ->and($blueprint->relatedEntity)->toBe('Role')
        ->and($blueprint->type)->toBe(RelationType::HAS_MANY_THROUGH)
        ->and($blueprint->pivotTable)->toBeNull()
        ->and($blueprint->throughEntity)->toBe('User');
});

it('can be instantiated with pivotTable property for belongsToMany relation', function () {
    $blueprint = EntityRelationBlueprint::make([
        'name'          => 'roles',
        'relatedEntity' => 'Role',
        'type'          => RelationType::BELONGS_TO_MANY->value,
        'pivotTable'    => 'role_user',
    ]);

    expect($blueprint->name)->toBe('roles')
        ->and($blueprint->relatedEntity)->toBe('Role')
        ->and($blueprint->type)->toBe(RelationType::BELONGS_TO_MANY)
        ->and($blueprint->pivotTable)->toBe('role_user')
        ->and($blueprint->throughEntity)->toBeNull();
});
