<template>
  <v-container>
    <card :title="$t('users')">
      <template v-slot:card-title>
        <div class="ml-2"></div>
        <v-btn
          v-if="$can('create users')"
          color="primary"
          rounded
          @click="$router.push({name: 'users.create' })"
        >
          <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-spacer>
        </v-spacer>
        <v-row class="mr-5 mt-5">
          <v-btn
            class="mr-1"
            icon
            width="40"
            height="40"
            @click="fetchUsers"
          >
            <v-icon>mdi-refresh</v-icon>
          </v-btn>
          <v-text-field
            v-model="search"
            outlined dense
            :placeholder="$t('search_placeholder')"
            height="40"
            prepend-inner-icon="mdi-magnify"
          >
          </v-text-field>
        </v-row>
      </template>
      <template v-slot:card-text>
        <v-data-table
          ref="departmentTable"
          :headers="rolesTableHeader"
          :items="users"
          :loading="loading"
          :loading-text="tableTitles.loading_text"
          :no-data-text="tableTitles.no_data_text"
          :search="search"
        >
          <template v-slot:progress>
            <v-progress-linear color="red" indeterminate></v-progress-linear>
          </template>
          <template v-slot:item.sex="{item}">
            {{ $t(item.sex) }}
          </template>
          <template v-slot:item.departments="{item}">
            <span v-if="item.department">
              {{ item.department.title }}
            </span>
            <span v-else>
              {{ $t('not_indicated') }}
            </span>
          </template>
          <template v-slot:item.job_titles="{item}">
            <span v-if="item.job_title">
              {{ item.job_title.title }}
            </span>
            <span v-else>
              {{ $t('not_indicated') }}
            </span>
          </template>
          <template v-slot:item.status="{item}">
            <v-chip v-if="item.status === 'active'" color="success" outlined>
              {{ $t(item.status) }}
            </v-chip>
            <v-chip v-else color="red" outlined>
              {{ $t(item.status) }}
            </v-chip>
          </template>
          <template v-slot:item.actions="{item}">
            <v-icon v-if="$can('edit users')" color="success" @click="$router.push(`users/${item.id}/edit`)">
              mdi-pencil
            </v-icon>
            <v-icon v-if="$can('delete users')" color="error" @click="deleteRole(item.id)">mdi-delete</v-icon>
          </template>
        </v-data-table>
      </template>
    </card>
  </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import tableTitles from "../../mixins/data_table_titles";
import Card from "../../components/Card.vue";
import Create from "./create.vue";
import Edit from "./edit.vue";

export default {
  components: {Edit, Create, Card},
  computed: {
    ...mapGetters({
      users: 'users/users',
      loading: 'users/loading',
      errors: 'users/errors',
    }),

    rolesTableHeader() {
      let header = [
        {text: this.$t('name'), value: 'name', sortable: true},
        {text: this.$t('sex'), value: 'sex', sortable: true},
        {text: this.$t('departments'), value: 'departments', sortable: true},
        {text: this.$t('job_titles'), value: 'job_titles', sortable: true},
        {text: this.$t('status'), value: 'status', sortable: true},
      ];

      if (this.$can('edit users') || this.$can('delete users')) {
        header.push({text: this.$t('actions'), value: 'actions', align: 'end', sortable: false});
      }

      return header;
    },
  },
  data: () => ({
    search: '',
  }),
  metaInfo() {
    return {title: this.$t('users')}
  },
  methods: {
    ...mapActions({
      fetchUsers: 'users/fetchUsers',
      deleteRole: 'users/deleteUser',
    }),
  },
  mixins: [tableTitles],
  mounted() {
    this.fetchUsers();
  },
  name: "index.vue",
}
</script>
