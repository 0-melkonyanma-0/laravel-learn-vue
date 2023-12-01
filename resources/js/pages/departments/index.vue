<template>
  <v-container>
    <v-dialog
        v-model="dialogOn"
        width="500"
    >
      <v-form v-if="createDepartmentDialog" @submit.prevent="false">
        <create :errors="errors">
        </create>
      </v-form>

      <v-form v-else-if="editDepartmentDialog" @submit.prevent="false">
        <edit :item="editItem" :errors="errors"/>
      </v-form>
    </v-dialog>

    <card :title="$t('departments')">
      <template v-slot:card-title>
        <div class="ml-2"></div>
        <v-btn
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
            :search="search"
        >
          <template v-slot:progress>
            <v-progress-linear color="red" indeterminate></v-progress-linear>
          </template>
          <template v-slot:item.actions="{item}">
            <v-icon color="success" @click="editor(item)">mdi-pencil</v-icon>
            <v-icon color="error" @click="deleteDepartment(item.id)">mdi-delete</v-icon>
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

export default {
  name: "index.vue",
  components: {Edit, Create, Card},
  middleware: 'auth',
  computed: {
    ...mapGetters({
      departments: 'departments/departments',
      loading: 'departments/loading',
      errors: 'departments/errors',
    }),

    departmentTableHeader() {
      return [
        {text: this.$t('title'), value: 'title', sortable: true},
        {text: this.$t('actions'), value: 'actions', align: 'end', sortable: false}
      ]
    },
  },
  metaInfo () {
    return { title: this.$t('departments') }
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
