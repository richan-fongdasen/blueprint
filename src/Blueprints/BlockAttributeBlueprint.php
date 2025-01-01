<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Blueprints;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use RichanFongdasen\Blueprint\Enums\BlockAttributeType;
use RichanFongdasen\Blueprint\Enums\DataFormat;
use RichanFongdasen\Blueprint\Enums\InputOptionType;
use RichanFongdasen\Blueprint\Enums\InputType;

class BlockAttributeBlueprint extends AbstractBlueprint
{
    /**
     * The name of the block attribute.
     */
    public string $name;

    /**
     * The type of the block attribute.
     */
    public BlockAttributeType $type;

    /**
     * Determine whether the block attribute is nullable or not.
     */
    public bool $nullable;

    /**
     * The input type of the block attribute.
     */
    public InputType $input;

    /**
     * Determine whether the block attribute is an option or not.
     */
    public bool $isOption;

    /**
     * The option type of the block attribute.
     */
    public ?InputOptionType $optionType;

    /**
     * The option source of the block attribute.
     */
    public ?string $optionSource;

    /**
     * The minimum value or minimum length of the block attribute.
     */
    public ?int $min;

    /**
     * The maximum value or maximum length of the block attribute.
     */
    public ?int $max;

    /**
     * The data validation format of the block attribute.
     */
    public Collection $format;

    /**
     * The default value of the block attribute.
     */
    public mixed $default;

    /**
     * Create a new block attribute blueprint instance.
     */
    public function __construct(array $blueprint)
    {
        $blueprint = $this->validate($blueprint);

        $this->name = str($blueprint->get('name'))->trim()->camel()->toString();

        $this->type = BlockAttributeType::from($blueprint->get('type') ?? BlockAttributeType::DEFAULT->value);
        $this->nullable = (bool) $blueprint->get('nullable', false);

        $this->input = InputType::from($blueprint->get('input') ?? InputType::DEFAULT->value);
        $this->isOption = (bool) $blueprint->get('isOption', false);
        $this->optionType = ($blueprint->get('optionType') !== null) ? InputOptionType::from($blueprint->get('optionType')) : null;
        $this->optionSource = $blueprint->get('optionSource');

        $this->min = $blueprint->get('min');
        $this->max = $blueprint->get('max');
        $this->format = new Collection($blueprint->get('format'));

        $this->default = $blueprint->get('default');
    }

    /**
     * Define the validation rules for the block attribute blueprint.
     */
    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'alpha_dash:ascii', 'min:2', 'max:64'],
            'type'             => ['nullable', 'string', Rule::enum(BlockAttributeType::class)],
            'nullable'         => ['nullable', 'boolean'],
            'input'            => ['nullable', 'string', Rule::enum(InputType::class)],
            'isOption'         => ['nullable', 'boolean'],
            'optionType'       => ['nullable', 'string', 'required_if:isOption,true', Rule::enum(InputOptionType::class)],
            'optionSource'     => ['nullable', 'string', 'alpha_num:ascii', 'min:3', 'max:40', 'required_if:isOption,true'],
            'min'              => ['nullable', 'integer'],
            'max'              => ['nullable', 'integer'],
            'format'           => ['required', 'array'],
            'format.*'         => ['required', 'string', Rule::enum(DataFormat::class)],
            'default'          => ['required'],
        ];
    }
}
