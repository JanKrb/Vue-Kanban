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
            <div class="w-full bg-white rounded-lg shadow-2xl px-6 py-6">
                <h2 class="font-semibold text-gray-900 text-2xl leading-tight border-b-2 border-gray-200 pb-4">{{ this.showDetailModalTask.title }}</h2>

                <p class="mt-4 text-gray-700">{{ this.showDetailModalTask.description}}</p>
            </div>
        </ModalComponent>
    </div>
</template>

<script>
import draggable from "vuedraggable";
import AddTaskForm from "./AddTaskForm";
import AddStatusForm from "./AddStatusForm";
import ModalComponent from "./ModalComponent";

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
            showDetailModalTask: {}
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
            this.showDetailModal = true;
            this.showDetailModalTask = task;
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
