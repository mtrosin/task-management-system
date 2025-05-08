import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { createPinia } from 'pinia'
import { useLoadingStore } from './Stores/loading'
import vuetify from './plugins/vuetify'
import AppLayout from './Layouts/AppLayout.vue'
import '@mdi/font/css/materialdesignicons.css'

const pinia = createPinia()

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || AppLayout
    return page
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({
      render: () => h(App, props)
    })

    app.use(plugin)
    app.use(pinia)
    app.use(vuetify)
    const loading = useLoadingStore()

    Inertia.on('start', () => loading.start())
    Inertia.on('finish', () => loading.finish())
    // optionally show on slow requests:
    Inertia.on('progress', () => loading.start())

    app.mount(el)
  },
})
