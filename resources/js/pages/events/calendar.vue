<template>
  <v-container>
    <card
      :title="$t('calendar')"
    >
      <template v-slot:card-text>
        <v-dialog
          v-model="dialogOn"
          width="600"
        >
          <create-event v-if="dialogType === 'create'" :dialog-on="dialogOn"/>
          <edit-event v-else-if="dialogType === 'edit'" :edit-body="editBody"/>
        </v-dialog>
        <v-sheet>
          <v-toolbar
            flat
          >
            <v-btn outlined @click="setToday">
              {{ $t('today') }}
            </v-btn>
            <v-btn
              color="grey darken-2"
              fab
              small
              text
              @click="prev"
            >
              <v-icon small>
                mdi-chevron-left
              </v-icon>
            </v-btn>
            <v-btn
              color="grey darken-2"
              fab
              small
              text
              @click="next"
            >
              <v-icon small>
                mdi-chevron-right
              </v-icon>
            </v-btn>
            <v-btn
              v-if="$can('create events')"
              color="primary"
              fab
              outlined
              small
              text
              @click="createEvent"
            >
              <v-icon small>
                mdi-plus
              </v-icon>
            </v-btn>
            <v-spacer/>
            <v-toolbar-title v-if="$refs.calendar">{{ $refs.calendar.title }}</v-toolbar-title>
            <v-spacer/>
            <v-menu
              bottom
              right
            >
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  color="grey darken-2"
                  outlined
                  v-bind="attrs"
                  v-on="on"
                >
                  <span>{{ $t(typeToLabel[type]) }}</span>
                  <v-icon right>
                    mdi-menu-down
                  </v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-item
                  v-for="(label, idx) in typeToLabel"
                  :key="idx" @click="type = label"
                >
                  <v-list-item-title>{{ $t(label) }}</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
          </v-toolbar>
        </v-sheet>
        <v-sheet
          height="600"
        >
          <v-calendar
            ref="calendar"
            v-model="focus"
            :events="events"
            :locale="locale"
            :type="type"
            color="primary"
            @change="updateRange"
            @click:event="showEvent"
            @click:date="viewDay"
            @click:more="viewDay"
          >
          </v-calendar>
        </v-sheet>
      </template>
    </card>
  </v-container>
</template>

<script>
import Card from "../../components/Card.vue";
import {mapActions, mapGetters, mapMutations} from "vuex";
import CreateEvent from "./calendar/CreateEvent.vue";
import EditEvent from "./calendar/EditEvent.vue";
import events from "../../mixins/events";

export default {
  components: {EditEvent, CreateEvent, Card},
  mixins: [events],
  metaInfo() {
    return {title: this.$t('calendar')}
  },
  computed: {
    ...mapGetters({
      locale: 'lang/locale',
      events: 'events/events',
      users: 'users/users'
    }),
  },
  data: () => ({
    editBody: {
      status: false
    },
    dialogOn: false,
    dialogType: '',
    focus: '',
    type: 'month',
    typeToLabel: {
      month: 'month',
      week: 'week',
      day: 'day'
    }
  }),
  mounted() {
    // this.updateRange()
    this.$refs.calendar.checkChange();
  },
  methods: {
    ...mapActions({
      fetchEvents: 'events/fetchEvents',
    }),
    ...mapMutations({
      setStartEnd: 'events/setStartEnd',
    }),
    showEvent({nativeEvent, event}) {
      this.editBody = {...event};
      this.dialogType = 'edit';
      this.dialogOn = !this.dialogOn;
    },
    updateRange({start, end}) {
      this.setStartEnd({start: start.date, end: end.date});
      this.fetchEvents();
    },
    setToday() {
      this.focus = ''
    },
    viewDay({date}) {
      this.focus = date;
      this.type = 'day';
    },
    prev() {
      this.$refs.calendar.prev();
    },
    next() {
      this.$refs.calendar.next();
    },
    createEvent() {
      this.dialogType = 'create';
      this.dialogOn = !this.dialogOn;
    }
  },
}
</script>
