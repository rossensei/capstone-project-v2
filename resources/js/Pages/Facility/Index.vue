<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { PencilIcon, ChevronDownIcon, ArrowRightIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { PlusCircleIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import Alert from '@/Components/Alert.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { ref, watch, computed } from 'vue';

const props = defineProps({
    facilities: Object,
    filters: Object,
});

// const search = ref(props.filters.search);
// const perPage = ref(props.filters.perPage);

const params = ref({
    search: props.filters.search,
    perPage: props.filters.perPage,
})

const clearSearch = () => {
    search.value = '';
}

watch(params, debounce( function () {

    Object.keys(params.value).forEach(key => {
        if(params[key] == '' || params[key] == undefined) {
            delete params[key];
        }
    });

    console.log(params.value)

    router.get('/facilities', params.value, {
        preserveState: true,
        replace: true
    });

}, 300), {
    deep: true,
})

const page = usePage();

const response = computed(() => page.props.flash)
</script>

<template>
    <Head title="Facilities" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                
                <div class="flex items-center justify-between mb-4">
                    <h1 class="font-semibold text-3xl text-gray-700 leading-tight">List of Facilities</h1>
                    <Link href="/facilities/create" class="flex items-center justify-start px-3 py-2.5 rounded-full bg-[#4e73df] hover:bg-[#7e99eb] text-white font-semibold duration-150 ease-in">
                        <PlusCircleIcon class="w-5 h-5" />                                  
                        <span class="text-sm ml-1">Add Facility</span>
                    </Link>
                </div>

                <Alert class="mb-4" />

                <div class="relative overflow-x-auto bg-white shadow rounded-lg">
                    <div class="p-4">
                        <div class="flex items-end justify-between bg-white mb-4">

                            <h1 class="font-semibold text-xl text-gray-600 leading-tight">Facility Information</h1>

                            <div class="relative">
                                <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                                <input 
                                    v-model="params.search"
                                    type="search" 
                                    id="table-search-users" 
                                    class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    placeholder="Search for facilities"
                                >
                            </div>
                        </div>

                        <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Facility Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Head
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date Added
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Properties
                                </th>
                                <!-- <th scope="col" class="px-6 py-3 text-center">
                                    
                                </th> -->
                                <th scope="col" class="px-6 py-3 text-center">
                                    ...
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="group bg-white border-b hover:bg-gray-50" v-for="(facility, index) in facilities.data" :key="index">
                                <td class="px-6 py-4 text-gray-700">
                                    <div class="text-sm font-medium inline-flex items-center">{{ facility.facility_name }}
                                    <!-- <p class="">(Click to view properties)</p> -->
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-700 font-medium mb-4">
                                        {{ facility.user.name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex">
                                        02 November 2023
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                        <!-- {{ facility.facility_properties_count }} -->
                                        <Link :href="'/facilities/' + facility.id + '/view-properties'" 
                                    class="text-sm text-gray-600 underline">
                                        See Properties
                                        <!-- <ArrowRightIcon class="w-4 h-4 ml-1"/> -->
                                    </Link>
                                </td>
                                <!-- <td class="px-6 py-4 text-center">
                                    
                                </td> -->
                                <!-- <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <Link :href="'/facilities/edit/' + facility.id" class="inline-flex items-center text-xs font-semibold tracking-wide text-blue-600 uppercase rounded-sm px-2 py-1.5 hover:bg-blue-100 duration-300 ease-in-out">
                                            <PencilIcon class="w-4 h-4 mr-1" />
                                            Edit
                                        </Link>
                                        <Link :href="'/facilities/remove-facility/' + facility.id" as="button" method="DELETE" class="inline-flex items-center text-xs font-semibold text-red-600 uppercase rounded-sm px-2 py-1.5 hover:bg-red-100 duration-300 ease-in-out">
                                              <TrashIcon class="w-[14px] h-[14px] mr-1" />
                                              Delete
                                        </Link>
                                    </div>
                                </td> -->
                                <td class="px-6 py-4 text-center">
                                    <!-- <Link :href="'/facilities/' + facility.id + '/view-properties'" 
                                    class="inline-flex items-center text-xs font-semibold tracking-wide text-gray-600 uppercase rounded-md p-2 border border-gray-600 hover:bg-gray-100 duration-300 ease-in-out">
                                        See Properties
                                        <ArrowRightIcon class="w-4 h-4 ml-1"/>
                                    </Link> -->

                                    <div class="flex items-center justify-center space-x-2">
                                        <Link :href="'/facilities/edit/' + facility.id" 
                                            class="inline-flex items-center px-3 py-2 rounded-lg bg-[#4e73df] hover:bg-[#688dff] text-white text-sm font-medium transition-colors ease-in-out duration-300">
                                            <PencilIcon class="w-3 h-3 mr-1" />
                                            Edit
                                        </Link>
                                        <Link :href="'/facilities/edit/' + facility.id" 
                                            class="inline-flex items-center px-3 py-2 rounded-lg bg-[#EA3C53] hover:bg-[#ff5168] text-white text-sm font-medium transition-colors ease-in-out duration-300">
                                            <TrashIcon class="w-3 h-3 mr-1" />
                                            Delete
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex justify-between items-center mt-4">

                        <div>
                            <!-- <label class="text-sm font-normal text-gray-700 inline-flex items-center">
                                Entries per page &nbsp;
                                <select v-model="params.perPage" id="perPage" class="w-18 text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="5" selected>5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                </select>
                                &nbsp;&nbsp;
                                1-{{ params.perPage }} of {{ facilities.total }} entries
                            </label> -->
                        </div>

                        <Pagination 
                        class=""
                        :links="facilities.links"
                        :current_page="facilities.current_page"
                        :prev_page_url="facilities.prev_page_url"
                        :next_page_url="facilities.next_page_url"
                        :last_page="facilities.last_page"
                        />
                    </div>
                    </div>                    
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>