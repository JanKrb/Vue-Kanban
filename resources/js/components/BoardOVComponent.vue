<template>
    <div class="flex flex-col sm:flex-row flex-wrap justify-center items-center py-4 px-12">

        <div class="flex-shrink sm:w-80 mb-6 sm:mr-6" v-for="board in this.boards">
            <div class="flex flex-col">
                <a :href="/board/ + board.id" class="no-underline">
                    <div class="border-t-8 border-blue-800 rounded-t-lg"></div>
                    <div class="border-b border-l border-r border-grey shadow-md rounded-b-lg p-4">
                        <div class="flex">
                            <div class="flex justify-center items-center text-lg border-2 border-pink-light text-pink-light rounded-full w-12 h-12 font-medium">
                                <i class="fab fa-trello"></i>
                            </div>
                            <div class="flex flex-col ml-8 mt-1">
                                <div class="flex-1 text-black">{{ board.title }}</div>
                                <div class="flex-1 text-xs text-grey mt-2">@{{ board.user.name }}</div>
                                <div class="flex-1 text-xs text-grey mt-4">
                                    <i class="far fa-clock"></i>
                                    <format :value="board.created_at" fn="full_beauty" />
                                </div>
                                <div class="flex-1 text-xs text-grey mt-2">
                                    <i class="fas fa-edit"></i>
                                    <format :value="board.updated_at" fn="full_beauty" />
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
</template>

<script>
import ModalComponent from "./ModalComponent";

export default {
    components: { ModalComponent },
    props: {
        initialData: Array
    },
    data() {
        return {
            boards: [],
        };
    },
    computed: {

    },
    mounted() {
        this.boards = JSON.parse(JSON.stringify(this.initialData));
    },
    methods: {

    }
};
</script>

<style scoped>

</style>
