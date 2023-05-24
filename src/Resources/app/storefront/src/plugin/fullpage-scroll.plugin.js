import Plugin from 'src/plugin-system/plugin.class';
import fullpage from '../../node_modules/fullpage.js';

export default class MovingImagePlugin extends Plugin {
    init() {
        new fullpage('.cms-sections', {
            //options here
            autoScrolling:true,
            scrollHorizontally: true,
            sectionSelector: '.cms-section',
            fixedElements: '.header-main, .footer-main',
        });
    }
}