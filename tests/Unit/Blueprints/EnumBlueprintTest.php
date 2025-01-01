<?php

use Illuminate\Validation\ValidationException;
use RichanFongdasen\Blueprint\Blueprints\EnumBlueprint;
use RichanFongdasen\Blueprint\Enums\EnumType;

test('it will raise exception if the enum class name is not set', function () {
    EnumBlueprint::make([
        'cases' => ['case1', 'case2'],
    ]);
})->throws(ValidationException::class)->group('unit', 'blueprints');

test('it will raise exception if the enum cases are not set', function () {
    EnumBlueprint::make([
        'name' => 'EnumName',
    ]);
})->throws(ValidationException::class)->group('unit', 'blueprints');

test('it will assign the default enum type if not set', function () {
    $blueprint = EnumBlueprint::make([
        'name'  => 'EnumName',
        'cases' => ['case1', 'case2'],
    ]);

    expect($blueprint->type)->toBe(EnumType::DEFAULT);
})->group('unit', 'blueprints');

test('it will assign the enum type if set as string type', function () {
    $blueprint = EnumBlueprint::make([
        'name'  => 'EnumName',
        'type'  => EnumType::STRING->value,
        'cases' => ['case1', 'case2'],
    ]);

    expect($blueprint->type)->toBe(EnumType::STRING);
})->group('unit', 'blueprints');

test('it will assign the enum type if set as integer type', function () {
    $blueprint = EnumBlueprint::make([
        'name'  => 'EnumName',
        'type'  => EnumType::INTEGER->value,
        'cases' => ['case1', 'case2'],
    ]);

    expect($blueprint->type)->toBe(EnumType::INTEGER);
})->group('unit', 'blueprints');

test('it can read the enum cases from the blueprint', function () {
    $blueprint = EnumBlueprint::make([
        'name'  => 'PublishStatus',
        'cases' => [
            'PUBLISHED' => 'published',
            'DRAFT'     => 'draft',
        ],
    ]);

    expect($blueprint->cases->toArray())->toBe([
        'PUBLISHED' => 'published',
        'DRAFT'     => 'draft',
    ]);
})->group('unit', 'blueprints');

test('the default case will be null if not set', function () {
    $blueprint = EnumBlueprint::make([
        'name'  => 'PublishStatus',
        'cases' => [
            'PUBLISHED' => 'published',
            'DRAFT'     => 'draft',
        ],
    ]);

    expect($blueprint->defaultCase)->toBeNull();
})->group('unit', 'blueprints');

test('it can read the default case from the blueprint', function () {
    $blueprint = EnumBlueprint::make([
        'name'  => 'PublishStatus',
        'cases' => [
            'PUBLISHED' => 'published',
            'DRAFT'     => 'draft',
        ],
        'defaultCase' => 'DRAFT',
    ]);

    expect($blueprint->defaultCase)->toBe('DRAFT');
})->group('unit', 'blueprints');

test('it can convert the enum blueprint to array', function () {
    $blueprint = EnumBlueprint::make([
        'name'  => 'PublishStatus',
        'cases' => [
            'PUBLISHED' => 'published',
            'DRAFT'     => 'draft',
        ],
        'defaultCase' => 'DRAFT',
    ]);

    expect($blueprint->toArray())->toBe([
        'name'  => 'PublishStatus',
        'type'  => EnumType::DEFAULT->value,
        'cases' => [
            'PUBLISHED' => 'published',
            'DRAFT'     => 'draft',
        ],
        'defaultCase' => 'DRAFT',
    ]);
})->group('unit', 'blueprints');

test('it can convert the enum blueprint to json', function () {
    $blueprint = EnumBlueprint::make([
        'name'  => 'PublishStatus',
        'cases' => [
            'PUBLISHED' => 'published',
            'DRAFT'     => 'draft',
        ],
        'defaultCase' => 'DRAFT',
    ]);

    expect($blueprint->toJson())->toBe('{"name":"PublishStatus","type":"string","cases":{"PUBLISHED":"published","DRAFT":"draft"},"defaultCase":"DRAFT"}');
})->group('unit', 'blueprints');
