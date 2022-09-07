<template>
<div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="mt-5 md:col-span-2 md:mt-0">
        <div class="shadow sm:overflow-hidden sm:rounded-md">
          <div class="space-y-6 bg-white px-4 py-5 sm:p-6">

            <div class="grid grid-cols-3 gap-6">
              <div class="col-span-3 sm:col-span-2">
                <label for="titre" class="block text-sm font-medium text-gray-700">Date debut</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                  <input type="datetime-local" @change="chooseDate()" v-model="form.date_debut" class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
              </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
              <div class="col-span-3 sm:col-span-2">
                <label for="titre" class="block text-sm font-medium text-gray-700">Date fin</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                  <input type="datetime-local" @change="chooseDate()" v-model="form.date_fin" class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
              </div>
            </div>

          </div>
        </div>
    </div>
</div>
</template>

<script setup>
    import { reactive, ref, defineEmits } from 'vue';

    const form = reactive({
        date_debut: '',
        date_fin: ''
    })

    const emit = defineEmits(['checkFilter'])

    const chooseDate = () => {
        emit('checkFilter', form)
    }
</script>
