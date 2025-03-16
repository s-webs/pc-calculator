<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, usePage } from "@inertiajs/vue3";
import { reactive, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    categories: Array,
    component: Object
});

// Создаем реактивные данные формы
const form = reactive({
    pc_category_id: props.component.pc_category_id,
    name: props.component.name,
    image: props.component.image,
    prime_cost: props.component.prime_cost,
    sale_price: props.component.sale_price,
    quantity: props.component.quantity,
    available: props.component.available
});

// Отдельное состояние для переключателя "В наличии"
const available = ref(props.component.available);

// Следим за переключателем и обновляем форму
watch(available, (newValue) => {
    form.available = newValue;
});

const handleInput = (field, value) => {
    form[field] = value === '' ? null : Number(value);
};

function submit() {
    router.put(route('pc-components.update', props.component.id), form);
}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Редактировать компонент "{{ component.name }}"
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div>
                        <Link :href="route('pc-components.index')" class="block px-[30px] py-[10px] bg-gray-300 text-white font-semibold">Назад</Link>
                    </div>
                    <form @submit.prevent="submit" class="mt-[30px]">
                        <div class="mb-4">
                            <label for="category_id">Выберите категорию</label>
                            <select id="category_id" v-model="form.pc_category_id" class="w-full" required>
                                <option v-for="category in categories" :value="category.id" :key="category.id">{{ category.name }}</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="name">Название компонента</label>
                            <input id="name" v-model="form.name" type="text" class="w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="image">Ссылка на изображение</label>
                            <input id="image" v-model="form.image" type="text" class="w-full">
                        </div>
                        <div class="mb-4">
                            <label for="prime_cost">Себестоимость</label>
                            <input id="prime_cost" v-model="form.prime_cost" type="number" class="w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="sale_price">Цена продажи</label>
                            <input id="sale_price" :value="form.sale_price" @input="handleInput('sale_price', $event.target.value)" type="number" class="w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="quantity">Количество (в наличии)</label>
                            <input id="quantity" :value="form.quantity" @input="handleInput('quantity', $event.target.value)" type="number" class="w-full">
                        </div>
                        <div class="mb-4 flex items-center">
                            <p class="mr-2">Статус: {{ available ? 'В наличии' : 'Нет в наличии' }}</p>
                            <div class="relative w-14 h-8 cursor-pointer" @click="available = !available">
                                <div class="block w-full h-full rounded-full transition-colors" :class="available ? 'bg-green-500' : 'bg-gray-300'"></div>
                                <div class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full transition-transform" :class="available ? 'translate-x-6' : ''"></div>
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Обновить</button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
