<template>
    <h1 class="text-3xl mb-4">Your Listings</h1>
    <RealtorFilters :filters="filters"/>
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-2">
        <Box v-for="listing in listings.data" :key="listing.id" :class="{'border-dashed': listing.deleted_at}">
            <div class="flex flex-col md:flex-row gap-2 md:items-center justify-between">
                <div :class="{'opacity-25':listing.deleted_at}">
                    <div v-if="listings.sold_at != null" class="text-xs font-bold uppercase border border-dashed p-1 border-green-300 text-green-500 dark:border-green-600 dark:text-green-600 inline-block rounded-md mb-2">
                        Sold
                    </div>
                    <div class="xl:flex items-center gap-2">
                        <Price :price="listing.price" class="text-2xl font-medium"/>
                    </div>
                    <ListingSpace :listing="listing"/>
                    <ListingAddress :listing="listing" class="text-gray-500"/>
                </div>
                <section>
                    <div class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
                    <a :href="route('listing.show', {listing:listing.id})" target="_blank" class="button-outline  text-xs font-medium">Preview</a>
                    <Link :href="route('realtor.listing.edit', {listing:listing.id})" class="button-outline  text-xs font-medium">Edit</Link>
                    <Link v-if="!listing.deleted_at" :href="route('realtor.listing.destroy', {listing:listing.id})" method="delete" as="button" class="button-outline  text-xs font-medium">Delete</Link>
                    <Link v-else :href="route('realtor.listing.restore',{listing:listing.id})" as="button" method="put" class="button-outline  text-xs font-medium">Restore</Link>

                </div>

                <div class="mt-2">
                    <Link class="block w-full button-outline text-sm font-medium text-center" :href="route('realtor.listing.image.create',{listing: listing.id})">Images ({{ listing.images_count }})</Link>
                </div>
                <div class="mt-2">
                    <Link class="block w-full button-outline text-sm font-medium text-center" :href="route('realtor.listing.show',{listing: listing.id})">Offers ({{ listing.offers_count }})</Link>
                </div>
                </section>
            </div>
        </Box>
    </section>
    <section v-if="listings.data.length" class="w-full flex justify-center my-4">
        <Pagination :links="listings.links"/>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Box from '@/Components/UI/Box.vue'
import Price from '@/Components/Price.vue'
import ListingSpace from '@/Components/ListingSpace.vue'
import ListingAddress from '@/Components/ListingAddress.vue'
import RealtorFilters from '@/Pages/Realtor/Index/Components/RealtorFilters.vue'
import Pagination from '@/Components/UI/Pagination.vue';

defineProps({
    listings:Object,
    filters: Object
})
</script>
