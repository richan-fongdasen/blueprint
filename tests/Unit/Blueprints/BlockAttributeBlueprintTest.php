<?php

use Illuminate\Validation\ValidationException;
use RichanFongdasen\Blueprint\Blueprints\BlockAttributeBlueprint;
use RichanFongdasen\Blueprint\Enums\BlockAttributeType;
use RichanFongdasen\Blueprint\Enums\InputOptionType;
use RichanFongdasen\Blueprint\Enums\InputType;

it('raises exception if the name property is not provided', function () {
    BlockAttributeBlueprint::make([
        'type' => 'string',
    ]);
})->throws(ValidationException::class);

it('raises exception if the format property is missing', function () {
    BlockAttributeBlueprint::make([
        'name' => 'title',
        'type' => 'string',
    ]);
})->throws(ValidationException::class);

it('raises exception if the format property is an empty array', function () {
    BlockAttributeBlueprint::make([
        'name'   => 'title',
        'type'   => 'string',
        'format' => [],
    ]);
})->throws(ValidationException::class);

it('raises exception if the default property is missing', function () {
    BlockAttributeBlueprint::make([
        'name'   => 'title',
        'type'   => 'string',
        'format' => ['string'],
    ]);
})->throws(ValidationException::class);

it('raises exception if the optionType property is missing when the isOption property is set to be true', function () {
    BlockAttributeBlueprint::make([
        'name'     => 'title',
        'type'     => 'string',
        'format'   => ['string'],
        'default'  => 'Hello, World!',
        'isOption' => true,
    ]);
})->throws(ValidationException::class);

it('raises exception if the optionSource property is missing when the isOption property is set to be true', function () {
    BlockAttributeBlueprint::make([
        'name'       => 'title',
        'type'       => 'string',
        'format'     => ['string'],
        'default'    => 'Hello, World!',
        'isOption'   => true,
        'optionType' => InputOptionType::ENUM->value,
    ]);
})->throws(ValidationException::class);

it('can be instantiated with the minimum required properties', function () {
    $blueprint = BlockAttributeBlueprint::make([
        'name'    => 'title',
        'format'  => ['string'],
        'default' => 'Hello, World!',
    ]);

    expect($blueprint)->toBeInstanceOf(BlockAttributeBlueprint::class)
        ->and($blueprint->name)->toBe('title')
        ->and($blueprint->type)->toBe(BlockAttributeType::STRING)
        ->and($blueprint->nullable)->toBeFalse()
        ->and($blueprint->input)->toBe(InputType::TEXT)
        ->and($blueprint->isOption)->toBeFalse()
        ->and($blueprint->optionType)->toBeNull()
        ->and($blueprint->optionSource)->toBeNull()
        ->and($blueprint->min)->toBeNull()
        ->and($blueprint->max)->toBeNull();
});

it('can be instantiated with all available properties', function () {
    $blueprint = BlockAttributeBlueprint::make([
        'name'         => 'button_caption',
        'type'         => 'string',
        'nullable'     => true,
        'input'        => 'text',
        'isOption'     => true,
        'optionType'   => 'model',
        'optionSource' => 'User',
        'min'          => 5,
        'max'          => 255,
        'format'       => ['string'],
        'default'      => 'Hello, World!',
    ]);

    expect($blueprint)->toBeInstanceOf(BlockAttributeBlueprint::class)
        ->and($blueprint->name)->toBe('buttonCaption')
        ->and($blueprint->type)->toBe(BlockAttributeType::STRING)
        ->and($blueprint->nullable)->toBeTrue()
        ->and($blueprint->input)->toBe(InputType::TEXT)
        ->and($blueprint->isOption)->toBeTrue()
        ->and($blueprint->optionType)->toBe(InputOptionType::MODEL)
        ->and($blueprint->optionSource)->toBe('User')
        ->and($blueprint->min)->toBe(5)
        ->and($blueprint->max)->toBe(255);
});
