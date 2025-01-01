<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Blueprints;

use Illuminate\Validation\Rule;
use RichanFongdasen\Blueprint\Enums\RelationType;

class EntityRelationBlueprint extends AbstractBlueprint
{
    /**
     * The blueprint data.
     */
    protected array $blueprint = [];

    /**
     * Entity relation name.
     */
    public string $name;

    /**
     * Related entity name.
     */
    public string $relatedEntity;

    /**
     * The relation type.
     */
    public RelationType $type;

    /**
     * Pivot table name.
     */
    public ?string $pivotTable;

    /**
     * Through entity name.
     */
    public ?string $throughEntity;

    /**
     * Create a new instance of EntityRelationBlueprint.
     */
    public function __construct(array $blueprint)
    {
        $this->blueprint = $blueprint;
        $blueprint = $this->validate($blueprint);

        $this->name = (string) $blueprint->get('name');
        $this->relatedEntity = (string) $blueprint->get('relatedEntity');
        $this->type = RelationType::from($blueprint->get('type'));
        $this->pivotTable = $blueprint->get('pivotTable');
        $this->throughEntity = $blueprint->get('throughEntity');
    }

    /**
     * Define the validation rules for the blueprint.
     */
    public function rules(): array
    {
        $currentType = data_get($this->blueprint, 'type');

        $needsPivotTable = fn () => $currentType === RelationType::BELONGS_TO_MANY->value;
        $needsThroughEntity = fn () => $currentType === RelationType::HAS_MANY_THROUGH->value || $currentType === RelationType::HAS_ONE_THROUGH->value;

        return [
            'name'          => ['required', 'string', 'alpha_num:ascii', 'min:3', 'max:40'],
            'relatedEntity' => ['required', 'string', 'alpha_num:ascii', 'min:3', 'max:40'],
            'type'          => ['required', 'string', Rule::enum(RelationType::class)],
            'pivotTable'    => ['nullable', Rule::requiredIf($needsPivotTable), 'string', 'alpha_dash:ascii', 'min:3', 'max:48'],
            'throughEntity' => ['nullable', Rule::requiredIf($needsThroughEntity), 'string', 'alpha_num:ascii', 'min:3', 'max:40'],
        ];
    }
}
