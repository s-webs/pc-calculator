<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, router} from "@inertiajs/vue3";

defineProps({
    items: Array
})

function deleteCategory(id) {
    if (confirm('Вы уверены, что хотите удалить эту категорию?')) {
        router.delete(route('pc-categories.destroy', id));
    }
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Категории ПК
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <Link :href="route('pc-categories.create')" class="block px-[30px] py-[20px] bg-green-500 text-white font-semibold text-center">Добавить</Link>
                    </div>
                    <div>
                        <div v-for="(item, index) in items" class="bg-blue-200 mt-2 p-4 flex items-center justify-between">
                            <div>{{ index+1 }}. {{ item.name }}</div>
                            <div class="flex items-center">
                                <Link :href="route('pc-categories.edit', item.id)" class=" mr-2">
                                    <div class="border p-2 border-blue-500">Редактировать</div>
                                </Link>
                                <button @click="deleteCategory(item.id)" class="border p-2 border-red-500">Удалить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
