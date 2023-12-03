<template>
  <v-container>
    <card :title="$t('cities')">
      <template v-slot:card-title>
        <v-spacer></v-spacer>
        <v-text-field v-model="search" prepend-inner-icon="mdi-magnify"></v-text-field>
        <v-btn
          class="ml-1"
          icon
          @click="fetchCity"
        >
          <v-icon>mdi-refresh</v-icon>
        </v-btn>
        <v-btn
          class="ml-1"
          icon
          @click=""
        >
          <v-icon>mdi-export</v-icon>
        </v-btn>
        <v-btn
          class="ml-1"
          icon
          @click=""
        >
          <v-icon>mdi-import</v-icon>
        </v-btn>
      </template>
      <template v-slot:card-text>
        <v-data-table
          :search="search"
          :headers="settlementsHeader"
          :items="cities"
          :loading="loading"
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
import loading from "../../components/Loading.vue";

export default {
  components: {Card},
  mixins: [settlements],
  data: () => ({
    loading: true,
    cities: []
  }),
  mounted() {
    this.fetchCity();
  },
  methods: {
    fetchCity() {
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
          this.fetchCity();
        })
        .catch(() => {

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
