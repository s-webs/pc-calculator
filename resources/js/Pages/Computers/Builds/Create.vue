<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {reactive, computed, watch} from 'vue';
import {Link, router} from '@inertiajs/vue3';

const props = defineProps({
    categories: Array
});

const selectedComponent = reactive({
    id: null
});

const form = reactive({
    image: null,
    name: null,
    components: [],
    prime_cost: 0,
    sale_price: null
});

// Добавляем компонент в массив
function addComponent() {
    const component = findComponentById(selectedComponent.id);
    if (component) {
        form.components.push(component);
        selectedComponent.id = null; // Очищаем select
    }
}

// Удаляем компонент из сборки
function removeComponent(index) {
    form.components.splice(index, 1);
}

// Ищем компонент по ID
function findComponentById(id) {
    for (const category of props.categories) {
        const component = category.components.find(comp => comp.id === Number(id));
        if (component) {
            return component;
        }
    }
    return null;
}

// Следим за изменением массива компонентов и обновляем себестоимость
watch(() => form.components, (components) => {
    form.prime_cost = components.reduce((total, component) => total + component.prime_cost, 0);
}, { deep: true });

function submit() {
    console.log(form)
    router.post(route('pc-builds.store'), form);

}
</script>

<template>
    <AppLayout title="Создать сборку ПК">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Добавить сборку ПК
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div>
                        <Link :href="route('pc-builds.index')"
                              class="block px-[30px] py-[10px] bg-gray-300 text-white font-semibold">Назад
                        </Link>
                    </div>

                    <form @submit.prevent="submit" class="mt-[30px]">

                        <div class="mb-4">
                            <label for="name">Название сборки</label>
                            <input id="name" v-model="form.name" type="text" placeholder="Название сборки"
                                   class="w-full p-2 border rounded" required>
                        </div>

                        <div class="mb-4">
                            <label for="image">Ссылка на изображение</label>
                            <input id="image" v-model="form.image" type="text" placeholder="Введите ссылку"
                                   class="w-full p-2 border rounded">
                        </div>

                        <div class="mb-4">
                            <label for="components">Выберите компоненты</label>
                            <div class="flex items-center space-x-4">
                                <select id="components" v-model="selectedComponent.id"
                                        class="p-2 border rounded w-full mr-2">
                                    <option disabled value="">Выберите компонент</option>
                                    <optgroup v-for="category in categories" :key="category.id" :label="category.name">
                                        <option v-for="component in category.components" :key="component.id"
                                                :value="component.id">
                                            {{ component.name }} - Себестоимость: {{ component.prime_cost }}₸
                                        </option>
                                    </optgroup>
                                </select>
                                <button @click.prevent="addComponent" class="px-4 py-2 bg-blue-500 text-white rounded">
                                    Добавить
                                </button>
                            </div>
                        </div>

                        <div v-if="form.components.length" class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Выбранные компоненты:</h3>
                            <ul>
                                <li v-for="(component, index) in form.components" :key="component.id"
                                    class="flex justify-between items-center mb-2">
                                    <span>{{ component.name }} - {{ component.prime_cost }}₸</span>
                                    <button @click="removeComponent(index)" class="text-red-500">Удалить</button>
                                </li>
                            </ul>
                            <p v-if="form.components.length" class="text-xl font-semibold mb-6">
                                Себестоимость: {{ form.prime_cost }}₸
                            </p>
                        </div>

                        <div class="mb-4">
                            <label for="sale_price">Цена продажи</label>
                            <input id="sale_price" v-model="form.sale_price" type="number" placeholder="Цена продажи"
                                   class="w-full p-2 border rounded">
                        </div>

                        <button type="submit" class="w-full px-6 py-2 bg-green-500 text-white rounded">
                            Сохранить сборку
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
