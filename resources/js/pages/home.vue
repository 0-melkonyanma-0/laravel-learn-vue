<template>
  <v-container>
    <v-card class="pa-4">
      {{ $t('you_are_logged_in') }}
    </v-card>
  </v-container>
</template>

<script>
// import axios from 'axios'
export default {
  middleware: 'auth',

  // async asyncData () {
  //   const { data: projects } = await axios.get('/api/projects')

  //   return {
  //     projects
  //   }
  // },

  metaInfo () {
    return { title: this.$t('home') }
  }
}
</script>
