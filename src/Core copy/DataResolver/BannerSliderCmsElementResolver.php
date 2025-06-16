<?php declare(strict_types=1);

namespace Sisi\PluginElements\Core\DataResolver;

use Shopware\Core\Content\Media\Cms\Type\ImageSliderTypeDataResolver;

class BannerSliderCmsElementResolver extends ImageSliderTypeDataResolver
{
    public function getType(): string
    {
        return 'banner-slider';
    }
}
