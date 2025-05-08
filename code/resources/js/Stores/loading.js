import { defineStore } from 'pinia'

export const useLoadingStore = defineStore('loading', {
  state: () => ({
    active: false,
  }),
  actions: {
    start() {
      this.active = true
    },
    finish() {
      this.active = false
    },
  },
})