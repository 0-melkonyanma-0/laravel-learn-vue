<template>
  <card :title="$t('edit')">
    <template v-slot:card-text>
      <v-text-field
          v-model="body.title"
          :error-messages="errorMessage"
          :label="$t('title')"
          dense
          name="title"
          outlined
      >
      </v-text-field>
    </template>
    <template v-slot:card-actions>
      <v-spacer/>
      <v-btn
          color="success"
          outlined
          plain
          type="success"
          @click="updateJobTitle(body)"
      >
        {{ $t('update') }}
      </v-btn>
    </template>
  </card>
</template>

<script>
import Card from "../../components/Card.vue";
import {mapActions} from "vuex";

export default {
  components: {Card},
  props: {
    item: {
      require: true,
      type: Object
    },
    errors: {
      type: Array
    }
  },
  computed: {
    body() {
      return {...this.item};
    },
  },
  methods: {
    ...mapActions({
      updateJobTitle: 'job_titles/updateJobTitle'
    })
  },
  data: () => ({
    errorMessage: '',
  }),
  watch: {
    errors: {
      handler() {
        try {
          this.errorMessage = this.errors[0].title[0];
        } catch (e) {
          this.errorMessage = '';
        }
      },
      deep: true,
    },
  }
}
</script>
