<template>
  <v-container>
    <card :title="$t('regions')">
      <template v-slot:card-title>
        <v-spacer></v-spacer>
        <v-text-field
          :placeholder="$t('search_placeholder')"
          prepend-inner-icon="mdi-magnify"
        >
        </v-text-field>
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
</template>

<script>
import Card from "../../components/Card.vue";
import settlements from "../../mixins/settlements";
import axios from "axios";

export default {
  components: {Card},
  mixins: [settlements],
  mounted() {
    this.fetchCity();
  },
  data: () => ({
    loading: true,
    regions: []
  }),
  methods: {
    fetchCity() {
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
  },
  metaInfo() {
    return {title: this.$t('regions')}
  }
}
</script>

