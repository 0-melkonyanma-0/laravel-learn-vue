<template>
  <card :title="$t('create')">
    <template v-slot:card-text>
      <v-text-field
          v-model="title"
          :label="$t('title')"
          :error-messages="errorMessage"
          name="title"
          dense
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
          @click="createJobTitle({title: title})"
      >
        {{ $t('create') }}
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
    errors: {
      type: Array
    }
  },
  data: () =>({
    errorMessage: '',
    title: ''
  }),
  watch: {
    errors: {
      handler() {
        try {
          this.errorMessage = this.errors[0].title[0];
        } catch (e) {
          this.errorMessage = '';
          this.title = '';
        }
      },
      deep: true,
    },
  },
  methods: {
    ...mapActions({
      createJobTitle: 'job_titles/createJobTitle',
    })
  }
}
</script>
