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
        <v-chip :color="editBody.color" class="mb-2" text-color="white">{{ editBody.name.length > 50 ? `${editBody.name.slice(0,51)}...` : editBody.name }}</v-chip>
      </template>
      <template v-slot:card-text>
        <v-text-field
          v-model="editBody.name"
          :disabled="disabledField(editBody.status)"
          :error-messages="proccessedErrors.name"
          :label="$t('title')"
          dense
          outlined
        >
        </v-text-field>
        <v-textarea
          v-model="editBody.description"
          :disabled="disabledField(editBody.status)"
          :label="$t('description')"
          :error-messages="proccessedErrors.description"
          dense
          height="100"
          no-resize
          outlined
        >
        </v-textarea>

        <v-select
          v-model="editBody.user_id"
          :disabled="disabledField(editBody.status)"
          :items="users"
          :error-messages="proccessedErrors.user_id"
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
          :disabled="disabledField(editBody.status)"
          :error-messages="proccessedErrors.start"
          :label="$t('start_date')"
          dense
          name="start"
          outlined
          type="datetime-local"
        >
        </v-text-field>
        <v-text-field
          v-model="editBody.end"
          :disabled="disabledField(editBody.status)"
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
            v-model="editBody.color"
            :disabled="disabledField(editBody.status)"
            hide-canvas
            hide-inputs
            width="500"
          />
        </div>
      </template>
      <template v-slot:card-actions>
        <v-btn
          @click="updateEventStatus(editBody.id)"
          outlined
          plain
          color="primary"
          v-if="!editBody.status"
        >
          <v-icon>
            mdi-check
          </v-icon>
        </v-btn>
        <v-spacer></v-spacer>
        <div v-if="!editBody.status">
          <v-btn
            v-if="$can('delete events')"
            color="red"
            outlined
            plain
            type="success"
            @click="deleteEvent(editBody.id)"
          >
            <v-icon>
              mdi-delete
            </v-icon>
          </v-btn>
          <v-btn
            v-if="$can('edit events')"
            color="success"
            outlined
            plain
            type="success"
            @click="updateEvent(editBody)"
          >
            <v-icon>
              mdi-pencil
            </v-icon>
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
    disabledField(stateTextField) {
      if (stateTextField === null) {
        return false;
      } else if (stateTextField) {
        return true;
      }
    }
  },
  computed: {
    editFormTitle() {
      return !this.editBody.status ? this.$t('edit') : '';
    }
  }
}
</script>
