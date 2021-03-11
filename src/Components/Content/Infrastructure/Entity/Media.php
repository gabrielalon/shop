<?php

namespace App\Components\Content\Infrastructure\Entity;

use Spatie\MediaLibrary\MediaCollections\Models\Media as Spatie;

/**
 * @property int    $id
 * @property string $model_type
 * @property string $model_id
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string $mime_type
 * @property string $disk
 * @property int    $size
 * @property array  $manipulations
 * @property array  $custom_properties
 * @property array  $generated_conversions
 * @property array  $responsive_images
 */
final class Media extends Spatie
{
}
