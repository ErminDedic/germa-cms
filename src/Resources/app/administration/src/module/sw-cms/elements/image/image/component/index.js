import template from './sw-cms-el-image.html.twig';
import './sw-cms-el-image.scss';

Shopware.Component.override('sw-cms-el-image', {
    template,

    computed: {
        roundedCorners() {
            if (this.element.config.roundedCorners.value == true) {
                return 'rounded'
            }
        }
    }
});
