<?php

use Illuminate\Validation\ValidationException;
use RichanFongdasen\Blueprint\Blueprints\EntityBlueprint;
use RichanFongdasen\Blueprint\Enums\GenerateScope;

it('raises exception if the name property is missing', function () {
    EntityBlueprint::make([
        'attributes' => [
            [
                'name'   => 'name',
                'format' => ['string'],
            ],
        ],
        'generates' => ['migration', 'factory'],
    ]);
})->throws(ValidationException::class);

it('raises exception if the attributes property is missing', function () {
    EntityBlueprint::make([
        'name'      => 'User',
        'generates' => ['migration', 'factory'],
    ]);
})->throws(ValidationException::class);

it('raises exception if the attributes property is not an array', function () {
    EntityBlueprint::make([
        'name'       => 'User',
        'attributes' => 'invalid',
        'generates'  => ['migration', 'factory'],
    ]);
})->throws(ValidationException::class);

it('raises exception if the attributes property is an empty array', function () {
    EntityBlueprint::make([
        'name'       => 'User',
        'attributes' => [],
        'generates'  => ['migration', 'factory'],
    ]);
})->throws(ValidationException::class);

it('raises exception if the generates property is missing', function () {
    EntityBlueprint::make([
        'name'       => 'User',
        'attributes' => [
            [
                'name'   => 'name',
                'format' => ['string'],
            ],
        ],
    ]);
})->throws(ValidationException::class);

it('raises exception if the generates property is not an array', function () {
    EntityBlueprint::make([
        'name'       => 'User',
        'attributes' => [
            [
                'name'   => 'name',
                'format' => ['string'],
            ],
        ],
        'generates' => 'model',
    ]);
})->throws(ValidationException::class);

it('raises exception if the generates property is an empty array', function () {
    EntityBlueprint::make([
        'name'       => 'User',
        'attributes' => [
            [
                'name'   => 'name',
                'format' => ['string'],
            ],
        ],
        'generates' => [],
    ]);
})->throws(ValidationException::class);

it('raises exception if the generates property contains invalid value', function () {
    EntityBlueprint::make([
        'name'       => 'User',
        'attributes' => [
            [
                'name'   => 'name',
                'format' => ['string'],
            ],
        ],
        'generates' => ['invalid'],
    ]);
})->throws(ValidationException::class);

it('can be instantiated with minimum required properties', function () {
    $blueprint = EntityBlueprint::make([
        'name'       => 'user',
        'attributes' => [
            [
                'name'   => 'name',
                'format' => ['string'],
            ],
        ],
        'generates' => ['migration', 'factory'],
    ]);

    expect($blueprint->name)->toBe('User')
        ->and($blueprint->table)->toBe('users')
        ->and($blueprint->primaryKey)->toBe('id')
        ->and($blueprint->foreignKey)->toBe('user_id')
        ->and($blueprint->displayAttribute)->toBe('name')
        ->and($blueprint->attributes)->toHaveCount(1)
        ->and($blueprint->media)->toHaveCount(0)
        ->and($blueprint->relations)->toHaveCount(0)
        ->and($blueprint->timestamps)->toBeTrue()
        ->and($blueprint->softDeletes)->toBeFalse()
        ->and($blueprint->generates)->toHaveCount(2)
        ->and($blueprint->generates->contains(GenerateScope::MIGRATION->value))->toBeTrue()
        ->and($blueprint->generates->contains(GenerateScope::FACTORY->value))->toBeTrue();
});

it('can be instantiated with all available properties', function () {
    $blueprint = EntityBlueprint::make([
        'name'             => 'User',
        'table'            => 'users',
        'primaryKey'       => 'user_id',
        'foreignKey'       => 'user_id',
        'displayAttribute' => 'name',
        'attributes'       => [
            [
                'name'   => 'name',
                'format' => ['string'],
            ],
        ],
        'media' => [
            [
                'name'   => 'avatar',
                'format' => ['image'],
            ],
        ],
        'relations' => [
            [
                'name'          => 'posts',
                'relatedEntity' => 'Post',
                'type'          => 'hasMany',
            ],
        ],
        'timestamps'  => false,
        'softDeletes' => true,
        'generates'   => ['migration', 'factory', 'model', 'api', 'cms'],
    ]);

    expect($blueprint->name)->toBe('User')
        ->and($blueprint->table)->toBe('users')
        ->and($blueprint->primaryKey)->toBe('user_id')
        ->and($blueprint->foreignKey)->toBe('user_id')
        ->and($blueprint->displayAttribute)->toBe('name')
        ->and($blueprint->attributes)->toHaveCount(1)
        ->and($blueprint->media)->toHaveCount(1)
        ->and($blueprint->relations)->toHaveCount(1)
        ->and($blueprint->timestamps)->toBeFalse()
        ->and($blueprint->softDeletes)->toBeTrue()
        ->and($blueprint->generates)->toHaveCount(5)
        ->and($blueprint->generates->contains(GenerateScope::MIGRATION->value))->toBeTrue()
        ->and($blueprint->generates->contains(GenerateScope::FACTORY->value))->toBeTrue()
        ->and($blueprint->generates->contains(GenerateScope::MODEL->value))->toBeTrue()
        ->and($blueprint->generates->contains(GenerateScope::API->value))->toBeTrue()
        ->and($blueprint->generates->contains(GenerateScope::CMS->value))->toBeTrue();
});
