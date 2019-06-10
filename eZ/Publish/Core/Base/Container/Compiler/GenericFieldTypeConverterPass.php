<?php

/**
 * File containing the FieldTypeCollectionPass class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Publish\Core\Base\Container\Compiler;

use eZ\Publish\Core\Base\Container\Compiler\Storage\Legacy\FieldValueConverterRegistryPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This compiler pass will register eZ Publish field types.
 */
class GenericFieldTypeConverterPass implements CompilerPassInterface
{
    public const FIELD_TYPE_SERVICE_TAG = 'ezplatform.field_type';
    public const DEPRECATED_FIELD_TYPE_SERVICE_TAG = 'ezpublish.fieldType';

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @throws \LogicException
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ezpublish.persistence.legacy.field_value_converter.registry')) {
            return;
        }

        $deprecatedFieldTypeTags = $container->findTaggedServiceIds(self::DEPRECATED_FIELD_TYPE_SERVICE_TAG);
        $fieldTypeTags = $container->findTaggedServiceIds(self::FIELD_TYPE_SERVICE_TAG);
        $fieldTypesTags = array_merge($deprecatedFieldTypeTags, $fieldTypeTags);

        $registry = $container->getDefinition('ezpublish.persistence.legacy.field_value_converter.registry');

        $converterTags = $this->getFieldTypeConverterServiceTags($container);
        foreach ($fieldTypesTags as $id => $attributes) {
            foreach ($attributes as $attribute) {
                if (isset($attribute['alias']) && !isset($converterTags[$attribute['alias']])) {
                    $registry->addMethodCall(
                        'register',
                        array(
                            $attribute['alias'],
                            new Reference('ezpublish.fieldType.generic.converter'),
                        )
                    );
                }
            }
        }
    }

    private function getFieldTypeConverterServiceTags(ContainerBuilder $container): array
    {
        $deprecatedFieldTypeStorageConverterTags = $container->findTaggedServiceIds(FieldValueConverterRegistryPass::DEPRECATED_STORAGE_ENGINE_LEGACY_CONVERTER_SERVICE_TAG);
        $fieldTypeStorageConverterTags = $container->findTaggedServiceIds(FieldValueConverterRegistryPass::STORAGE_ENGINE_LEGACY_CONVERTER_SERVICE_TAG);

        $storageConverterFieldTypesTags = array_merge($deprecatedFieldTypeStorageConverterTags, $fieldTypeStorageConverterTags);

        $converterServiceTags = [];
        foreach ($storageConverterFieldTypesTags as $id => $attributes) {
            foreach ($attributes as $attribute) {
                if (isset($attribute['alias'])) {
                    $converterServiceTags[$attribute['alias']] = [$id => $attributes];
                }
            }
        }

        return $converterServiceTags;
    }
}
