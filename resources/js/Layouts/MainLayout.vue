<template>
    &nbsp;
    <header class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 w-full">
        <div class="container mx-auto">
            <nav class="pb-4 flex items-center justify-between">
                <div class="text-lg">
                    <Link :href="route('listing.index')">Listings</Link>
                </div>
                <div class="text-xl text-indigo-600 dark:text-indigo-300 font-bold text-center">
                    <Link :href="route('listing.index')">LaraZillow</Link>
                </div>
                <div v-if="user" class="flex items-center gap-4">
                    <Link :href="route('realtor.listing.index')" class="text-sm text-gray-500">{{ user.name }}</Link>
                    <Link :href="route('realtor.listing.create')" class="button-primary">+ New Listing</Link>
                    <Link :href="route('logout')" method="delete" as="button" class="text-sm text-gray-500 hover:text-gray-300" >Logout</Link>
                </div>
                <div v-else class="flex items-center gap-3">
                    <Link :href="route('user-account.create')">Register</Link>
                    <Link :href="route('login')">Log In</Link>
                </div>
            </nav>
        </div>
    </header>

    <main class="containter mx-auto p-4 w-full">
        <div v-if="flashSuccess" class="mb-4 border rounded-md shadow-sm border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900 p-2">
            {{ flashSuccess }}
        </div>

        <slot>
            Default
        </slot>
    </main>
</template>

<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import { computed } from "vue";

const flashSuccess = computed(
    () => usePage().props.flash.success
)

const user = computed(
    () => usePage().props.user
)
</script>