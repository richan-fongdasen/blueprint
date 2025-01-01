<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use RichanFongdasen\Blueprint\Blueprints\BlockBlueprint;
use RichanFongdasen\Blueprint\Blueprints\EntityBlueprint;
use RichanFongdasen\Blueprint\Blueprints\EnumBlueprint;
use RichanFongdasen\Blueprint\Contracts\ConsoleCommand;

class BlueprintService
{
    /**
     * BlueprintService constructor.
     */
    public function __construct(
        protected Collection $enums,
        protected Collection $entities,
        protected Collection $blocks
    ) {}

    /**
     * Get the enum blueprint by the given name.
     */
    public function enum(string $name): EnumBlueprint
    {
        $enum = $this->enums->keyBy('name')->get($name);

        if (! ($enum instanceof EnumBlueprint)) {
            throw new InvalidArgumentException("Enum blueprint with the name '{$name}' is not found.");
        }

        return $enum;
    }

    /**
     * Get all available enum blueprints.
     */
    public function enums(): Collection
    {
        return $this->enums;
    }

    /**
     * Get the entity blueprint by the given name.
     */
    public function entity(string $name): EntityBlueprint
    {
        $entity = $this->entities->keyBy('name')->get($name);

        if (! ($entity instanceof EntityBlueprint)) {
            throw new InvalidArgumentException("Entity blueprint with the name '{$name}' is not found.");
        }

        return $entity;
    }

    /**
     * Get all available entity blueprints.
     */
    public function entities(): Collection
    {
        return $this->entities;
    }

    /**
     * Get the block blueprint by the given name.
     */
    public function block(string $name): BlockBlueprint
    {
        $block = $this->blocks->keyBy('name')->get($name);

        if (! ($block instanceof BlockBlueprint)) {
            throw new InvalidArgumentException("Block blueprint with the name '{$name}' is not found.");
        }

        return $block;
    }

    /**
     * Get all available block blueprints.
     */
    public function blocks(): Collection
    {
        return $this->blocks;
    }

    /**
     * Flush all blueprint data.
     */
    public function flush(): void
    {
        $this->enums = new Collection();
        $this->entities = new Collection();
        $this->blocks = new Collection();
    }

    /**
     * Load all blueprint files from the given path.
     */
    public function load(string $path, ?ConsoleCommand $console = null): void
    {
        if (! is_dir($path)) {
            throw new InvalidArgumentException("The given path '{$path}' is not a valid directory.");
        }

        $disk = Storage::build([
            'driver' => 'local',
            'root'   => $path,
        ]);

        collect($disk->allFiles('enums'))->each(function (string $file) use ($console, $disk) {
            if ($console instanceof ConsoleCommand) {
                $shortPath = str_replace($disk->path(''), '', $file);
                $console->info("Loading enum blueprint from file: {$shortPath}");
            }

            $enum = new EnumBlueprint(
                json_decode((string) $disk->get($file), true)
            );
            $this->enums->put($enum->name, $enum);
        });

        collect($disk->allFiles('entities'))->each(function (string $file) use ($console, $disk) {
            if ($console instanceof ConsoleCommand) {
                $shortPath = str_replace($disk->path(''), '', $file);
                $console->info("Loading entity blueprint from file: {$shortPath}");
            }

            $entity = new EntityBlueprint(
                json_decode((string) $disk->get($file), true)
            );
            $this->entities->put($entity->name, $entity);
        });

        collect($disk->allFiles('blocks'))->each(function (string $file) use ($console, $disk) {
            if ($console instanceof ConsoleCommand) {
                $shortPath = str_replace($disk->path(''), '', $file);
                $console->info("Loading block blueprint from file: {$shortPath}");
            }

            $block = new BlockBlueprint(
                json_decode((string) $disk->get($file), true)
            );
            $this->blocks->put($block->name, $block);
        });
    }
}
