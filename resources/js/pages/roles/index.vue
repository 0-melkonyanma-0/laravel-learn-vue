<template>
  <v-container>
    <card :title="$t('roles')">
      <template v-slot:card-title>
        <div class="ml-2"></div>
        <v-btn
          v-if="$can('create roles')"
          color="primary"
          rounded
          @click="$router.push({name: 'users.roles.create' })"
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
          @click="fetchRolesAndPermissions"
        >
          <v-icon>mdi-refresh</v-icon>
        </v-btn>
      </template>
      <template v-slot:card-text>
        <v-data-table
          ref="departmentTable"
          :headers="rolesTableHeader"
          :items="roles"
          :loading="loading"
          :loading-text="tableTitles.loading_text"
          :no-data-text="tableTitles.no_data_text"
          :search="search"
        >
          <template v-slot:progress>
            <v-progress-linear color="red" indeterminate></v-progress-linear>
          </template>
          <template v-slot:item.actions="{item}">
            <v-icon v-if="$can('edit roles')" color="success" @click="$router.push(`roles/${item.id}/edit`)">
              mdi-pencil
            </v-icon>
            <v-icon v-if="$can('delete roles')" color="error" @click="deleteRole(item.id)">mdi-delete</v-icon>
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
import tableTitles from "../../mixins/data_table_titles";

export default {
  name: "index.vue",
  mixins: [tableTitles],
  components: {Edit, Create, Card},
  middleware: 'auth',
  computed: {
    ...mapGetters({
      roles: 'roles/roles',
      loading: 'roles/loading',
      errors: 'roles/errors',
    }),

    rolesTableHeader() {
      let header = [
        {text: this.$t('title'), value: 'name', sortable: true},
      ];

      if (this.$can('edit roles') || this.$can('delete roles')) {
        header.push({text: this.$t('actions'), value: 'actions', align: 'end', sortable: false});
      }

      return header;
    },
  },
  mounted() {
    this.fetchRolesAndPermissions();
  },
  metaInfo() {
    return {title: this.$t('roles')}
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
  methods: {
    ...mapActions({
      fetchRolesAndPermissions: 'roles/fetchRolesAndPermissions',
      deleteRole: 'roles/deleteRole',
    }),
  }
}
</script>
