<template>
  <v-card>
    <v-card-title>
      {{ $t('departments') }}
      <v-spacer>
      </v-spacer>
      <v-text-field
        outlined
        prepend-inner-icon="mdi-magnify"
      >
      </v-text-field>
    </v-card-title>
    <v-card-text>
      <v-data-table>
      </v-data-table>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: "index.vue",
  computed: {
    tableHeaders: [
      // {title: this.$t('title'), value: 'title'},
      // {title: $t('actions'), value: 'actions'}
    ]
  }
}
</script>

<style scoped>

</style>
