<?php

use Illuminate\Validation\ValidationException;
use RichanFongdasen\Blueprint\Blueprints\ImageResizeBlueprint;

it('raises exception if the width property is missing', function () {
    ImageResizeBlueprint::make([
        'height' => 100,
    ]);
})->throws(ValidationException::class);

it('raises exception if the height property is missing', function () {
    ImageResizeBlueprint::make([
        'width' => 100,
    ]);
})->throws(ValidationException::class);

it('can be instantiated with minimum required properties', function () {
    $blueprint = ImageResizeBlueprint::make([
        'width'  => 100,
        'height' => 100,
    ]);

    expect($blueprint->name)->toBe('DEFAULT')
        ->and($blueprint->width)->toBe(100)
        ->and($blueprint->height)->toBe(100)
        ->and($blueprint->crop)->toBeTrue()
        ->and($blueprint->sharpen)->toBe(0)
        ->and($blueprint->optimize)->toBeTrue();
});

it('can be instantiated with all properties', function () {
    $blueprint = ImageResizeBlueprint::make([
        'name'     => 'thumbnail',
        'width'    => 100,
        'height'   => 100,
        'crop'     => false,
        'sharpen'  => 10,
        'optimize' => false,
    ]);

    expect($blueprint->name)->toBe('thumbnail')
        ->and($blueprint->width)->toBe(100)
        ->and($blueprint->height)->toBe(100)
        ->and($blueprint->crop)->toBeFalse()
        ->and($blueprint->sharpen)->toBe(10)
        ->and($blueprint->optimize)->toBeFalse();
});
