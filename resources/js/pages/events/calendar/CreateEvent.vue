<template>
  <div>
    <v-card v-if="loading" height="400">
      <v-card-text>
        <v-sheet
          color="lighten-4"
        >
          <v-skeleton-loader class="mx-auto" max-height="800" type="article"></v-skeleton-loader>
        </v-sheet>
      </v-card-text>
    </v-card>
    <card v-else :title="$t('create')">
      <template v-slot:card-text>
        <v-text-field
          v-model="body.name"
          :label="$t('title')"
          :error-messages="proccessedErrors.name"
          dense
          outlined
        >
        </v-text-field>
        <v-textarea
          v-model="body.description"
          :label="$t('description')"
          :error-messages="proccessedErrors.description"
          dense
          height="100"
          no-resize
          outlined
        >
        </v-textarea>

        <v-select
          v-model="body.user_id"
          :error-messages="proccessedErrors.user_id"
          :items="users"
          :label="$t('executor')"
          item-value="id"
          outlined
        >
          <template v-slot:item="{active, item, attrs, on}">
            {{ item.name }}
          </template>
          <template v-slot:selection="{active, item, attrs, on}">
            {{ item.name }}
          </template>
        </v-select>

        <v-text-field
          v-model="body.start"
          :error-messages="proccessedErrors.start"
          :label="$t('start_date')"
          dense
          name="start"
          outlined
          type="datetime-local"
        >
        </v-text-field>
        <v-text-field
          v-model="body.end"
          :error-messages="proccessedErrors.end"
          :label="$t('end_date')"
          dense
          name="end"
          outlined
          type="datetime-local"
        >
        </v-text-field>
        <div class="justify-content-center">
          <v-color-picker
            v-model="body.color"
            hide-canvas
            hide-inputs
            width="500"
          />
        </div>
      </template>
      <template v-slot:card-actions>
        <v-spacer/>
        <v-btn
          color="success"
          outlined
          plain
          type="success"
          @click="createEvent(body)"
        >
          {{ $t('create') }}
        </v-btn>
      </template>
    </card>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Card from "../../../components/Card.vue";
import events from "../../../mixins/events";

export default {
  mixins: [events],
  components: {Card},
  data: () => ({
    body: {
      name: '',
      description: '',
      start: '',
      end: '',
      color: '',
      user_id: '',
    },
  }),
  computed: {
    ...mapGetters({
      locale: 'lang/locale',
      events: 'events/events',
    }),
  },
  methods: {
    ...mapActions({
      createEvent: 'events/createEvent',
    })
  }
}
</script>
