// src/boot/axios.js
import { boot } from 'quasar/wrappers'
import axios from 'axios'

// Crea una instancia de axios con la URL base de tu API Laravel
const api = axios.create({
  baseURL: 'http://localhost:8000/api/v1', // ← Cambia esto por la IP de tu backend si es remoto
  timeout: 10000,
})

// Exporta la instancia para usarla en componentes
export default boot(({ app }) => {
  // Hace que $axios esté disponible en todos los componentes Vue
  app.config.globalProperties.$axios = axios
  app.provide('axios', axios)

  // También puedes exportar `api` para importarlo directamente si lo prefieres
  app.config.globalProperties.$api = api
  app.provide('api', api)
})

// Exportamos también la instancia para importarla directamente en otros archivos
export { api }