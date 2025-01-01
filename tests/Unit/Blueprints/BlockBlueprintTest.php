<?php

declare(strict_types=1);

use Illuminate\Validation\ValidationException;
use RichanFongdasen\Blueprint\Blueprints\BlockBlueprint;
use RichanFongdasen\Blueprint\Enums\BlockScope;

it('raises exception if the name attribute is missing', function () {
    BlockBlueprint::make([
        'scopes'     => [BlockScope::PAGES->value],
        'attributes' => [],
    ]);
})->throws(ValidationException::class);

it('raises exception if the scopes attribute is missing', function () {
    BlockBlueprint::make([
        'name'       => 'hero',
        'attributes' => [],
    ]);
})->throws(ValidationException::class);

it('raises exception if the scopes attribute is an empty array', function () {
    BlockBlueprint::make([
        'name'       => 'hero',
        'scopes'     => [],
        'attributes' => [],
    ]);
})->throws(ValidationException::class);

it('raises exception if the attributes attribute is missing', function () {
    BlockBlueprint::make([
        'name'   => 'hero',
        'scopes' => [BlockScope::PAGES->value],
    ]);
})->throws(ValidationException::class);

it('raises exception if the attributes attribute is an empty array', function () {
    BlockBlueprint::make([
        'name'       => 'hero',
        'scopes'     => [BlockScope::PAGES],
        'attributes' => [],
    ]);
})->throws(ValidationException::class);

it('can be instantiated with minimum required attributes', function () {
    $blueprint = BlockBlueprint::make([
        'name'       => 'page-headline',
        'scopes'     => [BlockScope::PAGES->value],
        'attributes' => [
            [
                'name'   => 'title',
                'format' => [
                    'string',
                ],
                'default' => 'Hello, World!',
            ],
        ],
    ]);

    expect($blueprint->name)->toBe('PageHeadline')
        ->and($blueprint->scopes->toArray())->toBe([BlockScope::PAGES->value])
        ->and($blueprint->attributes->count())->toBe(1)
        ->and($blueprint->media->count())->toBe(0);
});

it('can be instantiated with all attributes', function () {
    $blueprint = BlockBlueprint::make([
        'name'       => 'page-headline',
        'scopes'     => [BlockScope::PAGES->value],
        'attributes' => [
            [
                'name'   => 'title',
                'format' => [
                    'string',
                ],
                'default' => 'Hello, World!',
            ],
        ],
        'media' => [
            [
                'name'        => 'image',
                'collection'  => 'images',
                'disk'        => 'public',
                'conversions' => [
                    'thumb' => [
                        'width'  => 100,
                        'height' => 100,
                    ],
                ],
            ],
        ],
    ]);

    expect($blueprint->name)->toBe('PageHeadline')
        ->and($blueprint->scopes->toArray())->toBe([BlockScope::PAGES->value])
        ->and($blueprint->attributes->count())->toBe(1)
        ->and($blueprint->media->count())->toBe(1);
});
