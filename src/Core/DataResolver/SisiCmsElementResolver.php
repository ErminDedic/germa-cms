<?php

declare(strict_types=1);

namespace Sisi\PluginElements\Core\DataResolver;

use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\FieldConfig;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\EntityResolverContext;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Content\Cms\SalesChannel\Struct\ImageStruct;
use Sisi\PluginElements\Core\Struct\SisiCmsMediaStruct;
use Shopware\Core\Content\Media\MediaDefinition;
use Shopware\Core\Content\Media\MediaEntity;
use Shopware\Core\Content\Media\Cms\AbstractDefaultMediaResolver;
use Shopware\Core\Framework\Log\Package;

#[Package('buyers-experience')]
class SisiCmsElementResolver extends AbstractCmsElementResolver
{
    final public const CMS_DEFAULT_ASSETS_PATH = '/bundles/storefront/assets/default/cms/';

    /**
     * @internal
     */
    public function __construct(private readonly AbstractDefaultMediaResolver $mediaResolver) {}

    public function getType(): string
    {
        return 'card';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        $config = $slot->getFieldConfig();
        $criteriaCollection = new CriteriaCollection();
        $index = 0;
        $criteria = [];

        foreach ($config->getElements() as $field) {
            if (is_string($field->getValue()) and $this->isUUID($field->getValue())) {
                $fieldMedia = $config->get($field->getName());

                if (!$fieldMedia) {
                    return null;
                }

                $fieldMediaId = $fieldMedia->getValue();
                $criteria[] = $fieldMediaId;

                $index++;
            }
        }

        if (empty($criteria)) {
            return null;
        }

        $criteria = new Criteria($criteria);
        $criteriaCollection->add('media_' . $slot->getUniqueIdentifier(), MediaDefinition::class, $criteria);

        return $criteriaCollection;
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $config = $slot->getFieldConfig();
        $itemsStruct = new SisiCmsMediaStruct();

        $index = 0;

        foreach ($config->getElements() as $field) {
            if (is_string($field->getValue()) and $this->isUUID($field->getValue())) {
                $mediaConfig = $config->get($field->getName());
                $fieldName = $field->getName();
                $field = new ImageStruct();
                $itemsStruct->addMediaItem($fieldName, $field);

                if ($mediaConfig && $mediaConfig->getValue()) {
                    $this->addMediaEntity($slot, $field, $result, $mediaConfig, $resolverContext, 'media_');
                }

                $index++;
            }
        }

        $slot->setData($itemsStruct);
    }

    private function isUUID($uuid)
    {
        // UUID pattern without hyphens
        $pattern = '/^[0-9a-f]{8}-?[0-9a-f]{4}-?[0-9a-f]{4}-?[0-9a-f]{4}-?[0-9a-f]{12}$/i';
        // Check if the string matches the pattern
        return preg_match($pattern, $uuid) === 1;
    }

    private function addMediaEntity(
        CmsSlotEntity $slot,
        ImageStruct $image,
        ElementDataCollection $result,
        FieldConfig $config,
        ResolverContext $resolverContext,
        $prefix
    ): void {
        if ($config->isDefault()) {
            $media = $this->mediaResolver->getDefaultCmsMediaEntity($config->getStringValue());

            if ($media) {
                $image->setMedia($media);
            }
        }

        if ($config->isMapped() && $resolverContext instanceof EntityResolverContext) {
            $media = $this->resolveEntityValue($resolverContext->getEntity(), $config->getStringValue());

            if ($media instanceof MediaEntity) {
                $image->setMediaId($media->getUniqueIdentifier());
                $image->setMedia($media);
            }
        }

        if ($config->isStatic()) {
            $image->setMediaId($config->getStringValue());

            $searchResult = $result->get($prefix . $slot->getUniqueIdentifier());
            if (!$searchResult) {
                return;
            }

            $media = $searchResult->get($config->getStringValue());
            if (!$media instanceof MediaEntity) {
                return;
            }

            $image->setMedia($media);
        }
    }
}
