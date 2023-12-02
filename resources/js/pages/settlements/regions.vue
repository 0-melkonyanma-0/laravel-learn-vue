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
        >
        </v-data-table>
      </template>
    </card>
  </v-container>
</template>

<script>
import Card from "../../components/Card.vue";
import settlements from "../../mixins/settlements";

export default {
  components: {Card},
  mixins: [settlements],
  metaInfo() {
    return {title: this.$t('regions')}
  }
}
</script>

<style scoped>

</style>
