// Utilities
import { defineStore } from 'pinia'
import {type User} from "@/api/models";
export const useAppStore = defineStore('jascarwashAppStore', {
  state: () => ({
    me: ref<User | null>(null),
  }),
})
