<template>
  <v-container
    fluid
  >
    <v-row
      justify="center"
    >
      <v-card
        class="pa-4"
        width="800"
      >
        <v-row justify="content-center">
          <v-img
            src="https://cdn.dribbble.com/users/1408464/screenshots/6377404/404_illustration_4x.png"
          ></v-img>

          <v-col align-self="center">
            <router-link :to="{ name: 'home' }">
              {{ $t('go_home') }}
            </router-link>
          </v-col>
        </v-row>
      </v-card>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'NotFound',
  metaInfo () {
    return { title: this.$t('Not Found Page') }
  }
}
</script>
