<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    users: Array
})

const form = useForm({
    facility_name: '',
    description: '',
    user_id: '',
})

const submit = () => {
    form.post('/facilities', {
        // onFinish: () => {
        //     console.log()
        // }
    })
}

const crumbs = [
    {
        name: 'Dashboard',
        url: '/dashboard',
        active: false,
    },
    {
        name: 'Facilities',
        url: '/facilities',
        active: false,
    },
    {
        name: 'Add Facility',
        url: null,
        active: true,
    },
    
]
</script>

<template>
    <Head title="Add Facility" />
    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight mb-4">Add New Facility</h1>

                <Breadcrumb :crumbs="crumbs" class="mb-4" />

                <div class="p-4">
                    <form @submit.prevent="submit">
                        <div class="max-w-2xl mb-4">
                            <InputLabel value="Facility Name" />
    
                            <TextInput 
                            v-model="form.facility_name" 
                            class="w-full"
                            id="facname" />
    
                            <InputError :message="form.errors.facility_name" />
                        </div>
    
                        <div class="max-w-2xl mb-4">
                            <InputLabel value="Short Description" />

                            <textarea v-model="form.description" id="description" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
    
                            <InputError :message="form.errors.description" />
                        </div>
    
                        <div class="max-w-2xl mb-4">
                            <InputLabel value="Facility Head" />
    
                            <select 
                            v-model="form.user_id"
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            name=""
                            id="facility-head">
                                <option value="">Select a head</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                            </select>
    
                            <InputError :message="form.errors.user_id" />
                        </div>

                        <div class="flex justify-start max-w-4xl mb-4">
                            <button type="submit" class="px-4 py-1.5 text-sm bg-blue-600 rounded-md text-white">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>