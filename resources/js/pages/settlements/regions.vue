<template>
  <div>
    <v-dialog v-model="dialogOn" width="500">
      <card :title="$t('import_regions')">
        <template v-slot:card-text>
          <v-form @submit.prevent="false">
            <v-file-input
              v-model="body.excel_file"
              show-size
              truncate-length="15"
            >
            </v-file-input>
          </v-form>
        </template>
        <template v-slot:card-actions>
          <v-spacer></v-spacer>
          <v-btn type="success" @click="importRegion">
            {{ $t("importing") }}
          </v-btn>
        </template>
      </card>
    </v-dialog>

    <v-container>
      <card :title="$t('regions')">
        <template v-slot:card-title>
          <v-spacer></v-spacer>
          <v-row
            class="mr-5 mt-5"
          >
            <v-text-field
              :placeholder="$t('search_placeholder')"
              prepend-inner-icon="mdi-magnify"
              dense
              outlined
            >
            </v-text-field>
            <v-btn class="ml-1" icon @click="fetchRegions"
              width="40" height="40"
            >
              <v-icon>mdi-refresh</v-icon>
            </v-btn>
            <v-btn class="ml-1" icon @click="exportCitiesByRegion"
              width="40" height="40"
            >
              <v-icon>mdi-export</v-icon>
            </v-btn>
            <v-btn class="ml-1" icon @click="dialogOn = !dialogOn"
              width="40" height="40"
            >
              <v-icon>mdi-import</v-icon>
            </v-btn>
          </v-row>
        </template>
        <template v-slot:card-text>
          <v-data-table
            :headers="settlementsHeader"
            :items="regions"
            :loading="loading"
            :loading-text="tableTitles.loading_text"
            :no-data-text="tableTitles.no_data_text"
            :search="search"
          >
            <template v-slot:progress>
              <v-progress-linear color="red" indeterminate></v-progress-linear>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon
                v-if="$can('delete settlements')"
                color="error"
                @click="deleteRegion(item.id)"
              >mdi-delete
              </v-icon
              >
            </template>
          </v-data-table>
        </template>
      </card>
    </v-container>
  </div>
</template>

<script>
import Card from "../../components/Card.vue";
import settlements from "../../mixins/settlements";
import axios from "axios";
import dataTableTitle from "../../mixins/data_table_titles";

export default {
  components: {Card},
  mixins: [settlements, dataTableTitle],
  mounted() {
    this.fetchRegions();
  },
  data: () => ({
    loading: true,
    regions: [],
  }),
  methods: {
    fetchRegions() {
      this.loading = true;

      axios.get("/api/regions").then((response) => {
        this.loading = false;
        this.regions = response.data;
      });
    },
    deleteRegion(id) {
      axios
        .delete(`/api/regions/${id}`)
        .then(() => {
          this.loading = true;
          this.fetchCity();
        })
        .catch(() => {
        });
    },
    importRegion() {
      const form = new FormData();

      form.append(
        "excel_file",
        this.body.excel_file,
        this.body.excel_file.file
      );

      axios
        .post("/api/import/regions", form, {
          headers: {
            "Content-Type": this.body.excel_file.type,
          },
        })
        .then((response) => {
          this.dialogOn = false;
        });
    },
  },
  metaInfo() {
    return {title: this.$t("regions")};
  },
};
</script>

