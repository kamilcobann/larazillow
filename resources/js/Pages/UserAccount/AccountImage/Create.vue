<template>
    <Box>
        <template #header>
            Upload New Profile Picture
        </template>
        <form @submit.prevent="upload">
            <section class="flex items-center gap-2 my-4">
                
        <input class="border rounded-md file:px-4 file:py-2 border-gray-200 dark:border:gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 file:dark:bg-gray-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-2"
         type="file" @input="addFile"/>
        <button type="submit" class="button-outline disabled:opacity-25 disabled:cursor-not-allowed" :disabled="!canUpload">Upload</button>
        <button type="reset" class="button-outline">Reset</button>
            </section>
        </form>
        <div v-if="imageErrors.length" class="input-error">
            <div v-for="(error,index) in imageErrors" :key="index">
                {{ error}}
            </div>
        </div>
    </Box>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue'
import  {useForm, usePage} from '@inertiajs/vue3'
import {computed } from 'vue'
import NProgress from 'nprogress'
import { router } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3' 

const props = defineProps({listing: Object})

router.on('progress',(event)=>{
    if(event.detail.progress.percentage){
        NProgress.set((event.detail.progress.percentage))
    }
})
const user = usePage(
    () => usePage().props.user
)
const form = useForm({
    image: []
})

const imageErrors = computed(() => Object.values(form.errors))

const canUpload = computed(() => form.image.length)

const upload = () => {
    form.post(
        route('avatar.store', {avatar: user.id}),
        {
            onSuccess: () => reset,
        },
    )
}

const addFile = (event) => {

    for(const image of event.target.files)
    {
        form.image.push(image)
    }

}

const reset = () => form.reset('image')
</script>