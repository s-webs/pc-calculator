<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive, watch, onMounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
    build: Object
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

// Заполняем форму при редактировании
onMounted(() => {
    if (props.build) {
        form.image = props.build.image;
        form.name = props.build.name;
        form.components = Array.isArray(props.build.components)
            ? props.build.components
            : JSON.parse(props.build.components);
        form.sale_price = props.build.sale_price || 0; // Убедимся, что значение не null
    }
});

// Добавляем компонент
function addComponent() {
    const component = findComponentById(selectedComponent.id);
    if (component) {
        form.components.push(component);
        form.sale_price = Number(form.sale_price) + (component.sale_price || 0); // Приводим к числу
        selectedComponent.id = null;
    }
}

// Удаляем компонент
function removeComponent(index) {
    const removedComponent = form.components[index];
    form.sale_price = Number(form.sale_price) - (removedComponent.sale_price || 0); // Приводим к числу
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

// Считаем себестоимость
watch(() => form.components, (components) => {
    form.prime_cost = components.reduce((total, component) => total + component.prime_cost, 0);
}, { deep: true });

// Отправляем форму
function submit() {
    if (props.build) {
        router.put(route('pc-builds.update', props.build.id), form);
    } else {
        router.post(route('pc-builds.store'), form);
    }
}
</script>


<template>
    <AppLayout :title="build ? 'Редактировать сборку' : 'Создать сборку'">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ build ? 'Редактировать сборку' : 'Добавить сборку' }}
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
                                <li v-for="(component, index) in form.components" :key="index" class="flex justify-between mb-2">
                                    {{ component.name }} - {{ component.prime_cost }}₸
                                    <button @click.prevent="removeComponent(index)" class="text-red-500">Удалить</button>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <label for="sale_price">Цена продажи</label>
                            <input id="sale_price" v-model="form.sale_price" type="number" placeholder="Цена продажи"
                                   class="w-full p-2 border rounded" required>
                        </div>

                        <div class="mb-6">
                            <p class="text-lg font-semibold">Себестоимость: {{ form.prime_cost }}₸</p>
                        </div>

                        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded">
                            {{ build ? 'Обновить' : 'Создать' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
