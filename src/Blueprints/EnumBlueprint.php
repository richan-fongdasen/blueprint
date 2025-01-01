<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Blueprints;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use RichanFongdasen\Blueprint\Enums\EnumType;

class EnumBlueprint extends AbstractBlueprint
{
    /**
     * The name of the enum.
     */
    public string $name;

    /**
     * The type of the enum.
     */
    public EnumType $type;

    /**
     * The cases of the enum.
     *
     * The case key should be in uppercase, snake_case format.
     * The case value should be string or integer.
     * Example:
     * [ 'ACTIVE' => 'active', 'INACTIVE' => 'inactive' ]
     */
    public Collection $cases;

    /**
     * The default case of the enum.
     */
    public ?string $defaultCase;

    /**
     * Create a new enum blueprint instance.
     */
    public function __construct(array $blueprint)
    {
        $blueprint = $this->validate($blueprint);

        $this->name = $blueprint->get('name');
        $this->type = EnumType::from($blueprint->get('type') ?? EnumType::DEFAULT->value);
        $this->cases = new Collection($blueprint->get('cases'));
        $this->defaultCase = $blueprint->get('defaultCase');
    }

    /**
     * Create a new enum blueprint instance.
     */
    public static function make(array $blueprint): static
    {
        return new static($blueprint);
    }

    /**
     * Define the validation rules for the enum blueprint.
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'alpha_num:ascii', 'min:3', 'max:40'],
            'type'        => ['nullable', 'string', Rule::enum(EnumType::class)],
            'cases'       => ['required', 'array'],
            'cases.*'     => ['required'],
            'defaultCase' => ['nullable', 'string', 'alpha_num:ascii'],
        ];
    }
}
