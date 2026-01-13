import { ref } from 'vue'
import { Configuration, V1Api,AuthApi } from '@/api'
import router from '@/router'

const error = ref<string | null>(null)
const token = ref<string | null>(null)
// const apiPath = import.meta.env.VITE_API_URL || 'http://'+location.host.split(':')[0]+':8000'
const apiPath = '/api'
// const customFetch: typeof fetch = async (input, init) => {
//   const response = await fetch(input, init)
//   if (response.status === 401) {
//     if (window.location.pathname !== '/login') {
//       router.push('/login')
//     }
//   }
//   return response
// }
const config = new Configuration({
  basePath: apiPath,
  credentials: 'include',
  // fetchApi: customFetch,
})
export function useV1Api() {
  return new V1Api(config)
}
export function useAuthApi() {
  return new AuthApi(config)
}
