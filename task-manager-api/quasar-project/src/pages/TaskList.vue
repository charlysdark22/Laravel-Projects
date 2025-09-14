<template>
  <q-page class="q-pa-md">
    <h3 class="text-h5 q-mb-lg">Gestión de Tareas</h3>
    <div class="q-mb-lg">
      <q-input v-model="newTaskTitle" label="Nuevo título de tarea" outlined dense class="q-mb-sm" @keyup.enter="createTask" />
      <q-select v-model="selectedKeywordIds" :options="keywords" label="Seleccionar palabras clave" multiple use-chips option-value="id" option-label="name" dense outlined class="q-mb-sm" style="width: 100%" />
      <q-btn color="primary" label="Crear Tarea" @click="createTask" />
    </div>
    <q-list separator>
      <q-item v-for="task in tasks" :key="task.id" class="q-py-sm">
        <q-item-section avatar>
          <q-icon :name="task.is_done ? 'check_circle' : 'radio_button_unchecked'" :color="task.is_done ? 'green' : 'grey'" @click="toggleTask(task.id)" class="cursor-pointer" />
        </q-item-section>
        <q-item-section>
          <q-item-label class="text-weight-bold">{{ task.title }}</q-item-label>
          <q-item-label caption>
            <span v-if="task.keywords.length > 0">
              Keywords: 
              <span v-for="kw in task.keywords" :key="kw.id" class="q-ml-xs">
                <q-chip color="primary" text-color="white" size="sm">{{ kw.name }}</q-chip>
              </span>
            </span>
            <span v-else class="text-grey">Sin palabras clave</span>
          </q-item-label>
        </q-item-section>
        <q-item-section side>
          <q-btn flat icon="edit" size="sm" @click="openEditModal(task)" />
        </q-item-section>
      </q-item>
    </q-list>
    <q-alert v-if="error" color="red" text-color="white" class="q-mt-lg">{{ error }}</q-alert>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useQuasar } from 'quasar'
import { api } from 'src/boot/axios'

const $q = useQuasar()
const tasks = ref([])
const keywords = ref([])
const newTaskTitle = ref('')
const selectedKeywordIds = ref([])
const error = ref('')

onMounted(() => {
  loadTasks()
  loadKeywords()
})

async function loadTasks() {
  try {
    const res = await api.get('/tasks')
    tasks.value = res.data
  } catch (err) {
    error.value = 'Error cargando tareas: ' + (err.response?.data?.message || err.message)
    console.error(err)
  }
}

async function loadKeywords() {
  try {
    const res = await api.get('/keywords')
    keywords.value = res.data
  } catch (err) {
    error.value = 'Error cargando palabras clave: ' + (err.response?.data?.message || err.message)
    console.error(err)
  }
}

async function createTask() {
  if (!newTaskTitle.value.trim()) {
    $q.notify({ message: 'El título es obligatorio', color: 'negative' })
    return
  }
  try {
    const payload = { title: newTaskTitle.value, keyword_ids: selectedKeywordIds.value }
    const res = await api.post('/tasks', payload)
    tasks.value.unshift(res.data)
    newTaskTitle.value = ''
    selectedKeywordIds.value = []
    $q.notify({ message: 'Tarea creada', color: 'positive' })
  } catch (err) {
    error.value = 'Error creando tarea: ' + (err.response?.data?.message || err.message)
    $q.notify({ message: 'Error al crear tarea', color: 'negative' })
  }
}

async function toggleTask(id) {
  try {
    const res = await api.post(`/tasks/${id}/toggle`)
    const index = tasks.value.findIndex(t => t.id === id)
    if (index !== -1) tasks.value[index] = res.data
  } catch (err) {
    error.value = 'Error cambiando estado: ' + (err.response?.data?.message || err.message)
    $q.notify({ message: 'Error al cambiar estado', color: 'negative' })
  }
}

function openEditModal(task) { console.log('Editar tarea:', task) }
</script>

<style scoped>
.cursor-pointer { cursor: pointer; }
</style>
