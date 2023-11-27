<template>
  <v-container
      fluid
  >
    <v-row
      justify="center"
    >
      <v-card
          width="800"
      >
        <router-link :to="{ name: 'home' }">
          {{ $t('go_home') }}
        </router-link>
      </v-card>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>
