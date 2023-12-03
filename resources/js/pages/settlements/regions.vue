<template>
  <div>
    <v-dialog v-model="dialogOn" width="500">
      <card :title="$t('import_regions')">
        <template v-slot:card-text>
          <v-form @submit.prevent="false">
            <v-file-input
              truncate-length="15"
              show-size
              v-model="body.excel_file"
            >
            </v-file-input>
          </v-form>
        </template>
        <template v-slot:card-actions>
          <v-spacer></v-spacer>
          <v-btn type="success" @click="importRegion">
            {{ $t('importing') }}
          </v-btn>
        </template>
      </card>
    </v-dialog>

    <v-container>
      <card :title="$t('regions')">
        <template v-slot:card-title>
          <v-spacer></v-spacer>
          <v-text-field
            :placeholder="$t('search_placeholder')"
            prepend-inner-icon="mdi-magnify"
          >
          </v-text-field>
          <v-btn
            class="ml-1"
            icon
            @click="fetchRegion"
          >
            <v-icon>mdi-refresh</v-icon>
          </v-btn>
          <v-btn
            class="ml-1"
            icon
            @click="exportCitiesByRegion"
          >
            <v-icon>mdi-export</v-icon>
          </v-btn>
          <v-btn
            class="ml-1"
            icon
            @click="dialogOn = !dialogOn"
          >
            <v-icon>mdi-import</v-icon>
          </v-btn>
        </template>
        <template v-slot:card-text>
          <v-data-table
            :search="search"
            :headers="settlementsHeader"
            :items="regions"
            :loading="loading"
          >
            <template v-slot:progress>
              <v-progress-linear color="red" indeterminate></v-progress-linear>
            </template>
            <template v-slot:item.actions="{item}">
              <v-icon v-if="$can('delete settlements')" color="error" @click="deleteRegion(item.id)">mdi-delete</v-icon>
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

export default {
  components: {Card},
  mixins: [settlements],
  mounted() {
    this.fetchRegion();
  },
  data: () => ({
    loading: true,
    regions: []
  }),
  methods: {
    fetchRegion() {
      this.loading = true;

      axios.get('/api/regions').then((response) => {
        this.loading = false;
        this.regions = response.data;
      })
    },
    deleteRegion(id) {
      axios.delete(`/api/regions/${id}`)
        .then(() => {
          this.loading = true;
          this.fetchCity();
        })
        .catch(() => {

        });
    },
    importRegion() {
      const form = new FormData();

      form.append('excel_file', this.body.excel_file, this.body.excel_file.file);

      console.log(this.body)

      axios.post('/api/import/regions', form, {
        headers: {
          'Content-Type': this.body.excel_file.type
        }
      })
        .then((response) => {

        });
    }
  },
  metaInfo() {
    return {title: this.$t('regions')}
  }
}
</script>

