<script setup>
import {onMounted, ref, watch} from 'vue';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Dashboard from "@/Pages/Dashboard.vue";
import {PhArticle, PhCpu, PhDesktopTower, PhHorse, PhHouse} from "@phosphor-icons/vue";

defineProps({
    title: String,
});

const routes = [
    {
        name: 'Dashboard',
        route: 'dashboard',
        icon: PhHouse
    },
    {
        name: 'Категории ПК',
        route: 'pc-categories.index',
        icon: PhArticle
    },
    {
        name: 'Компоненты ПК',
        route: 'pc-components.index',
        icon: PhCpu
    },
    {
        name: 'Сборки ПК',
        route: 'pc-builds.index',
        icon: PhDesktopTower
    },
]

const showingNavigationDropdown = ref(false);

const showNotification = ref(false);
const notificationMessage = ref(null);

onMounted(() => {
    if (usePage().props.flash.message) {
        showNotification.value = true;
        notificationMessage.value = usePage().props.flash.message;
        setTimeout(() => {
            showNotification.value = false;
        }, 3000);
    }
});

watch(() => usePage().props.flash.message, (newMessage) => {
    if (newMessage) {
        showNotification.value = true;
        notificationMessage.value = newMessage;
        setTimeout(() => {
            showNotification.value = false;
        }, 3000);
    }
});

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="pb-[50px]">
        <Head :title="title"/>

        <Banner/>

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto"/>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink v-for="item in routes" :href="route(item.route)"
                                         :active="route().current(item.route)">
                                    {{ item.name }}
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos"
                                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="size-8 rounded-full object-cover"
                                                 :src="$page.props.auth.user.profile_photo_url"
                                                 :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Настройки аккаунта
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Профиль
                                        </DropdownLink>

                                        <div class="border-t border-gray-200"/>

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Выйти
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="size-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
                     class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink v-for="item in routes" :href="route(item.route)"
                                           :active="route().current(item.route)">
                            {{ item.name }}
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="size-10 rounded-full object-cover"
                                     :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Профиль
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Выйти
                                </ResponsiveNavLink>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div v-if="showNotification">
                    <div
                        class="fixed top-[10px] md:top-[50px] right-[10px] md:right-[50px] bg-white p-4 rounded-md flex items-center justify-between shadow-lg border">
                        <div class="mr-[20px] font-semibold">{{ notificationMessage }}</div>
                        <div @click="showNotification = false"
                             class="w-[25px] h-[25px] text-gray-300 rounded-full flex items-center justify-center cursor-pointer border">
                            X
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>

            <div class="fixed bottom-0 w-full">
                <div class="bg-blue-400 w-full flex items-center justify-between py-[10px] rounded-tl-[15px] rounded-tr-[15px]">
                    <Link :href="route(item.route)" v-for="item in routes" :key="route.id" class="text-white font-semibold text-center mx-[10px]">
                        <component :is="item.icon" :size="32" class="mx-auto py-0" />
                        <span class="text-[10px]">{{ item.name }}</span>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
