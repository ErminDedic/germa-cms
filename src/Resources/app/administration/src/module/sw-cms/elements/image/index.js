import './config';
import './component';

const cmsElements = Shopware.Service('cmsService').getCmsElementRegistry();

const cmsElImage = cmsElements['image'];
const cmsElImageDefaultConfig = cmsElImage.defaultConfig;

cmsElImage.defaultConfig = {
    ...cmsElImageDefaultConfig,
    roundedCorners: {
        source: 'static',
        value: false
    }
}