<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Blueprints;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use RichanFongdasen\Blueprint\Enums\GenerateScope;

class EntityBlueprint extends AbstractBlueprint
{
    /**
     * The name of the entity.
     */
    public string $name;

    /**
     * The table name of the entity.
     */
    public string $table;

    /**
     * The primary key of the entity.
     */
    public string $primaryKey = 'id';

    /**
     * The foreign key of the entity.
     */
    public string $foreignKey;

    /**
     * The display attribute of the entity.
     */
    public string $displayAttribute;

    /**
     * The collection of entity attributes.
     */
    public Collection $attributes;

    /**
     * The collection of entity's media collections.
     */
    public Collection $media;

    /**
     * The collection of entity relations.
     */
    public Collection $relations;

    /**
     * Determine whether the entity has timestamps or not.
     */
    public bool $timestamps = true;

    /**
     * Determine whether the entity has soft deletes or not.
     */
    public bool $softDeletes = false;

    /**
     * Determine the entity's generation scopes.
     */
    public Collection $generates;

    /**
     * Create a new instance of EntityBlueprint.
     */
    public function __construct(array $blueprint)
    {
        $blueprint = $this->validate($blueprint);

        $name = str((string) $blueprint->get('name'));

        $this->name = $name->singular()->studly()->toString();
        $this->table = $blueprint->get('table') ?? $name->plural()->snake()->toString();
        $this->primaryKey = $blueprint->get('primaryKey') ?? 'id';
        $this->foreignKey = $blueprint->get('foreignKey') ?? $name->singular()->snake()->append('_id')->toString();

        $this->attributes = (new Collection($blueprint->get('attributes')))
            ->map(function (array $attribute) {
                return new EntityAttributeBlueprint($attribute);
            });

        $this->displayAttribute = $blueprint->get('displayAttribute') ?? $this->attributes->first()?->name;

        $this->media = (new Collection((array) $blueprint->get('media')))
            ->map(function (array $media) {
                return new MediaBlueprint($media);
            });

        $this->relations = (new Collection((array) $blueprint->get('relations')))
            ->map(function (array $relation) {
                return new EntityRelationBlueprint($relation);
            });

        $this->timestamps = $blueprint->get('timestamps', true);
        $this->softDeletes = $blueprint->get('softDeletes', false);

        $this->generates = new Collection((array) $blueprint->get('generates'));
    }

    /**
     * Define the validation rules for the blueprint.
     */
    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'alpha_dash:ascii', 'min:3', 'max:40'],
            'table'            => ['nullable', 'string', 'alpha_dash:ascii', 'min:3', 'max:48'],
            'primaryKey'       => ['nullable', 'string', 'alpha_dash:ascii', 'min:2', 'max:40'],
            'foreignKey'       => ['nullable', 'string', 'alpha_dash:ascii', 'min:2', 'max:40'],
            'displayAttribute' => ['nullable', 'string', 'alpha_dash:ascii', 'min:2', 'max:40'],
            'attributes'       => ['required', 'array'],
            'media'            => ['nullable', 'array'],
            'relations'        => ['nullable', 'array'],
            'timestamps'       => ['nullable', 'boolean'],
            'softDeletes'      => ['nullable', 'boolean'],
            'generates'        => ['required', 'array'],
            'generates.*'      => ['required', 'string', Rule::enum(GenerateScope::class)],
        ];
    }
}
