<template>
  <v-container>
    <v-card-subtitle>test</v-card-subtitle>
    <v-card>
      <v-form @submit.prevent="false">
        <v-text-field
          v-model="departmentBody.title"
          :label="$t('title')"
          name="title"
          outlined
        >
        </v-text-field>
      </v-form>
      <v-btn
        type="success"
        @click="createDepartment(JSON.parse(JSON.stringify(departmentBody)))"
      >
        {{ $t('create') }}
      </v-btn>
    </v-card>

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
          prepend-inner-icon="mdi-magnify"
        >
        </v-text-field>
        <v-btn
          class="ml-1"
          icon
          @click="fetchDepartments"
        >
          <v-icon>mdi-refresh</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-data-table
          ref="departmentTable"
          :headers="departmentTableHeader"
          :items="departments"
          :loading="loading"
          :search="search"
        >
          <template v-slot:progress>
            <v-progress-linear color="red" indeterminate></v-progress-linear>
          </template>
          <template v-slot:item.actions="{item}">
            <v-icon color="success" @click="">mdi-pencil</v-icon>
            <v-icon color="error" @click="deleteDepartment(item.id)">mdi-delete</v-icon>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  name: "index.vue",
  middleware: 'auth',
  computed: {
    ...mapGetters({
      departments: 'departments/departments',
      loading: 'departments/loading',
    }),

    departmentTableHeader() {
      return [
        {text: this.$t('title'), value: 'title', sortable: true},
        {text: this.$t('actions'), value: 'actions', align: 'end', sortable: false}
      ]
    },
  },
  mounted() {
    this.fetchDepartments();
  },
  data: () => ({
    search: '',
    departmentBody: {
      title: ''
    },
  }),
  methods: {
    ...mapActions({
      fetchDepartments: 'departments/fetchDepartments',
      deleteDepartment: 'departments/deleteDepartment',
      createDepartment: 'departments/createDepartment',
    }),
  }
}
</script>

<style scoped>

</style>
