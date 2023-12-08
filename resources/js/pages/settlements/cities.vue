<template>
  <v-container>
    <v-dialog v-model="dialogOn" width="500">
      <card :title="$t('import_cities')">
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
        <template v-slot:card-actions>ye
          <v-spacer></v-spacer>
          <v-btn width="40" height="40" type="success" @click="importCity">
            {{ $t("importing") }}
          </v-btn>
        </template>
      </card>
    </v-dialog>

    <card :title="$t('cities')">
      <template v-slot:card-title>
        <v-spacer></v-spacer>
        <v-row class="mt-5 mr-5">
          <v-text-field
            v-model="search"
            :placeholder="$t('search_placeholder')"
            prepend-inner-icon="mdi-magnify"
            dense
            outlined
          >
          </v-text-field>
          <v-btn
            class="ml-1"
            icon
            @click="fetchCities"
            width="40" height="40"
          >
            <v-icon>mdi-refresh</v-icon>
          </v-btn>
          <v-btn
            class="ml-1"
            icon
            @click="exportCitiesByRegion"
            width="40" height="40"
          >
            <v-icon>mdi-export</v-icon>
          </v-btn>
          <v-btn
            class="ml-1"
            icon
            @click="dialogOn = !dialogOn"
            width="40" height="40"
          >
            <v-icon>mdi-import</v-icon>
          </v-btn>
        </v-row>
      </template>
      <template v-slot:card-text>
        <v-data-table
          :headers="settlementsHeader"
          :items="cities"
          :loading="loading"
          :loading-text="tableTitles.loading_text"
          :no-data-text="tableTitles.no_data_text"
          :search="search"
        >
          <template v-slot:progress>
            <v-progress-linear color="red" indeterminate></v-progress-linear>
          </template>
          <template v-slot:item.actions="{item}">
            <v-icon v-if="$can('delete settlements')" color="error" @click="deleteCity(item.id)">mdi-delete</v-icon>
          </template>
        </v-data-table>
      </template>
    </card>
  </v-container>
</template>

<script>
import settlements from "../../mixins/settlements";
import Card from "../../components/Card.vue";
import axios from "axios";
import tableTitles from "../../mixins/data_table_titles";

export default {
  components: {Card},
  mixins: [settlements, tableTitles],
  data: () => ({
    loading: true,
    cities: []
  }),
  mounted() {
    this.fetchCities();
  },
  methods: {
    fetchCities() {
      this.loading = true;

      axios.get('/api/cities').then((response) => {
        this.loading = false;
        this.cities = response.data;
      })
    },
    deleteCity(id) {
      axios.delete(`/api/cities/${id}`)
        .then(() => {
          this.loading = true;
          this.fetchCities();
        })
        .catch(() => {

        });
    },
    importCity() {
      const form = new FormData();

      form.append(
        "excel_file",
        this.body.excel_file,
        this.body.excel_file.file
      );

      axios
        .post("/api/import/cities", form, {
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
    return {title: this.$t('cities')}
  },
}
</script>

<style scoped>

</style>
