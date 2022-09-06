<template>
    <Layout>
        <div>
        <Head title="Evenements" />
        <h1 class="mb-8 text-3xl font-bold">Evenements</h1>
    
        <div class="flex items-center justify-between mb-6">

            <div class="container mx-auto">
                <div class="flex justify-center">
                    <button @click="openModal()" class="px-6 py-2 text-white bg-blue-600 rounded shadow" type="button">
                    Ajouter un evenement
                    </button>
            
                    <div
                    v-if="isOpen"
                    class="
                        absolute
                        inset-0
                        flex
                        items-center
                        justify-center
                        bg-gray-700 bg-opacity-50
                    "
                    >
                    <div class="max-w-2xl p-6 mx-4 bg-white rounded-md shadow-xl">
                        <div class="flex items-center justify-between">
                        <h3 class="text-2xl">{{ getStatusTitle() }}</h3>
                        <svg
                            @click="isOpen = false"
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-8 h-8 text-red-900 cursor-pointer"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        </div>
                        <div class="mt-4">
                            <Formulaire :formData="formData" :status="formStatus" @close-modal="closeModal()" />
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6">Titre</th>
                <th class="pb-4 pt-6 px-6">Date et Heure</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="evenement in evenements" :key="evenement.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" @click="editEvenement(evenement)">
                        {{ evenement.titre }}
                    <icon v-if="evenement.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
                    </Link>
                </td>
                <td class="border-t">
                    <Link class="flex items-center px-6 py-4" @click="editEvenement(evenement)" tabindex="-1">
                        {{ evenement.date_heure }}
                    </Link>
                </td>
                <td class="w-px border-t">
                    <div class="flex">
                        <div class="flex items-center px-4" @click="selectedEvenement(evenement)">
                            modifier
                        </div>
                        <div class="flex items-center px-4" @click="deleteEvenement(evenement)">
                            supprimer
                        </div>    
                    </div>
                    
                </td>
                </tr>
                <tr v-if="evenements.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">Aucun evenement trouvé</td>
                </tr>
            </tbody>
            </table>
        </div>
        <pagination class="mt-6" :links="evenements.links" />
        </div>    
    </Layout>
    
  </template>
  
  <script setup>
    import { ref } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import route from '../../../../vendor/tightenco/ziggy/src/js'
    import Layout from '@/Layouts/Layout.vue'
    import Formulaire from '@/Components/Evenement/Formulaire.vue'
    import { Inertia } from '@inertiajs/inertia'
  
    const props = defineProps({
      evenements: Object,
    })

    const formData = ref({
        id: '',
        titre: '',
        date_heure: ''
    })

    let isOpen = ref(false)

    const emit = defineEmits(['selectedEvenement'])
    const modal_status = ref("add")
    const formStatus = ref("add")

    const selectedEvenement = (evenement) => {
        modal_status.value = "edit"
        formStatus.value = "edit"
        isOpen.value = true
        
        formData.value.id = evenement.id
        formData.value.titre = evenement.titre
        formData.value.date_heure = evenement.date_heure
    }

    const openModal = () => {
        modal_status.value = "add"
        formStatus.value = "add"
        isOpen.value = true

        formData.value.id = ''
        formData.value.titre = ''
        formData.value.date_heure = ''
    }

    const closeModal = () => {
        console.log('Event emitted')
        modal_status.value = "add"
        isOpen.value = false

        formData.value.id = ''
        formData.value.titre = ''
        formData.value.date_heure = ''
    }

    const deleteEvenement = (evenement) => {
        let confirm = window.confirm("Voulez vous vraiment supprimer?")
        if(confirm){
            Inertia.delete(route('evenement.delete', {id: evenement.id}))
        }
    }
    const form = {
        search: '',
        trashed: '',
    }

    const getStatusTitle = () => {
        return modal_status.value == 'add' ? "Ajouter un evenement" : "Modifier l'evenement" 
    }
    
    const reset = () => {
        form = { search: '', trashed: ''}
    }
</script>
