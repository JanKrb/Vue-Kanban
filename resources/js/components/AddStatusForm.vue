<template>
    <div class="mr-6 w-4/5 max-w-xs flex-shrink-0">
        <form
            class="relative mb-3 flex flex-col justify-between bg-white rounded-md shadow overflow-hidden"
            @submit.prevent="handleAddNewStatus"
        >
            <div class="rounded-md shadow-md overflow-hidden">
                <div class="p-3 flex justify-between items-baseline bg-blue-900">
                    <input
                        class="block w-full px-2 py-1 text-md text-white focus:outline-none border-b border-blue-700 mr-2 bg-transparent rounded"
                        type="text"
                        placeholder="Enter a title..."
                        v-model.trim="newStatus.title"
                    />

                    <!-- @click="openAddTaskForm(status.id)" -->
                    <button class="py-1 px-2 text-sm text-white hover:underline focus:outline-none">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        lastOrder: Number,
        boardId: Number
    },
    data() {
        return {
            newStatus: {
                title: "",
                order: 0,
                board_id: this.boardId
            },
            errorMessage: ""
        };
    },
    methods: {
        handleAddNewStatus() {
            // Basic validation so we don't send an empty task to the server
            if (!this.newStatus.title) {
                this.errorMessage = "The title field is required";
                return;
            }

            this.newStatus.order = this.lastOrder;

            axios
                .post(`${this.boardId}/statuses`, this.newStatus)
                .then(res => {
                    // Tell the parent component we've added a new task and include it
                    this.$emit("status-added", res.data);
                })
                .catch(err => {
                    // Handle the error returned from our request
                    this.handleErrors(err);
                });

            this.newStatus = {
                title: "",
                order: 0,
            };
        },
        handleErrors(err) {
            if (err.response && err.response.status === 422) {
                // We have a validation error
                const errorBag = err.response.data.errors;
                if (errorBag.title) {
                    this.errorMessage = errorBag.title[0];
                } else if (errorBag.description) {
                    this.errorMessage = errorBag.description[0];
                } else {
                    this.errorMessage = err.response.message;
                }
            } else {
                // We have bigger problems
                console.log(err.response);
            }
        }
    }
};
</script>
