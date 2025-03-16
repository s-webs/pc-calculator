<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, usePage } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    categories: Array,
})

const availability = ref(false)

const toggleAvailability = () => {
    availability.value = !availability.value
}

const form = reactive({
    pc_category_id: null,
    name: null,
    image: null,
    prime_cost: null,
    sale_price: null,
    quantity: null,
    available: availability
})

const handleInput = (field, value) => {
    form[field] = value === '' ? null : Number(value);
}

function submit() {
    console.log(form)
    router.post(route('pc-components.store'), form)
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
                    <form @submit.prevent="submit" class="mt-[30px]">
                        <div class="mb-4">
                            <select id="category_id" v-model="form.pc_category_id" class="mr-2" required>
                                <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                            </select>
                            <label for="name">Выберите категорию</label>
                        </div>
                        <div class="mb-4">
                            <label for="name">Название компонента</label>
                            <input id="name" v-model="form.name" type="text" placeholder="Введите название компонента"
                                   class="w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="image">Ссылка на изображение</label>
                            <input id="image" v-model="form.image" type="text" placeholder="Вставьте ссылку на изображение"
                                   class="w-full">
                        </div>
                        <div class="mb-4">
                            <label for="prime_cost">Себестоимость</label>
                            <input id="prime_cost" v-model="form.prime_cost" type="number" class="w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="sale_price">Цена продажи</label>
                            <input id="sale_price" :value="form.sale_price" @input="handleInput('sale_price', $event.target.value)" type="number" class="w-full">
                        </div>
                        <div class="mb-4">
                            <label for="quantity">Количество (в наличии)</label>
                            <input id="quantity" :value="form.quantity" @input="handleInput('quantity', $event.target.value)" type="number" class="w-full">
                        </div>
                        <div class="mb-4 flex items-center">
                            <p class="mr-2">Статус: {{ availability ? 'В наличии' : 'Нет в наличии' }}</p>
                            <div class="relative w-14 h-8">
                                <input
                                    type="checkbox"
                                    class="sr-only"
                                    v-model="availability"
                                />
                                <div
                                    @click="toggleAvailability"
                                    class="block w-full h-full rounded-full cursor-pointer transition-colors"
                                    :class="availability ? 'bg-green-600' : 'bg-gray-200'"
                                ></div>
                                <div
                                    @click="toggleAvailability"
                                    class="absolute top-1 left-1 w-6 h-6 bg-white rounded-full transition-transform duration-300"
                                    :class="{ 'translate-x-6': availability }"
                                ></div>
                            </div>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
