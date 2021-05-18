<template>
    <div>
        <div class="relative p-2 flex overflow-x-auto h-full">
            <!-- Columns (Statuses) -->
            <draggable
                class="flex-1"
                handle=".status-drag-item"
                v-model="statuses"
                v-bind="statusDragOptions"
                @end="handleStatusMoved"
            >
                <transition-group
                    class="flex-1 flex  h-full rounded shadow-xs" name="statuses"
                    tag="div"
                >
                    <div
                        v-for="status in statuses"
                        :key="status.id"
                        class="mr-6 w-4/5 max-w-xs flex-shrink-0 status-drag-item"
                    >
                        <div class="rounded-md shadow-md overflow-hidden">
                            <div class="p-3 flex justify-between items-baseline bg-blue-900">
                                <h4 class="font-medium text-white">
                                    {{ status.title }}
                                </h4>
                                <button
                                    @click="openAddTaskForm(status.id)"
                                    class="py-1 px-2 text-sm text-white hover:underline"
                                >
                                    Add Task
                                </button>
                            </div>

                            <div class="p-2 bg-gray-100">
                                <!-- AddTaskForm -->
                                <AddTaskForm
                                    v-if="newTaskForStatus === status.id"
                                    :status-id="status.id"
                                    v-on:task-added="handleTaskAdded"
                                    v-on:task-canceled="closeAddTaskForm"
                                />
                                <!-- ./AddTaskForm -->

                                <!-- Tasks -->
                                <draggable
                                    class="flex-1 overflow-hidden"
                                    v-model="status.tasks"
                                    v-bind="taskDragOptions"
                                    @end="handleTaskMoved"
                                >
                                    <transition-group
                                        class="flex-1 flex flex-col h-full overflow-x-hidden overflow-y-auto rounded shadow-xs"
                                        tag="div"
                                    >
                                        <div
                                            v-for="task in status.tasks"
                                            :key="task.id"
                                            @click="showTaskModel(task)"
                                            class="mb-3 p-4 flex flex-col bg-white rounded-md shadow transform hover:shadow-md cursor-pointer"
                                        >
                                        <span class="block mb-2 text-xl text-gray-900">
                                          {{ task.title }}
                                        </span>

                                            <p class="text-gray-700">
                                                {{ task.description }}
                                            </p>
                                        </div>
                                        <!-- ./Tasks -->
                                    </transition-group>
                                </draggable>
                                <!-- No Tasks -->
                                <div
                                    v-show="!status.tasks.length && newTaskForStatus !== status.id"
                                    class="flex-1 p-4 flex flex-col items-center justify-center"
                                >
                                    <span class="text-gray-600">No tasks yet</span>
                                    <button
                                        class="mt-1 text-sm text-blue-500 mt-2 hover:underline"
                                        @click="openAddTaskForm(status.id)"
                                    >
                                        Add one
                                    </button>
                                </div>
                                <!-- ./No Tasks -->
                            </div>
                        </div>
                    </div>

                    <!-- AddStatusForm -->
                    <AddStatusForm v-on:status-added="handleStatusAdded" :key="0" :last-order="this.newStatusOrder"></AddStatusForm>
                    <!-- ./AddStatusForm -->
                </transition-group>
            </draggable>
            <!-- ./Columns -->
        </div>

        <ModalComponent :open="showDetailModal" @close="showDetailModal = false">
            <div class="lg:flex">
                <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('https://tailwindcss.com/img/card-left.jpg')" title="Woman holding a mug">
                </div>
                <div class="p-4 flex flex-col justify-between leading-normal bg-white">
                    <div class="mb-8">
                        <t-dropdown>
                            <div
                                slot="trigger"
                                slot-scope="{
                                  mousedownHandler,
                                  focusHandler,
                                  blurHandler,
                                  keydownHandler,
                                  isShown
                                }"
                            >
                                <p class="text-sm text-grey-dark flex items-center select-none"
                                   :class="{ isShown }"
                                   @mousedown="mousedownHandler"
                                   @focus="focusHandler"
                                   @blur="blurHandler"
                                   @keydown="keydownHandler">
                                    <i class="fas fa-bars mr-3"></i>
                                    {{ this.showDetailModalTask.board.title + " - " + this.showDetailModalTask.title }}
                                </p>
                            </div>

                            <div slot-scope="{ hide, blurHandler }">
                                <button
                                    class="block w-full px-4 py-2 text-sm leading-5 text-black transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    @click="hide"
                                >
                                    Members
                                </button>

                                <button
                                    class="block w-full px-4 py-2 text-sm leading-5 text-black transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    @click="hide"
                                >
                                    Labels
                                </button>

                                <button
                                    class="block w-full px-4 py-2 text-sm leading-5 text-black transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    @click="hide"
                                >
                                    Deadline
                                </button>

                                <button
                                    class="block w-full px-4 py-2 text-sm leading-5 text-black transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    @click="hide"
                                >
                                    Attachments
                                </button>

                                <button
                                    class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out border-t hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    role="menuitem"
                                    @blur="blurHandler"
                                >
                                    Move
                                </button>

                                <button
                                    class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    role="menuitem"
                                    @blur="blurHandler"
                                >
                                    Copy
                                </button>

                                <button
                                    class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    role="menuitem"
                                    @blur="blurHandler"
                                >
                                    Share
                                </button>

                                <button
                                    class="block w-full px-4 py-2 text-sm leading-5 text-yellow-500 transition duration-150 ease-in-out border-t hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    @click="hide"
                                >
                                    Archive
                                </button>

                                <button
                                    class="block w-full px-4 py-2 text-sm leading-5 text-red-500 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                    @click="hide"
                                >
                                    Delete
                                </button>
                            </div>
                        </t-dropdown>

                        <div class="text-black font-bold text-xl mb-2">{{ this.showDetailModalTask.title }}</div>
                        <p class="text-grey-darker text-base">{{ this.showDetailModalTask.description }}</p>
                    </div>
                    <div class="flex items-center">
                        <img class="w-10 h-10 rounded-full mr-4" :src="this.showDetailModalTask.creator.picture" :alt="'Avatar of ' + this.showDetailModalTask.creator.name">
                        <div class="text-sm">
                            <p class="text-black leading-none" >{{ this.showDetailModalTask.creator.name }}</p>
                            <p class="text-grey-dark"><format :value="this.showDetailModalTask.updated_at" fn="full_beauty" /></p>
                        </div>
                    </div>
                </div>
            </div>
        </ModalComponent>
    </div>
</template>

<script>
import draggable from "vuedraggable";
import AddTaskForm from "./AddTaskForm";
import AddStatusForm from "./AddStatusForm";
import ModalComponent from "./ModalComponent";
import moment from "moment";

window.Vue.use(draggable);

export default {
    components: { draggable, AddTaskForm, AddStatusForm, ModalComponent },
    props: {
        initialData: Array
    },
    data() {
        return {
            statuses: [],

            newTaskForStatus: 0,
            newStatusOrder: 0,

            showDetailModal: false,
            showDetailModalTask: {
                title: '',
                description: '',
                created_at: '1970-01-01T00:00:00.000000Z',
                updated_at: '1970-01-01T00:00:00.000000Z',

                board: {
                    title: '',
                    creator: {
                        name: '',
                        picture: ''
                    }
                },

                creator: {
                    name: 'Jan Ruhfus',
                    picture: 'https://i.imgur.com/DY3Th0n.png'
                }
            }
        };
    },
    computed: {
        taskDragOptions() {
            return {
                animation: 200,
                group: "task-list",
                dragClass: "task-drag"
            };
        },
        statusDragOptions() {
            return {
                animation: 200,
                group: "status-list",
                dragClass: "status-drag"
            }
        }
    },
    mounted() {
        // 'clone' the statuses so we don't alter the prop when making changes
        this.statuses = JSON.parse(JSON.stringify(this.initialData));
        this.newStatusOrder = this.statuses[this.statuses.length - 1].order + 1;

        console.log(this.showDetailModalTask.created_at)
    },
    methods: {
        openAddTaskForm(statusId) {
            this.newTaskForStatus = statusId;
        },
        closeAddTaskForm() {
            this.newTaskForStatus = 0;
        },
        handleTaskAdded(newTask) {
            // Find the index of the status where we should add the task
            const statusIndex = this.statuses.findIndex(
                status => status.id === newTask.status_id
            );

            // Add newly created task to our column
            this.statuses[statusIndex].tasks.push(newTask);

            // Reset and close the AddTaskForm
            this.closeAddTaskForm();
        },
        handleTaskMoved(evt) {
            axios.put("/tasks/sync", { columns: this.statuses }).catch(err => {
                console.log(err.response);
            });
        },
        handleStatusAdded(newStatus) {
            // Add newly created task to our column
            newStatus.tasks = [];
            this.statuses.push(newStatus);
        },
        handleStatusMoved(evt) {
            axios.put("/statuses/sync", { columns: this.statuses }).catch(err => {
                console.log(err.response);
            });
        },
        showTaskModel(task) {
            this.showDetailModalTask = task;
            this.showDetailModalTask.board = {
                title: 'Laravel',
                creator: {
                    name: 'Jan Ruhfus',
                    picture: 'https://i.imgur.com/DY3Th0n.png'
                }
            }
            this.showDetailModalTask.creator = {
                name: 'Jan Ruhfus',
                picture: 'https://i.imgur.com/DY3Th0n.png'
            }

            console.log(this.showDetailModalTask)
            this.showDetailModal = true;
        }
    }
};
</script>

<style scoped>
.task-drag {
    transition: transform 0.5s;
    transition-property: all;
}
</style>
