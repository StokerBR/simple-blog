// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: {
    enabled: true,

    timeline: {
      enabled: true,
    },
  },

  optimization: {
    keyedComposables: [
      {
        name: 'useApiFetch',
        argumentLength: 2,
      },
    ],
  },
  ssr: false,
  modules: ['@pinia/nuxt', 'nuxt-quasar-ui', '@formkit/nuxt', 'dayjs-nuxt'],
  quasar: {
    plugins: ['Loading', 'Notify'],
  },
  formkit: {
    autoImport: true,
  },
  css: ['@/assets/scss/app.scss'],
  vite: {
    css: {
      preprocessorOptions: {
        scss: {
          additionalData: '@import "@/assets/scss/variables.scss";',
        },
      },
    },
  },
  runtimeConfig: {
    public: {
      apiUrl:
        process.env.NODE_ENV !== 'production'
          ? 'http://localhost:8000/api'
          : process.env.API_URL,
      clientId: process.env.CLIENT_ID || '2',
      clientSecret:
        process.env.CLIENT_SECRET || 'atfqA5GPpI8HofYcBpAf0LGC9LDKkL1MQ0uLwWtn',
    },
  },
  app: {
    head: {
      title: 'Simple Blog',
    },
  },
});
