<template>

</template>

<script>
    import store from '../store'
    export default {
        mounted () {
            localStorage.removeItem('token')
            localStorage.removeItem('roles')
            store.commit('logoutUser')
            this.$router.push({ name: 'LoginAdmin' })
        }
    }
</script>