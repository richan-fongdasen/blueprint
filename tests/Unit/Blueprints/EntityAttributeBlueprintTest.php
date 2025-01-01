<?php

use Illuminate\Validation\ValidationException;
use RichanFongdasen\Blueprint\Blueprints\EntityAttributeBlueprint;
use RichanFongdasen\Blueprint\Enums\EntityAttributeType;
use RichanFongdasen\Blueprint\Enums\InputOptionType;
use RichanFongdasen\Blueprint\Enums\InputType;

it('raises exception if the name attribute is missing', function () {
    EntityAttributeBlueprint::make([
        'format' => ['string'],
    ]);
})->throws(ValidationException::class);

it('raises exception if the format attribute is missing', function () {
    EntityAttributeBlueprint::make([
        'name' => 'testAttribute',
    ]);
})->throws(ValidationException::class);

it('raises exception if the format attribute is an empty array', function () {
    EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'format' => [],
    ]);
})->throws(ValidationException::class);

it('raises exception if the optionType attribute is missing when the isOption attribute is true', function () {
    EntityAttributeBlueprint::make([
        'name'     => 'testAttribute',
        'format'   => ['string'],
        'isOption' => true,
    ]);
})->throws(ValidationException::class);

it('raises exception if the optionSource attribute is missing when the isOption attribute is true', function () {
    EntityAttributeBlueprint::make([
        'name'       => 'testAttribute',
        'format'     => ['string'],
        'isOption'   => true,
        'optionType' => InputOptionType::MODEL->value,
    ]);
})->throws(ValidationException::class);

it('can be instantiated with minimum required attributes', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'format' => ['string'],
    ]);

    expect($blueprint->name)->toBe('test_attribute')
        ->and($blueprint->type)->toBe(EntityAttributeType::DEFAULT)
        ->and($blueprint->nullable)->toBeFalse()
        ->and($blueprint->unique)->toBeFalse()
        ->and($blueprint->hidden)->toBeFalse()
        ->and($blueprint->input)->toBe(InputType::DEFAULT)
        ->and($blueprint->isOption)->toBeFalse()
        ->and($blueprint->optionType)->toBeNull()
        ->and($blueprint->optionSource)->toBeNull()
        ->and($blueprint->min)->toBe(2)
        ->and($blueprint->max)->toBe(255)
        ->and($blueprint->format->toArray())->toBe(['string'])
        ->and($blueprint->translatable)->toBeFalse()
        ->and($blueprint->filterable)->toBeFalse()
        ->and($blueprint->sortable)->toBeTrue()
        ->and($blueprint->searchable)->toBeFalse()
        ->and($blueprint->invisible)->toBeFalse();
});

it('can assign the min and max values for tiny integer type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::TINY_INTEGER->value,
        'format' => ['integer'],
    ]);

    expect($blueprint->min)->toBe(-128)
        ->and($blueprint->max)->toBe(127);
});

it('can assign the min and max values for small integer type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::SMALL_INTEGER->value,
        'format' => ['integer'],
    ]);

    expect($blueprint->min)->toBe(-32768)
        ->and($blueprint->max)->toBe(32767);
});

it('can assign the min and max values for medium integer type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::MEDIUM_INTEGER->value,
        'format' => ['integer'],
    ]);

    expect($blueprint->min)->toBe(-8388608)
        ->and($blueprint->max)->toBe(8388607);
});

it('can assign the min and max values for integer type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::INTEGER->value,
        'format' => ['integer'],
    ]);

    expect($blueprint->min)->toBe(-2147483648)
        ->and($blueprint->max)->toBe(2147483647);
});

it('can assign the min and max values for big integer type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::BIG_INTEGER->value,
        'format' => ['integer'],
    ]);

    expect($blueprint->min)->toBe(-9223372036854775807)
        ->and($blueprint->max)->toBe(9223372036854775807);
});

it('can assign the min and max values for unsigned tiny integer type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::UNSIGNED_TINY_INTEGER->value,
        'format' => ['integer'],
    ]);

    expect($blueprint->min)->toBe(0)
        ->and($blueprint->max)->toBe(255);
});

it('can assign the min and max values for unsigned small integer type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::UNSIGNED_SMALL_INTEGER->value,
        'format' => ['integer'],
    ]);

    expect($blueprint->min)->toBe(0)
        ->and($blueprint->max)->toBe(65535);
});

it('can assign the min and max values for unsigned medium integer type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::UNSIGNED_MEDIUM_INTEGER->value,
        'format' => ['integer'],
    ]);

    expect($blueprint->min)->toBe(0)
        ->and($blueprint->max)->toBe(16777215);
});

it('can assign the min and max values for unsigned integer type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::UNSIGNED_INTEGER->value,
        'format' => ['integer'],
    ]);

    expect($blueprint->min)->toBe(0)
        ->and($blueprint->max)->toBe(4294967295);
});

it('can assign the min and max values for unsigned big integer type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::UNSIGNED_BIG_INTEGER->value,
        'format' => ['integer'],
    ]);

    expect($blueprint->min)->toBe(0)
        ->and($blueprint->max)->toBe(9223372036854775807);
});

it('can assign the min and max values for char type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::CHAR->value,
        'format' => ['string'],
    ]);

    expect($blueprint->min)->toBe(2)
        ->and($blueprint->max)->toBe(255);
});

it('can assign the min and max values for long text type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::LONG_TEXT->value,
        'format' => ['string'],
    ]);

    expect($blueprint->min)->toBe(2)
        ->and($blueprint->max)->toBe(4294967295);
});

it('can assign the min and max values for medium text type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::MEDIUM_TEXT->value,
        'format' => ['string'],
    ]);

    expect($blueprint->min)->toBe(2)
        ->and($blueprint->max)->toBe(16777215);
});

it('can assign the min and max values for string type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::STRING->value,
        'format' => ['string'],
    ]);

    expect($blueprint->min)->toBe(2)
        ->and($blueprint->max)->toBe(255);
});

it('can assign the min and max values for text type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::TEXT->value,
        'format' => ['string'],
    ]);

    expect($blueprint->min)->toBe(2)
        ->and($blueprint->max)->toBe(65535);
});

it('can assign the min and max values for float type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::FLOAT->value,
        'format' => ['string'],
    ]);

    expect($blueprint->min)->toBeNull()
        ->and($blueprint->max)->toBeNull();
});

it('can assign the min and max values for double type', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'   => 'testAttribute',
        'type'   => EntityAttributeType::DOUBLE->value,
        'format' => ['string'],
    ]);

    expect($blueprint->min)->toBeNull()
        ->and($blueprint->max)->toBeNull();
});

it('can be instantiated with all available attributes', function () {
    $blueprint = EntityAttributeBlueprint::make([
        'name'         => 'testAttribute',
        'type'         => EntityAttributeType::INTEGER->value,
        'nullable'     => true,
        'unique'       => true,
        'hidden'       => true,
        'input'        => InputType::TEXTAREA->value,
        'isOption'     => true,
        'optionType'   => InputOptionType::MODEL->value,
        'optionSource' => 'User',
        'min'          => 10,
        'max'          => 100,
        'format'       => ['integer'],
        'translatable' => true,
        'filterable'   => true,
        'sortable'     => false,
        'searchable'   => true,
        'invisible'    => true,
    ]);

    expect($blueprint->name)->toBe('test_attribute')
        ->and($blueprint->type)->toBe(EntityAttributeType::INTEGER)
        ->and($blueprint->nullable)->toBeTrue()
        ->and($blueprint->unique)->toBeTrue()
        ->and($blueprint->hidden)->toBeTrue()
        ->and($blueprint->input)->toBe(InputType::TEXTAREA)
        ->and($blueprint->isOption)->toBeTrue()
        ->and($blueprint->optionType)->toBe(InputOptionType::MODEL)
        ->and($blueprint->optionSource)->toBe('User')
        ->and($blueprint->min)->toBe(10)
        ->and($blueprint->max)->toBe(100)
        ->and($blueprint->format->toArray())->toBe(['integer'])
        ->and($blueprint->translatable)->toBeTrue()
        ->and($blueprint->filterable)->toBeTrue()
        ->and($blueprint->sortable)->toBeFalse()
        ->and($blueprint->searchable)->toBeTrue()
        ->and($blueprint->invisible)->toBeTrue();
});
