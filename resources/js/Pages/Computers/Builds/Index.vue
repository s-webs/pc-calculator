<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, router} from "@inertiajs/vue3";

defineProps({
    items: Array
})

function deleteComponent(id) {
    if (confirm('Вы уверены, что хотите удалить эту сборку?')) {
        router.delete(route('pc-builds.destroy', id));
    }
}
</script>

<template>
    <AppLayout title="Сборки ПК">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Сборки ПК
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <Link :href="route('pc-builds.create')" class="block px-[30px] py-[20px] bg-green-500 text-white font-semibold text-center">Добавить</Link>
                    </div>
                    <div>
                        <div v-for="(item, index) in items" class="bg-blue-200 mt-2 p-4 flex items-center justify-between flex-wrap">
                            <div class="flex items-center">
                                <div class="mr-2">{{ index+1 }}.</div>
                                <div class="mr-2 shrink-0" v-if="item.image !== null">
                                    <img :src="item.image" :alt="item.name" class="w-[70px] h-[70px] object-cover">
                                </div>
                                <div class="mr-4">{{ item.name }} | Себестоимость: {{ item.prime_cost }} | Цена продажи: {{ item.sale_price}}</div>
                                <div class="mr-2">
                                    <ul class="overflow-x-auto">
                                         <li class="font-semibold">Компоненты:</li>
                                        <li v-for="(component, index) in JSON.parse(item.components)" :key="component.id">
                                            {{ index+1 }}. {{ component.name }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <Link :href="route('pc-builds.edit', item.id)" class=" mr-2">
                                    <div class="border p-2 border-blue-500">Редактировать</div>
                                </Link>
                                <button @click="deleteComponent(item.id)" class="border p-2 border-red-500">Удалить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
