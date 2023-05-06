import template from './sw-cms-link-field.html.twig';
import './sw-cms-link-field.scss';

const { Component } = Shopware;

Component.register('sw-cms-link-field', {
    template,

    props: {
        sectionTitle: {
            type: String
        },

        text: {
            type: String
        },

        url: {
            type: String
        },

        title: {
            type: String
        },

        newTab: {
            type: Boolean
        },

        hasCategory: {
            type: Boolean
        },

        isEntity: {
            type: Boolean,
            default: false
        },

        entity: {
            type: String
        }
    },

    computed: {

        textValue:{
            get() { return this.text; },
            set(value) { this.$emit('update:text', value) }
        },

        urlValue:{
            get() { return this.url; },
            set(value) { this.$emit('update:url', value) }
        },

        titleValue:{
            get() { return this.title; },
            set(value) { this.$emit('update:title', value) }
        },

        entityValue:{
            get() { return this.entity; },
            set(value) { this.$emit('update:entity', value) }
        },

        isEntityValue: {
            get () { return this.isEntity },
            set (isEntity) { this.$emit('update:isEntity', isEntity)}
        },

        newTabValue: {
            get () { return this.newTab },
            set (opensNewTab) { this.$emit('update:newTab', opensNewTab) }
        }
    }
});
