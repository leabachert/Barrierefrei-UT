import { reactive } from 'vue'
import axios from 'axios'

export const auth = reactive({
    token: localStorage.getItem('token') || null,
    role:  localStorage.getItem('role') || null,
    user:  JSON.parse(localStorage.getItem('user') || 'null'),

    set(token, user) {
        this.token = token
        this.user  = user
        this.role  = user?.role || null

        localStorage.setItem('token', token)
        localStorage.setItem('role', this.role || '')
        localStorage.setItem('user', JSON.stringify(user || null))

        axios.defaults.headers.common.Authorization = `Bearer ${token}`
    },

    clear() {
        this.token = null
        this.role  = null
        this.user  = null
        localStorage.removeItem('token')
        localStorage.removeItem('role')
        localStorage.removeItem('user')
        delete axios.defaults.headers.common.Authorization
    },

    isLoggedIn() {
        return !!this.token
    },

    isEditorOrAdmin() {
        return this.role === 'editor' || this.role === 'admin'
    },
})

if (auth.token) {
    axios.defaults.headers.common.Authorization = `Bearer ${auth.token}`
}
