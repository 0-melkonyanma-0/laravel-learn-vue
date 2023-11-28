<template>
  <v-container>
    <v-form @submit.prevent="false">
      <card :title="$t('create')">
        <template v-slot:card-text>
          <v-text-field
            v-model="body.title"
            :label="$t('title')"
            dense
            name="name"
            outlined
            type="text"
          ></v-text-field>

          <v-divider/>

          <v-expansion-panels>
            <v-expansion-panel
              v-for="(item,i) in 5"
              :key="i"
            >
              <v-expansion-panel-header>
                Item
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat.
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>

        </template>
        <template v-slot:card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="success"
            outlined
            plain
            type="success"
          >
            {{ $t('create') }}
          </v-btn>
        </template>
      </card>
    </v-form>
  </v-container>
</template>

<script>
import Card from "../../components/Card.vue";
import {mapActions, mapGetters} from "vuex";

export default {
  components: {Card},
  data: () => ({
    body: {
      title: '',
      permissions: [],
    }
  }),
  mounted() {
    this.fetchPermissions();
  },
  computed: {
    ...mapGetters({
      permissions: 'roles/permissions'
    }),
  },
  methods: {
    ...mapActions({
      fetchPermissions: 'roles/fetchPermissions'
    }),
  }
}
</script>
