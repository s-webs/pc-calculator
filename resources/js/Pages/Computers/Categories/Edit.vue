<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, usePage} from "@inertiajs/vue3";
import {reactive} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    item: Object,
});

const form = reactive({
    name: props.item.name,
});

function updateCategory() {
    router.put(route('pc-categories.update', props.item.id), form);
}

const flash = usePage().props.flash;

</script>

<template>
    <AppLayout title="Dashboard">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Добавить категорию ПК
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div>
                        <Link :href="route('pc-categories.index')" class="block px-[30px] py-[10px] bg-gray-300 text-white font-semibold">Назад</Link>
                    </div>
                    <form @submit.prevent="updateCategory" class="mt-[60px]">
                        <div class="mb-4">
                            <label for="name">Название категории</label>
                            <input id="name" v-model="form.name" type="text" placeholder="Введите название категории"
                                   class="w-full" required>
                        </div>
                        <button class="w-full block px-[30px] py-[20px] bg-green-500 text-white font-semibold">
                            Обновить
                        </button>
                    </form>
                    <div>
                    </div>
                    <div></div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
