<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Blueprints;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use RichanFongdasen\Blueprint\Enums\BlockScope;

class BlockBlueprint extends AbstractBlueprint
{
    /**
     * The name of the block.
     */
    public string $name;

    /**
     * The scopes of the block.
     */
    public Collection $scopes;

    /**
     * The attributes collection of the block.
     */
    public Collection $attributes;

    /**
     * The media collection of the block.
     */
    public Collection $media;

    /**
     * BlockBlueprint constructor.
     */
    public function __construct(array $blueprint)
    {
        $blueprint = $this->validate($blueprint);

        $this->name = str((string) $blueprint->get('name'))
            ->trim()
            ->studly()
            ->toString();

        $this->scopes = new Collection((array) $blueprint->get('scopes'));

        $this->attributes = (new Collection((array) $blueprint->get('attributes')))
            ->map(function (array $attribute) {
                return new BlockAttributeBlueprint($attribute);
            });

        $this->media = (new Collection((array) $blueprint->get('media')))
            ->map(function (array $media) {
                return new MediaBlueprint($media);
            });
    }

    /**
     * Define the validation rules for the blueprint.
     */
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'alpha_dash:ascii', 'min:3', 'max:40'],
            'scopes'     => ['required', 'array'],
            'scopes.*'   => ['required', 'string', Rule::enum(BlockScope::class)],
            'attributes' => ['required', 'array'],
            'media'      => ['nullable', 'array'],
        ];
    }
}
