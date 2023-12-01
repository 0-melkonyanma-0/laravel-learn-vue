<template>
  <v-container>
    <card :title="$t('users')">
      <template v-slot:card-title>
        <div class="ml-2"></div>
        <v-btn
          color="primary"
          rounded
          @click="$router.push({name: 'users.create' })"
        >
          <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-spacer>
        </v-spacer>
        <v-text-field
          v-model="search"
          :placeholder="$t('search_placeholder')"
          height="40"
          prepend-inner-icon="mdi-magnify"
        >
        </v-text-field>
        <v-btn
          class="ml-1"
          icon
          @click="fetchUsers"
        >
          <v-icon>mdi-refresh</v-icon>
        </v-btn>
      </template>
      <template v-slot:card-text>
        <v-data-table
          ref="departmentTable"
          :headers="rolesTableHeader"
          :items="users"
          :loading="loading"
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
            <v-icon color="success" @click="$router.push(`users/${item.id}/edit`)">mdi-pencil</v-icon>
            <v-icon color="error" @click="deleteRole(item.id)">mdi-delete</v-icon>
          </template>
        </v-data-table>
      </template>
    </card>
  </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Card from "../../components/Card.vue";
import Create from "./create.vue";
import Edit from "./edit.vue";

export default {
  name: "index.vue",
  components: {Edit, Create, Card},
  computed: {
    ...mapGetters({
      users: 'users/users',
      loading: 'users/loading',
      errors: 'users/errors',
    }),

    rolesTableHeader() {
      return [
        {text: this.$t('name'), value: 'name', sortable: true},
        {text: this.$t('sex'), value: 'sex', sortable: true},
        {text: this.$t('departments'), value: 'departments', sortable: true},
        {text: this.$t('job_titles'), value: 'job_titles', sortable: true},
        {text: this.$t('Status'), value: 'status', sortable: true},
        {text: this.$t('actions'), value: 'actions', align: 'end', sortable: false}
      ]
    },
  },
  mounted() {
    this.fetchUsers();
  },
  watch: {
    dialogOn: {
      handler() {
        this.clearErrors()
      }
    }
  },
  data: () => ({
    search: '',
    editItem: {},
  }),
  metaInfo () {
    return { title: this.$t('users') }
  },
  methods: {
    ...mapActions({
      fetchUsers: 'users/fetchUsers',
      deleteRole: 'users/deleteUser',
    }),
  }
}
</script>
