<template>
  <v-container>
    <v-dialog
      v-model="dialogOn"
      width="500"
    >
      <v-form v-if="createDepartmentDialog && $can('create departments')" @submit.prevent="false">
        <create :errors="errors">
        </create>
      </v-form>

      <v-form v-else-if="editDepartmentDialog && $can('edit departments')" @submit.prevent="false">
        <edit :errors="errors" :item="editItem"/>
      </v-form>
    </v-dialog>

    <card :title="$t('departments')">
      <template v-slot:card-title>
        <div class="ml-2"></div>
        <v-btn
          v-if="$can('create departments')"
          color="primary"
          rounded
          @click="creator"
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
          @click="fetchDepartments"
        >
          <v-icon>mdi-refresh</v-icon>
        </v-btn>
      </template>
      <template v-slot:card-text>
        <v-data-table
          ref="departmentTable"
          :headers="departmentTableHeader"
          :items="departments"
          :loading="loading"
          :loading-text="tableTitles.loading_text"
          :no-data-text="tableTitles.no_data_text"
          :search="search"
        >
          <template v-slot:progress>
            <v-progress-linear color="red" indeterminate></v-progress-linear>
          </template>
          <template v-slot:item.actions="{item}">
            <v-icon v-if="$can('edit departments')" color="success" @click="editor(item)">mdi-pencil</v-icon>
            <v-icon v-if="$can('delete departments')" color="error" @click="deleteDepartment(item.id)">mdi-delete
            </v-icon>
          </template>
        </v-data-table>
      </template>
    </card>
  </v-container>
</template>

<script>
import {mapActions, mapGetters, mapMutations} from "vuex";
import Card from "../../components/Card.vue";
import Create from "./create.vue";
import Edit from "./edit.vue";
import tableTitles from "../../mixins/data_table_titles";

export default {
  name: "index.vue",
  components: {Edit, Create, Card},
  mixins: [tableTitles],
  middleware: 'auth',
  computed: {
    ...mapGetters({
      departments: 'departments/departments',
      loading: 'departments/loading',
      errors: 'departments/errors',
    }),

    departmentTableHeader() {
      let header = [
        {text: this.$t('title'), value: 'title', sortable: true},
      ];

      if (this.$can('edit departments') || this.$can('delete departments')) {
        header.push({text: this.$t('actions'), value: 'actions', align: 'end', sortable: false});
      }

      return header;
    },
  },
  metaInfo() {
    return {title: this.$t('departments')}
  },
  mounted() {
    this.fetchDepartments();
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

    createDepartmentDialog: false,
    editDepartmentDialog: false,
    dialogOn: false,
  }),
  methods: {
    ...mapActions({
      fetchDepartments: 'departments/fetchDepartments',
      deleteDepartment: 'departments/deleteDepartment',
    }),
    ...mapMutations({
      clearErrors: 'departments/clearErrors',
    }),
    creator() {
      this.dialogOn = true;
      this.editDepartmentDialog = false;
      this.createDepartmentDialog = true;
    },
    editor(item) {
      this.editItem = item;
      this.dialogOn = true;
      this.createDepartmentDialog = false;
      this.editDepartmentDialog = true;
    }
  }
}
</script>
