require("./bootstrap");

import Vue from 'vue';
import VueTailwind from 'vue-tailwind'
import moment from "moment";
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

Vue.component("board-overview", require("./components/BoardOVComponent.vue").default);
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

var formatter = {
    date: function (value, format) {
        if (value) {
            return moment(String(value)).format(format || 'MM/DD/YY')
        }
    },
    time: function (value, format) {
        if (value) {
            return moment(String(value)).format(format || 'h:mm A');
        }
    },
    full_beauty: function (value, format) {
        if (value) {
            return moment(String(value)).format(format || 'MMM Do YYYY - hh:mm')
        }
    }
};

Vue.component('format', {
    template: `<span>{{ formatter[fn](value, format) }}</span>`,
    props: ['value', 'fn', 'format'],
    computed: {
        formatter() {
            return formatter;
        }
    }
});

const app = new Vue({
    el: "#app"
});
