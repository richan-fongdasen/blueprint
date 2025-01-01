<?php

use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use RichanFongdasen\Blueprint\Blueprints\ImageResizeBlueprint;
use RichanFongdasen\Blueprint\Blueprints\MediaBlueprint;
use RichanFongdasen\Blueprint\Enums\MediaType;

it('raises exception if the name property is missing', function () {
    MediaBlueprint::make([
        'type'        => MediaType::IMAGE->value,
        'maxFileSize' => 10240,
    ]);
})->throws(ValidationException::class);

it('can be instantiated with minimum required properties', function () {
    $blueprint = MediaBlueprint::make([
        'name' => 'avatar',
    ]);

    expect($blueprint->name)->toBe('avatar')
        ->and($blueprint->type)->toBe(MediaType::DEFAULT)
        ->and($blueprint->maxFileSize)->toBe(10240)
        ->and($blueprint->multiple)->toBeFalse()
        ->and($blueprint->responsive)->toBeFalse()
        ->and($blueprint->resize)->toBeNull()
        ->and($blueprint->conversions)->toBeInstanceOf(Collection::class);
});

it('can be instantiated with all properties for image media type', function () {
    $blueprint = MediaBlueprint::make([
        'name'        => 'avatar',
        'type'        => MediaType::IMAGE->value,
        'maxFileSize' => 20480,
        'multiple'    => true,
        'responsive'  => true,
        'resize'      => [
            'width'  => 1440,
            'height' => 800,
        ],
        'conversions' => [
            [
                'name'   => 'large',
                'width'  => 1024,
                'height' => 768,
                'crop'   => true,
            ],
            [
                'name'   => 'small',
                'width'  => 480,
                'height' => 320,
                'crop'   => true,
            ],
        ],
    ]);

    expect($blueprint->name)->toBe('avatar')
        ->and($blueprint->type)->toBe(MediaType::IMAGE)
        ->and($blueprint->maxFileSize)->toBe(20480)
        ->and($blueprint->multiple)->toBeTrue()
        ->and($blueprint->responsive)->toBeTrue()
        ->and($blueprint->resize)->toBeInstanceOf(ImageResizeBlueprint::class)
        ->and($blueprint->conversions)->toBeInstanceOf(Collection::class)
        ->and($blueprint->conversions->count())->toBe(2);
});

it('can be instantiated with all properties for file media type', function () {
    $blueprint = MediaBlueprint::make([
        'name'        => 'avatar',
        'type'        => MediaType::FILE->value,
        'maxFileSize' => 20480,
        'multiple'    => true,
        'responsive'  => true,
        'resize'      => [
            'width'  => 1440,
            'height' => 800,
        ],
        'conversions' => [
            [
                'name'   => 'large',
                'width'  => 1024,
                'height' => 768,
                'crop'   => true,
            ],
            [
                'name'   => 'small',
                'width'  => 480,
                'height' => 320,
                'crop'   => true,
            ],
        ],
    ]);

    expect($blueprint->name)->toBe('avatar')
        ->and($blueprint->type)->toBe(MediaType::FILE)
        ->and($blueprint->maxFileSize)->toBe(20480)
        ->and($blueprint->multiple)->toBeTrue()
        ->and($blueprint->responsive)->toBeFalse()
        ->and($blueprint->resize)->toBeNull()
        ->and($blueprint->conversions)->toBeInstanceOf(Collection::class)
        ->and($blueprint->conversions->count())->toBe(0);
});
