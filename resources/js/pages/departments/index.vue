<template>
  <v-container>
    <v-card>
      <v-card-title>
        {{ $t('departments') }}
        <div class="ml-2"></div>
        <v-btn
          color="primary"
          rounded
        >
          <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-spacer>
        </v-spacer>
        <v-text-field
          v-model="search"
          :placeholder="$t('search_placeholder')"
          dense
          prepend-inner-icon="mdi-magnify"
        >
        </v-text-field>
        <v-btn
          icon
        >
          <v-icon>mdi-refresh</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-data-table
          ref="departmentTable"
          :headers="departmentTableHeader"
          :items="items"
          :loading="loading"
        >
          <template slot="progress">
            <v-progress-linear color="red" indeterminate></v-progress-linear>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "index.vue",
  computed: {
    departmentTableHeader() {
      return [
        {text: this.$t('title'), value: 'department'},
        {text: '', value: 'actions'}
      ]
    },
    items: [],
  },
  data: () => ({
    search: '',
    loading: true,
  }),
}
</script>

<style scoped>

</style>
