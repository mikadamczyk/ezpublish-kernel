<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\FieldType\Generic;

use eZ\Publish\Core\FieldType\FieldSettings;
use eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter as ConverterInterface;
use eZ\Publish\Core\Persistence\Legacy\Content\StorageFieldDefinition;
use eZ\Publish\Core\Persistence\Legacy\Content\StorageFieldValue;
use eZ\Publish\SPI\Persistence\Content\FieldValue;
use eZ\Publish\SPI\Persistence\Content\Type\FieldDefinition;
use Symfony\Component\Serializer\Serializer;

class Converter implements ConverterInterface
{
    /** @var \Symfony\Component\Serializer\Serializer */
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function toStorageValue(FieldValue $value, StorageFieldValue $storageFieldValue): void
    {
        $data = $value->data;
        if ($data !== null) {
            $data = $this->serializer->encode($data, 'json');
        }

        $storageFieldValue->dataText = $data;
    }

    public function toFieldValue(StorageFieldValue $value, FieldValue $fieldValue): void
    {
        $data = $value->dataText;
        if ($data !== null) {
            $data = $this->serializer->decode($data, 'json');
        }

        $fieldValue->data = $data;
    }

    public function toStorageFieldDefinition(FieldDefinition $fieldDefinition, StorageFieldDefinition $storageDefinition): void
    {
        $settings = $fieldDefinition->fieldTypeConstraints->fieldSettings;
        if ($settings !== null) {
            $settings = $this->serializer->encode($settings, 'json');
        }

        $storageDefinition->dataText5 = $settings;
    }

    public function toFieldDefinition(StorageFieldDefinition $storageDefinition, FieldDefinition $fieldDefinition): void
    {
        $settings = $storageDefinition->dataText5;
        if ($settings !== null) {
            $settings = new FieldSettings($this->serializer->decode($settings, 'json'));
        }

        $fieldDefinition->fieldTypeConstraints->fieldSettings = $settings;
    }

    public function getIndexColumn()
    {
        return false;
    }
}
