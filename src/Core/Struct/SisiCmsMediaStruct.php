
<?php declare(strict_types=1);

namespace Sisi\PluginElements\Core\Struct;

use Shopware\Core\Framework\Log\Package;
use Shopware\Core\Framework\Struct\Struct;
use Shopware\Core\Content\Cms\SalesChannel\Struct\ImageStruct;

#[Package('buyers-experience')]
class SisiCmsMediaStruct extends Struct
{
    /**
     * @var ImageStruct[]|null
     */
    protected $mediaItems = [];

    /**
     * @return ImageStruct[]|null
     */
    public function getMediaItems(): ?array
    {
        return $this->mediaItems;
    }

    /**
     * @param ImageStruct[]|null $mediaItems
     */
    public function setMediaItems(?array $mediaItems): void
    {
        $this->mediaItems = $mediaItems;
    }

    public function addMediaItem($key, $mediaItem): void
    {
        $this->mediaItems[$key] = $mediaItem;
    }
}