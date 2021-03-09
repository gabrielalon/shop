<?php

namespace App\System\Spatie\Integration\Service;

use App\System\Spatie\Media\MediaEnum;
use App\System\Spatie\Media\MediaException;
use App\System\Spatie\Media\MediaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia as HasMediaTrait;
use Spatie\MediaLibrary\MediaCollections\Exceptions;

class MediaSpatieService implements MediaService
{
    public function __call($name, $arguments): string
    {
        if (true === MediaEnum::isValidKey($name)) {
            return (string) MediaEnum::toArray()[$name];
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function setMedia(Model $model, UploadedFile $image, MediaEnum $collection, array $headers = []): void
    {
        /** @var HasMedia|HasMediaTrait $model */
        if ($model->hasMedia($collection->getValue())) {
            $this->deleteMedia($model, $collection);
        }

        try {
            $model
                ->addMedia($image)
                ->usingFileName($this->hashFileName($image))
                ->addCustomHeaders($headers)
                ->toMediaCollection($collection->getValue())
            ;
        } catch (Exceptions\FileCannotBeAdded $exception) {
            MediaException::throwFromException($exception);
        } catch (\Exception $exception) {
            MediaException::throwFromException($exception);
        }
    }

    /**
     * @param UploadedFile $image
     *
     * @return string
     */
    private function hashFileName(UploadedFile $image): string
    {
        return md5($image->hashName().microtime()).'.'.$image->extension();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteMedia(Model $model, MediaEnum $collection): void
    {
        /** @var HasMedia|HasMediaTrait $model */
        $media = $model->getMedia($collection->getValue());

        try {
            $model->deleteMedia($media->first());
        } catch (Exceptions\MediaCannotBeDeleted $exception) {
        }
    }
}
