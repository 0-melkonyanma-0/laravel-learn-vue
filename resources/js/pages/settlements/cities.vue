<template>
  <v-container>
    <card :title="$t('cities')">
      <template v-slot:card-title>
        <v-spacer></v-spacer>
        <v-text-field v-model="search" prepend-inner-icon="mdi-magnify"></v-text-field>
      </template>
      <template v-slot:card-text>
        <v-data-table
          :headers="settlementsHeader"
          :search="search"
        >
        </v-data-table>
      </template>
    </card>
  </v-container>
</template>

<script>
import settlements from "../../mixins/settlements";
import Card from "../../components/Card.vue";

export default {
  components: {Card},
  mixins: [settlements],
  metaInfo() {
    return {title: this.$t('cities')}
  }
}
</script>

<style scoped>

</style>
