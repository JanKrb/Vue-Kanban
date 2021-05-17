require("./bootstrap");

import Vue from 'vue';
window.Vue = Vue;

Vue.component("kanban-board", require("./components/KanbanBoard.vue").default);

const app = new Vue({
    el: "#app"
});
