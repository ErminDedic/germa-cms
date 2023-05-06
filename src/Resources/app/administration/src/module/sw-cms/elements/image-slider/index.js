import './config';
// import './component';

const cmsElements = Shopware.Service('cmsService').getCmsElementRegistry();

const cmsElImageSlider = cmsElements['image-slider'];
const cmsElImageSliderDefaultConfig = cmsElImageSlider.defaultConfig;

cmsElImageSlider.defaultConfig = {
    ...cmsElImageSliderDefaultConfig,
    itemsXs: {
        source: 'static',
        value: 1
    },
    itemsSm: {
        source: 'static',
        value: 1
    },
    itemsMd: {
        source: 'static',
        value: 1
    },
    itemsLg: {
        source: 'static',
        value: 1
    },
    itemsXl: {
        source: 'static',
        value: 1
    },
    gutter: {
        source: 'static',
        value: 0
    }
}

cmsElImageSlider.enrich = function enrich(elem, data) {
    if (Object.keys(data).length < 1) {
        return;
    }

    let entityCount = 0;
    Object.keys(elem.config).forEach((configKey) => {
        const entity = elem.config[configKey].entity;

        if (!entity) {
            return;
        }

        const entityKey = `entity-${entity.name}-${entityCount}`;
        entityCount += 1;

        if (!data[entityKey]) {
            return;
        }

        elem.data[configKey] = [];
        elem.config[configKey].value.forEach((sliderItem) => {
            elem.data[configKey].push({
                newTab: sliderItem.newTab,
                url: sliderItem.url,
                media: data[entityKey].get(sliderItem.mediaId),
                text: sliderItem.text
            });
        });
    });
}
