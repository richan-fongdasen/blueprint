<?php

use Illuminate\Support\Collection;
use InvalidArgumentException;
use RichanFongdasen\Blueprint\Blueprints\BlockBlueprint;
use RichanFongdasen\Blueprint\Blueprints\EntityBlueprint;
use RichanFongdasen\Blueprint\Blueprints\EnumBlueprint;
use RichanFongdasen\Blueprint\Enums\EnumType;
use RichanFongdasen\Blueprint\Facades\Blueprint;

it('can returns the collection of all available enum blueprints', function () {
    $enums = Blueprint::enums();

    expect($enums)->toBeInstanceOf(Collection::class)
        ->and($enums->count())->toBe(0);
});

it('raises an exception when trying to get an enum blueprint that does not exist', function () {
    Blueprint::enum('non-existing-enum');
})->throws(InvalidArgumentException::class);

it('can returns the enum blueprint by the given name', function () {
    $original = EnumBlueprint::make([
        'name'  => 'TestEnum',
        'type'  => 'string',
        'cases' => [
            'CASE1' => 'case1',
            'CASE2' => 'case2',
        ],
        'defaultCase' => 'CASE1',
    ]);
    Blueprint::enums()->put('TestEnum', $original);

    $enum = Blueprint::enum('TestEnum');

    expect($enum)->toBeInstanceOf(EnumBlueprint::class)
        ->and($enum->name)->toBe('TestEnum')
        ->and($enum->type)->toBe(EnumType::STRING)
        ->and($enum->cases)->toBeInstanceOf(Collection::class)
        ->and($enum->cases->count())->toBe(2)
        ->and($enum->defaultCase)->toBe('CASE1');
});

it('can returns the collection of all available entity blueprints', function () {
    $entities = Blueprint::entities();

    expect($entities)->toBeInstanceOf(Collection::class)
        ->and($entities->count())->toBe(0);
});

it('raises an exception when trying to get an entity blueprint that does not exist', function () {
    Blueprint::entity('non-existing-entity');
})->throws(InvalidArgumentException::class);

it('can returns the entity blueprint by the given name', function () {
    $original = EntityBlueprint::make([
        'name'         => 'test-entity',
        'attributes'   => [
            [
                'name'      => 'name',
                'format'    => ['string'],
            ],
        ],
        'generates' => ['migration', 'model'],
    ]);
    Blueprint::entities()->put('TestEntity', $original);

    $entity = Blueprint::entity('TestEntity');

    expect($entity)->toBeInstanceOf(EntityBlueprint::class)
        ->and($entity->name)->toBe('TestEntity')
        ->and($entity->attributes)->toBeInstanceOf(Collection::class)
        ->and($entity->attributes->count())->toBe(1)
        ->and($entity->generates)->toBeInstanceOf(Collection::class)
        ->and($entity->generates->count())->toBe(2);
});

it('can returns the collection of all available block blueprints', function () {
    $blocks = Blueprint::blocks();

    expect($blocks)->toBeInstanceOf(Collection::class)
        ->and($blocks->count())->toBe(0);
});

it('raises an exception when trying to get a block blueprint that does not exist', function () {
    Blueprint::block('non-existing-block');
})->throws(InvalidArgumentException::class);

it('can returns the block blueprint by the given name', function () {
    $original = BlockBlueprint::make([
        'name'         => 'test-block',
        'scopes'       => ['pages'],
        'attributes'   => [
            [
                'name'      => 'name',
                'format'    => ['string'],
                'default'   => 'Test Block',
            ],
        ],
    ]);
    Blueprint::blocks()->put('TestBlock', $original);

    $block = Blueprint::block('TestBlock');

    expect($block)->toBeInstanceOf(BlockBlueprint::class)
        ->and($block->name)->toBe('TestBlock')
        ->and($block->attributes)->toBeInstanceOf(Collection::class)
        ->and($block->attributes->count())->toBe(1)
        ->and($block->scopes)->toBeInstanceOf(Collection::class)
        ->and($block->scopes->count())->toBe(1);
});

it('raises an exception when trying to load blueprints from the given path that does not exist', function () {
    Blueprint::load(__DIR__ . '/non-existing-path');
})->throws(InvalidArgumentException::class);

it('can load blueprints from the given path', function () {
    Blueprint::load(__DIR__ . '/../../blueprints');

    $enums = Blueprint::enums();
    $entities = Blueprint::entities();
    $blocks = Blueprint::blocks();

    expect($enums)->toBeInstanceOf(Collection::class)
        ->and($enums->count())->toBe(2);

    expect($entities)->toBeInstanceOf(Collection::class)
        ->and($entities->count())->toBe(1);

    expect($blocks)->toBeInstanceOf(Collection::class)
        ->and($blocks->count())->toBe(1);

    expect(Blueprint::enum('ActiveStatus'))->toBeInstanceOf(EnumBlueprint::class)
        ->and(Blueprint::entity('Brand'))->toBeInstanceOf(EntityBlueprint::class)
        ->and(Blueprint::block('PostImage'))->toBeInstanceOf(BlockBlueprint::class);
});

it('can flush all blueprint data', function () {
    Blueprint::load(__DIR__ . '/../../blueprints');

    Blueprint::flush();

    $enums = Blueprint::enums();
    $entities = Blueprint::entities();
    $blocks = Blueprint::blocks();

    expect($enums)->toBeInstanceOf(Collection::class)
        ->and($enums->count())->toBe(0);

    expect($entities)->toBeInstanceOf(Collection::class)
        ->and($entities->count())->toBe(0);

    expect($blocks)->toBeInstanceOf(Collection::class)
        ->and($blocks->count())->toBe(0);
});
