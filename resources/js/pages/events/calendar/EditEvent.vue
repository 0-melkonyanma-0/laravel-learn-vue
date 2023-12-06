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
    <card :title="editFormTitle" v-else>
      <template v-if="editBody.status" v-slot:card-title>
        <v-chip :color="editBody.color" class="mb-2" text-color="white">{{ editBody.name }}</v-chip>
      </template>
      <template v-slot:card-text>
        <v-text-field
          v-model="editBody.name"
          :disabled="editBody.status"
          :label="$t('title')"
          dense
          outlined
        >
        </v-text-field>
        <v-textarea
          v-model="editBody.description"
          :disabled="editBody.status"
          :label="$t('description')"
          dense
          height="100"
          no-resize
          outlined
        >
        </v-textarea>

        <v-select
          v-model="editBody.user_id"
          :disabled="editBody.status"
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
          v-model="editBody.start"
          :disabled="editBody.status"
          :label="$t('start_date')"
          dense
          name="start"
          outlined
          type="datetime-local"
        >
        </v-text-field>
        <v-text-field
          v-model="editBody.end"
          :disabled="editBody.status"
          :label="$t('end_date')"
          dense
          name="end"
          outlined
          type="datetime-local"
        >
        </v-text-field>
        <div class="justify-content-center">
          <v-color-picker
            v-model="editBody.color"
            :disabled="editBody.status"
            hide-canvas
            hide-inputs
            width="500"
          />
        </div>
      </template>
      <template v-slot:card-actions>
        <div v-if="!editBody.status">
          <v-btn
            @click="updateEventStatus(editBody.id)"
          >
            {{ $t('done') }}
          </v-btn>
          <v-spacer/>
          <v-btn
            v-if="$can('delete events')"
            color="red"
            outlined
            plain
            type="success"
            @click="deleteEvent(editBody.id)"
          >
            {{ $t('delete') }}
          </v-btn>
          <v-btn
            v-if="$can('edit events')"
            color="success"
            outlined
            plain
            type="success"
            @click="updateEvent(editBody)"
          >
            {{ $t('edit') }}
          </v-btn>
        </div>
      </template>
    </card>
  </div>
</template>

<script>
import Card from "../../../components/Card.vue";
import {mapActions} from "vuex";
import events from "../../../mixins/events";

export default {
  mixins: [events],
  components: {Card},
  props: {
    editBody: {
      require: true,
      type: Object
    },
  },
  methods: {
    ...mapActions({
      updateEvent: 'events/updateEvent',
      updateEventStatus: 'events/updateEventStatus',
      deleteEvent: 'events/deleteEvent'
    }),
  },
  computed: {
    editFormTitle() {
      return !this.editBody.status ? this.$t('edit') : '';
    }
  }
}
</script>
