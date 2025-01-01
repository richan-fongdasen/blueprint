<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Blueprints;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use RichanFongdasen\Blueprint\Enums\DataFormat;
use RichanFongdasen\Blueprint\Enums\EntityAttributeType;
use RichanFongdasen\Blueprint\Enums\InputOptionType;
use RichanFongdasen\Blueprint\Enums\InputType;

class EntityAttributeBlueprint extends AbstractBlueprint
{
    /**
     * The name of the entity attribute.
     */
    public string $name;

    /**
     * The type of the entity attribute.
     */
    public EntityAttributeType $type;

    /**
     * Determine whether the entity attribute is nullable or not.
     */
    public bool $nullable;

    /**
     * Determine whether the entity attribute should be unique or not.
     */
    public bool $unique;

    /**
     * Determine whether the entity attribute should be hidden or not in the model.
     */
    public bool $hidden;

    /**
     * The input type of the entity attribute.
     */
    public InputType $input;

    /**
     * Determine whether the entity attribute is an option or not.
     */
    public bool $isOption;

    /**
     * The option type of the entity attribute.
     */
    public ?InputOptionType $optionType;

    /**
     * The option source of the entity attribute.
     */
    public ?string $optionSource;

    /**
     * The minimum value or minimum length of the entity attribute.
     */
    public ?int $min = null;

    /**
     * The maximum value or maximum length of the entity attribute.
     */
    public ?int $max = null;

    /**
     * The data validation format of the entity attribute.
     */
    public Collection $format;

    /**
     * Determine whether the entity attribute is translatable or not.
     */
    public bool $translatable;

    /**
     * Determine whether the entity attribute is filterable or not in the API request.
     */
    public bool $filterable;

    /**
     * Determine whether the entity attribute is sortable or not in the API request and in the DataTable.
     */
    public bool $sortable;

    /**
     * Determine whether the entity attribute is searchable or not in the API request and in the DataTable.
     */
    public bool $searchable;

    /**
     * Determine whether the entity attribute is invisible or not in the DataTable.
     */
    public bool $invisible;

    /**
     * Create a new entity attribute blueprint instance.
     */
    public function __construct(array $blueprint)
    {
        $blueprint = $this->validate($blueprint);

        $this->name = str((string) $blueprint->get('name'))->snake()->toString();

        $this->type = EntityAttributeType::from($blueprint->get('type') ?? EntityAttributeType::DEFAULT->value);
        $this->nullable = (bool) $blueprint->get('nullable', false);
        $this->unique = (bool) $blueprint->get('unique', false);
        $this->hidden = (bool) $blueprint->get('hidden', false);

        $this->input = InputType::from($blueprint->get('input') ?? InputType::DEFAULT->value);
        $this->isOption = (bool) $blueprint->get('isOption', false);
        $this->optionType = ($blueprint->get('optionType') !== null) ? InputOptionType::from($blueprint->get('optionType')) : null;
        $this->optionSource = $blueprint->get('optionSource');

        $this->min = $blueprint->get('min') ?? $this->getDefaultMinValue();
        $this->max = $blueprint->get('max') ?? $this->getDefaultMaxValue();
        $this->format = new Collection($blueprint->get('format'));
        $this->translatable = (bool) $blueprint->get('translatable', false);

        $this->filterable = (bool) $blueprint->get('filterable', false);
        $this->sortable = (bool) $blueprint->get('sortable', true);
        $this->searchable = (bool) $blueprint->get('searchable', false);
        $this->invisible = (bool) $blueprint->get('invisible', false);
    }

    /**
     * Get the default minimum value of the entity attribute.
     */
    protected function getDefaultMinValue(): ?int
    {
        return match ($this->type) {
            EntityAttributeType::TINY_INTEGER   => -128,
            EntityAttributeType::SMALL_INTEGER  => -32768,
            EntityAttributeType::MEDIUM_INTEGER => -8388608,
            EntityAttributeType::INTEGER        => -2147483648,
            EntityAttributeType::BIG_INTEGER    => -9223372036854775807,

            EntityAttributeType::UNSIGNED_TINY_INTEGER   => 0,
            EntityAttributeType::UNSIGNED_SMALL_INTEGER  => 0,
            EntityAttributeType::UNSIGNED_MEDIUM_INTEGER => 0,
            EntityAttributeType::UNSIGNED_INTEGER        => 0,
            EntityAttributeType::UNSIGNED_BIG_INTEGER    => 0,

            EntityAttributeType::CHAR          => 2,
            EntityAttributeType::LONG_TEXT     => 2,
            EntityAttributeType::MEDIUM_TEXT   => 2,
            EntityAttributeType::STRING        => 2,
            EntityAttributeType::TEXT          => 2,

            EntityAttributeType::FLOAT  => null,
            EntityAttributeType::DOUBLE => null,

            default => $this->min,
        };
    }

    /**
     * Get the default maximum value of the entity attribute.
     */
    protected function getDefaultMaxValue(): ?int
    {
        return match ($this->type) {
            EntityAttributeType::TINY_INTEGER   => 127,
            EntityAttributeType::SMALL_INTEGER  => 32767,
            EntityAttributeType::MEDIUM_INTEGER => 8388607,
            EntityAttributeType::INTEGER        => 2147483647,
            EntityAttributeType::BIG_INTEGER    => 9223372036854775807,

            EntityAttributeType::UNSIGNED_TINY_INTEGER   => 255,
            EntityAttributeType::UNSIGNED_SMALL_INTEGER  => 65535,
            EntityAttributeType::UNSIGNED_MEDIUM_INTEGER => 16777215,
            EntityAttributeType::UNSIGNED_INTEGER        => 4294967295,
            EntityAttributeType::UNSIGNED_BIG_INTEGER    => 9223372036854775807,

            EntityAttributeType::CHAR          => 255,
            EntityAttributeType::LONG_TEXT     => 4294967295,
            EntityAttributeType::MEDIUM_TEXT   => 16777215,
            EntityAttributeType::STRING        => 255,
            EntityAttributeType::TEXT          => 65535,

            EntityAttributeType::FLOAT  => null,
            EntityAttributeType::DOUBLE => null,

            default => $this->max,
        };
    }

    /**
     * Define the validation rules for the entity attribute blueprint.
     */
    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'alpha_dash:ascii', 'min:2', 'max:64'],
            'type'             => ['nullable', 'string', Rule::enum(EntityAttributeType::class)],
            'nullable'         => ['nullable', 'boolean'],
            'unique'           => ['nullable', 'boolean'],
            'hidden'           => ['nullable', 'boolean'],
            'input'            => ['nullable', 'string', Rule::enum(InputType::class)],
            'isOption'         => ['nullable', 'boolean'],
            'optionType'       => ['nullable', 'string', 'required_if:isOption,true', Rule::enum(InputOptionType::class)],
            'optionSource'     => ['nullable', 'string', 'alpha_num:ascii', 'min:3', 'max:40', 'required_if:isOption,true'],
            'min'              => ['nullable', 'integer'],
            'max'              => ['nullable', 'integer'],
            'format'           => ['required', 'array'],
            'format.*'         => ['required', 'string', Rule::enum(DataFormat::class)],
            'translatable'     => ['nullable', 'boolean'],
            'filterable'       => ['nullable', 'boolean'],
            'sortable'         => ['nullable', 'boolean'],
            'searchable'       => ['nullable', 'boolean'],
            'invisible'        => ['nullable', 'boolean'],
        ];
    }
}
