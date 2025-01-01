<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Blueprints;

use BackedEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use JsonSerializable;

abstract class AbstractBlueprint implements Arrayable, Jsonable, JsonSerializable
{
    /**
     * Specify data which should be serialized to JSON.
     *
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     *
     * @since 5.4
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * Create a new blueprint instance.
     */
    public static function make(array $blueprint): static
    {
        return new static($blueprint);
    }

    /**
     * Define the validation rules for the blueprint.
     */
    abstract public function rules(): array;

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect(get_object_vars($this))
            ->map(function ($value) {
                if ($value instanceof Arrayable) {
                    return $value->toArray();
                }

                if ($value instanceof BackedEnum) {
                    return $value->value;
                }

                return $value;
            })
            ->toArray();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return (string) json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Validate the blueprint.
     */
    public function validate(array $blueprint): Collection
    {
        $validator = Validator::make($blueprint, $this->rules());

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        return new Collection($validator->validated());
    }
}
