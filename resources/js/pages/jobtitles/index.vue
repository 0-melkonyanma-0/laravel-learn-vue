<template>
  <v-container>
    <v-dialog
      v-model="dialogOn"
      width="500"
    >
      <v-form v-if="createDepartmentDialog && $can('create job_titles')" @submit.prevent="false">
        <create :errors="errors">
        </create>
      </v-form>

      <v-form v-else-if="editDepartmentDialog  && $can('edit job_titles')" @submit.prevent="false">
        <edit :errors="errors" :item="editItem"/>
      </v-form>
    </v-dialog>

    <card :title="$t('job_titles')">
      <template v-slot:card-title>
        <div class="ml-2"></div>
        <v-btn
          v-if="$can('create job_titles')"
          color="primary"
          height="40"
          rounded
          @click="creator"
        >
          <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-spacer>
        </v-spacer>
        <v-row class="mt-5 mr-5">
          <v-btn
            class="mr-1"
            icon
            @click="fetchJobTitles"
            height="40"
            width="40"
          >
            <v-icon>mdi-refresh</v-icon>
          </v-btn>
          <v-text-field
            v-model="search"
            outlined
            dense
            :placeholder="$t('search_placeholder')"
            height="40"
            prepend-inner-icon="mdi-magnify"
          >
          </v-text-field>
        </v-row>
      </template>
      <template v-slot:card-text>
        <v-data-table
          ref="jobTitleTable"
          :headers="jobTitleTableHeader"
          :items="jobTitles"
          :loading="loading"
          :loading-text="tableTitles.loading_text"
          :no-data-text="tableTitles.no_data_text"
          :search="search"
        >
          <template v-slot:progress>
            <v-progress-linear color="red" indeterminate></v-progress-linear>
          </template>
          <template v-slot:item.actions="{item}">
            <v-icon v-if="$can('edit job_titles')" color="success" @click="editor(item)">mdi-pencil</v-icon>
            <v-icon v-if="$can('delete job_titles')" color="error" @click="deleteJobTitle(item.id)">mdi-delete</v-icon>
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
  components: {Edit, Create, Card},
  computed: {
    ...mapGetters({
      errors: 'job_titles/errors',
      loading: 'job_titles/loading',
      jobTitles: 'job_titles/jobTitles',
      responseStatus: 'app/responseStatus',
    }),

    jobTitleTableHeader() {
      let header = [
        {text: this.$t('title'), value: 'title', sortable: true},
      ];

      if (this.$can('edit job_titles') || this.$can('delete job_titles')) {
        header.push({text: this.$t('actions'), value: 'actions', align: 'end', sortable: false});
      }

      return header;
    },
  },
  data: () => ({
    search: '',
    editItem: {},

    createDepartmentDialog: false,
    editDepartmentDialog: false,
    dialogOn: false,
  }),
  metaInfo() {
    return {title: this.$t('job_titles')}
  },
  methods: {
    ...mapActions({
      fetchJobTitles: 'job_titles/fetchJobTitles',
      deleteJobTitle: 'job_titles/deleteJobTitle',
      resetResponseStatus: 'app/resetResponseStatus',
    }),
    ...mapMutations({
      clearErrors: 'job_titles/clearErrors',
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
  },
  middleware: 'auth',
  mixins: [tableTitles],
  mounted() {
    this.fetchJobTitles();
  },
  name: "index.vue",
  watch: {
    responseStatus: {
      handler() {
        if (this.responseStatus === true) {
          this.dialogOn = false;
          this.resetResponseStatus();
        }
      }
    },
    dialogOn: {
      handler() {
        this.clearErrors()
      }
    }
  }
}
</script>
