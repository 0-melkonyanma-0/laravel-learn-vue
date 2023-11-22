<template>
  <div class="row">
    <div class="col-lg-10 m-auto">
<!--      <card :title="$t('home')">-->
<!--        <v-card>-->
<!--          test-->
<!--        </v-card>-->
<!--      </card>-->
      <v-card>
        {{ $t('you_are_logged_in') }}
      </v-card>
    </div>
  </div>
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
