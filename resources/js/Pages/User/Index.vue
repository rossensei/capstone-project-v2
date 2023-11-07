<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ArrowPathIcon, PencilIcon, ChevronDownIcon, TrashIcon,
    EyeIcon, UserPlusIcon, AdjustmentsHorizontalIcon } from '@heroicons/vue/24/solid';
import { FunnelIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/outline';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Pagination from '@/Components/Pagination.vue';
import Table from '@/Components/Table.vue';
import UsersTable from '@/Pages/User/Partials/UsersTable.vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';
import throttle from 'lodash/throttle';
import { watch, ref } from 'vue';
import Alert from '@/Components/Alert.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    users: Object,
    filters: Object,
    roles: Array
})

const search = ref(props.filters.search)
const role = ref(props.filters.role);
const status = ref(props.filters.status);

watch([search, role, status], throttle( function ([value1, value2, value3]) {

    let params = {
        search: value1,
        role: value2,
        status: value3
    }

    Object.keys(params).forEach(key => {
        if(params[key] == '') {
            delete params[key];
        }
    });

    router.get('/users', params,{
        preserveState: true,
        replace: true,
    });
}, 300));

const formatTimestampToDate = (timestamp) => {
    const date = new Date(timestamp);

    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    const day = date.getDate();
    const month = monthNames[date.getMonth()];
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;
}

const reset = () => {
    role.value = '';
    status.value = '';
}

const showFilter = ref(false);

function openFilterDropdown() {
    showFilter.value = !showFilter.value;
}

const selectedUser = ref({})
const confirmingUserDeletion = ref(false);

const deleteUser = (user) => {
    confirmingUserDeletion.value = true;

    selectedUser.value = user;
}
const closeModal = () => {
    confirmingUserDeletion.value = false;
};

const confirmDeleteUser = () => {
    router.delete('/users/delete/' + selectedUser.value.id, {
        onSuccess: () => closeModal()
    });
}
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">
                
                <div class="flex items-center justify-between mb-4">
                    <h1 class="font-semibold text-3xl text-gray-700 leading-tight">Manage Users</h1>
                    <Link href="/users/create" class="flex items-center px-3 py-2 rounded-full bg-[#4e73df] hover:bg-[#4e72dfc0] text-white">
                        <UserPlusIcon class="w-4 h-4" />
                        <span class="text-sm ml-1">Add User</span>
                    </Link>
                </div>

                <Alert class="mb-4" />

                <div class="overflow-x-auto bg-white shadow rounded-lg">
                    <div class="p-4">
                        <div class="flex items-end justify-between mb-4">
                            
                            <h1 class="text-xl font-semibold text-gray-600">User Information</h1>

                            <div class="flex space-x-2">

                                <button 
                                v-if="role || status"
                                @click="reset" 
                                class="inline-flex items-center text-xs font-medium text-gray-600 justify-center uppercase bg-white hover:bg-gray-100 border border-gray-300 p-2 rounded-md">
                                    <ArrowPathIcon class="w-4 h-4 mr-1" />
                                    Reset</button>
                                <div class="relative">
                                    <button @click="openFilterDropdown" class="inline-flex justify-center text-gray-600 items-center rounded-md bg-white hover:bg-gray-100 border border-gray-300 p-2 text-sm font-medium">
                                        <AdjustmentsHorizontalIcon class="w-4 h-4 mr-1"/>
                                        Filter
                                    </button>

                                    <!-- Full Screen Dropdown Overlay -->
                                    <div v-show="showFilter" class="fixed inset-0 z-40" @click="showFilter = false"></div>

                                    <transition
                                    enter-active-class="transition ease-out duration-200"
                                    enter-from-class="opacity-0 scale-95"
                                    enter-to-class="opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="opacity-100 scale-100"
                                    leave-to-class="opacity-0 scale-95"
                                    >
                                        <div v-show="showFilter" class="z-50 absolute w-52 top-10 right-0 bg-white border shadow-lg rounded-md py-3 px-3">
                                            <span class="text-sm font-medium text-gray-600">Status</span>
                                            <div class="mb-1">
                                                <input v-model="status" value="true" type="radio" name="status" id="status-1" class="rounded-lg">
                                                <label for="status-1" class="text-sm font-normal text-gray-600 mb-3">
                                                    Active
                                                </label>
                                            </div>
                                            <div class="mb-1">
                                                <input v-model="status" value="false" type="radio" name="status" id="status-2" class="rounded-lg">
                                                <label for="status-2" class="text-sm font-normal text-gray-600 mb-3">
                                                    Deactivated
                                                </label>
                                            </div>
                                            <span class="text-sm font-medium text-gray-600">Role</span>
                                            <div class="mb-1">
                                                <input v-model="role" value="admin" type="radio" name="role" id="role-1" class="rounded-lg">
                                                <label for="role-1" class="text-sm font-normal text-gray-600 mb-3">
                                                    Admin
                                                </label>
                                            </div>
                                            <div class="mb-1">
                                                <input v-model="role" value="faculty" type="radio" name="role" id="role-2" class="rounded-lg">
                                                <label for="role-2" class="text-sm font-normal text-gray-600 mb-3">
                                                    Faculty
                                                </label>
                                            </div>

                                            <div class="flex justify-center">
                                                <button @click="showFilter = false" class="inline-flex items-center text-xs font-medium text-gray-600 hover:text-blue-500 justify-center uppercase">
                                                    <!-- <ArrowPathIcon class="w-4 h-4 mr-1" /> -->
                                                    Close</button>
                                            </div>
                                        </div>
                                    </transition>
                                </div>

                                <label for="search" class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input 
                                        v-model="search"
                                        type="search" 
                                        id="table-search-users" 
                                        class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        placeholder="Search for users">
                                </label>
                                
                            </div>
                        </div>

                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Joined
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Role
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b hover:bg-gray-50" v-for="(user, index) in users.data" :key="index">
                                    <th scope="row" class="flex items-center px-6 py-3 text-gray-900 whitespace-nowrap">
                                        <img v-if="user.profile_photo" :src="user.profile_photo_url" alt="user_photo" class="w-10 h-10 rounded-full">
                                        <img v-else src="../../Components/images/user-icon.png" class="w-10 h-10 rounded-full" alt="">
                                        <div class="pl-3">
                                            <div class="text-base font-semibold">{{ user.name }}</div>
                                            <div class="font-normal text-gray-500">{{ user.email }} </div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-3 text-center">
                                        {{ formatTimestampToDate(user.created_at) }}
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="flex justify-center">
                                            <span v-if="user.active" class="text-green-600 font-extrabold">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                  </svg>                          
                                            </span>
                                            <span v-else class="text-red-600 font-extrabold">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                  </svg>                          
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <div v-if="user.roles.length">
                                            <span 
                                                v-for="role in user.roles" 
                                                :key="role.id" 
                                                v-html="role.name" 
                                                class="px-3 py-1.5 text-xs rounded-lg"
                                                :class="{
                                                    'bg-indigo-100 text-indigo-600 uppercase tracking-wide font-semibold' : role.name == 'admin',
                                                    'bg-green-100 text-green-600 uppercase tracking-wide font-semibold' : role.name == 'faculty',
                                                }"
                                            ></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="flex items-center justify-center space-x-2">
                                            <Link :href="'/users/edit/' + user.id"
                                                class="inline-flex items-center px-3 py-2 rounded-lg bg-[#4e73df] hover:bg-[#688dff] text-white text-sm font-medium transition-colors ease-in-out duration-300">
                                                <PencilIcon class="w-3 h-3 mr-1" />
                                                Edit
                                            </Link>
                                            <button @click="deleteUser(user)" type="button" class="inline-flex items-center px-3 py-2 rounded-lg bg-[#EA3C53] hover:bg-[#ff5168] text-white text-sm font-medium transition-colors ease-in-out duration-300">
                                                  <TrashIcon class="w-3 h-3 mr-1" />
                                                  Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- No user data response -->
                        <div v-show="users.data.length < 1" class="flex flex-col w-full py-10">
                            <h1 class="text-center text-md font-medium text-gray-400">No user found</h1>
                        </div>        

                        <!-- Paginator -->
                        <div class="flex items-center justify-end mt-4">
                            <Pagination 
                            v-show="users" 
                            :links="users.links"
                            :current_page="users.current_page"
                            :prev_page_url="users.prev_page_url"
                            :next_page_url="users.next_page_url"
                            :last_page="users.last_page"
                            />
                        </div>

                        <!-- Delete Modal -->
                        <Modal :show="confirmingUserDeletion" @close="closeModal">
                            <div class="p-6">

                                <div class="flex space-x-2">
                                    <div class="shrink-0">
                                        <ExclamationTriangleIcon class="w-5 h-5 mt-1" />
                                    </div>
                                    <div class="flex-1">
                                        <h2 class="text-lg font-medium text-gray-900">
                                            Delete Confirmation
                                        </h2>
        
                                        <p class="mt-1 text-sm text-gray-600">
                                            Are you sure you want to remove {{ selectedUser.name }}? This action cannot be undone.
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <button type="button" @click="closeModal"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-sm text-gray-700 
                                    shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                    > Cancel </button>
                
                                    <button
                                        type="button"
                                        class="ml-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        @click="confirmDeleteUser()"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </Modal>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>