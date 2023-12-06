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
          <card :title="$t('create')">
            <template v-slot:card-text>
              <v-text-field
                v-model="body.name"
                :label="$t('title')"
                dense
                outlined
              >
              </v-text-field>
              <v-textarea
                v-model="body.description"
                :label="$t('description')"
                dense
                height="100"
                no-resize
                outlined
              >
              </v-textarea>

              <v-select
                v-model="body.user_id"
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
                :label="$t('start_date')"
                dense
                name="start"
                outlined
                type="datetime-local"
              >
              </v-text-field>
              <v-text-field
                v-model="body.end"
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
              color="primary"
              fab
              outlined
              small
              text
              @click="dialogOn = !dialogOn"
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
            @click:date="viewDay"
            @click:more="viewDay"
          />
        </v-sheet>
      </template>
    </card>
  </v-container>
</template>

<script>
import Card from "../../components/Card.vue";
import {mapActions, mapGetters} from "vuex";

export default {
  components: {Card},
  metaInfo() {
    return {title: this.$t('calendar')}
  },
  computed: {
    ...mapGetters({
      locale: 'lang/locale',
      events: 'events/events',
      users: 'users/users'
    })
  },
  data: () => ({
    body: {
      name: '',
      description: '',
      start: '',
      end: '',
      color: '',
      user_id: '',
    },
    dialogOn: true,
    focus: '',
    type: 'month',
    typeToLabel: {
      month: 'month',
      week: 'week',
      day: 'day'
    }
  }),
  mounted() {
    this.fetchEvents();
    this.fetchUsers();
    this.$refs.calendar.checkChange();
  },
  methods: {
    ...mapActions({
      fetchEvents: 'events/fetchEvents',
      createEvent: 'events/createEvent',
      fetchUsers: 'users/fetchUsers',
    }),
    updateRange({start, end}) {
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
    }
  },
}
</script>
