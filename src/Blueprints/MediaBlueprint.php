<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Blueprints;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use RichanFongdasen\Blueprint\Enums\MediaType;

class MediaBlueprint extends AbstractBlueprint
{
    /**
     * The name of the media collection.
     */
    public string $name;

    /**
     * The type of the media collection.
     */
    public MediaType $type;

    /**
     * The maximum file size of the media collection in kilobytes.
     */
    public int $maxFileSize;

    /**
     * Determine whether the media collection has multiple files or not.
     */
    public bool $multiple;

    /**
     * Determine whether the media collection is responsive or not.
     * This option is only applicable for image type media collection.
     */
    public bool $responsive;

    /**
     * The image resize blueprint of the media collection.
     * This blueprint is only applicable for image type media collection.
     */
    public ?ImageResizeBlueprint $resize;

    /**
     * The image conversion blueprints of the media collection.
     * This blueprint is only applicable for image type media collection.
     */
    public Collection $conversions;

    /**
     * Create a new media blueprint instance.
     */
    public function __construct(array $blueprint)
    {
        $blueprint = $this->validate($blueprint);

        $this->name = $blueprint->get('name');
        $this->type = MediaType::from($blueprint->get('type') ?? MediaType::DEFAULT->value);
        $this->maxFileSize = (int) $blueprint->get('maxFileSize', 10240);
        $this->multiple = (bool) $blueprint->get('multiple', false);
        $this->responsive = (bool) $blueprint->get('responsive', false);
        $this->resize = ! $blueprint->has('resize')
            ? null
            : new ImageResizeBlueprint($blueprint->get('resize'));

        $this->conversions = ! $blueprint->has('conversions')
            ? new Collection()
            : (new Collection($blueprint->get('conversions')))
                ->map(function (array $conversion) {
                    return new ImageResizeBlueprint($conversion);
                });

        $this->normalizeBlueprint();
    }

    /**
     * Normalize the media blueprint.
     */
    protected function normalizeBlueprint(): void
    {
        if ($this->type !== MediaType::IMAGE) {
            $this->responsive = false;
            $this->resize = null;
            $this->conversions = new Collection();
        }
    }

    /**
     * Define the validation rules for the media blueprint.
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'alpha_dash:ascii', 'min:3', 'max:40'],
            'type'        => ['nullable', 'string', Rule::enum(MediaType::class)],
            'maxFileSize' => ['nullable', 'integer', 'min:1024', 'max:20480'],
            'multiple'    => ['nullable', 'boolean'],
            'responsive'  => ['nullable', 'boolean'],
            'resize'      => ['nullable', 'array'],
            'conversions' => ['nullable', 'array'],
        ];
    }
}
