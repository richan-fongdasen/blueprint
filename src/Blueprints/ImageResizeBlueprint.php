<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Blueprints;

class ImageResizeBlueprint extends AbstractBlueprint
{
    /**
     * The name of the image resize.
     */
    public string $name;

    /**
     * The width of the image resize.
     */
    public int $width;

    /**
     * The height of the image resize.
     */
    public int $height;

    /**
     * Determine if the image should be cropped or not.
     */
    public bool $crop;

    /**
     * Define the sharpen level of the image.
     */
    public int $sharpen;

    /**
     * Determine if the image should be optimized or not.
     */
    public bool $optimize;

    /**
     * Create a new image resize blueprint instance.
     */
    public function __construct(array $blueprint)
    {
        $blueprint = $this->validate($blueprint);

        $this->name = $blueprint->get('name', 'DEFAULT');
        $this->width = (int) $blueprint->get('width');
        $this->height = (int) $blueprint->get('height');
        $this->crop = (bool) $blueprint->get('crop', true);
        $this->sharpen = (int) $blueprint->get('sharpen', 0);
        $this->optimize = (bool) $blueprint->get('optimize', true);
    }

    /**
     * Create a new image resize blueprint instance.
     */
    public static function make(array $blueprint): static
    {
        return new static($blueprint);
    }

    /**
     * Define the validation rules for the image resize blueprint.
     */
    public function rules(): array
    {
        return [
            'name'     => ['nullable', 'string', 'alpha_dash:ascii', 'min:3', 'max:40'],
            'width'    => ['required', 'integer', 'min:100'],
            'height'   => ['required', 'integer', 'min:100'],
            'crop'     => ['nullable', 'boolean'],
            'sharpen'  => ['nullable', 'integer', 'min:0', 'max:100'],
            'optimize' => ['nullable', 'boolean'],
        ];
    }
}
