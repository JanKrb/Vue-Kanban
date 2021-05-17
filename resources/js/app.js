require("./bootstrap");

import Vue from 'vue';
import VueTailwind from 'vue-tailwind'

import {
    TInput,
    TTextarea,
    TSelect,
    TRadio,
    TCheckbox,
    TButton,
    TInputGroup,
    TCard,
    TAlert,
    TModal,
    TDropdown,
    TRichSelect,
    TPagination,
    TTag,
    TRadioGroup,
    TCheckboxGroup,
    TTable,
    TDatepicker,
    TToggle,
    TDialog,
} from 'vue-tailwind/dist/components';

window.Vue = Vue;

Vue.component("kanban-board", require("./components/KanbanBoard.vue").default);

const settings = {
    't-input': {
        component: TInput,
        props: {
            classes: 'border-2 block w-full rounded text-gray-800'
        }
    },
    't-textarea': {
        component: TTextarea,
        props: {
            classes: 'border-2 block w-full rounded text-gray-800'
        }
    },
    't-button': {
        component: TButton,
        props: {}
    },
    't-dropdown': {
        component: TDropdown,
        props: {}
    }
}

Vue.use(VueTailwind, settings)

const app = new Vue({
    el: "#app"
});
