import template from './sw-cms-el-image-slider.html.twig';
import './sw-cms-el-image-slider.scss';

Shopware.Component.override('sw-cms-el-image-slider', {
    template,

    computed: {
        roundedCorners() {
            if (this.element.config.roundedCorners.value == true) {
                return 'rounded'
            }
        }
    }
});
