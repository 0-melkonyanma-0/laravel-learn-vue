<template>
  <div>
    <v-card v-if="loading" height="800">
      <v-card-text>
        <v-sheet
          color="lighten-4"
        >
          <v-skeleton-loader class="mx-auto" max-height="800" type="article"></v-skeleton-loader>
        </v-sheet>
      </v-card-text>
    </v-card>
    <v-timeline
      v-else
      dense
    >
      <v-timeline-item
        v-for="(log,idx) in activityLog"
        :key="idx" color="cyan"
      >
        <v-card
          color="cyan"
          width="650"
        >
          <v-card-title class="text-h6 white--text">
            {{ $t('updated_at') }} {{ humanizeData(log.created_at) }}
          </v-card-title>
          <v-card-text class="white text--primary pa-1">
            <div v-for="i in Object.keys(log.properties.old)" class="pa-1">
              {{ formatName(i) }}
              {{ $t('updated') }}
              {{ $t('from') }}
              <v-chip>
                {{
                  log.properties.old[i] !== null ? $t(getInfoById(i, log.properties.old[i])).toLowerCase() : $t('not_indicated').toLowerCase()
                }}
              </v-chip>
              {{ $t('to') }}
              <v-chip>{{ $t(getInfoById(i, log.properties.attributes[i])).toLowerCase() }}</v-chip>
            </div>
          </v-card-text>
        </v-card>
      </v-timeline-item>
    </v-timeline>
  </div>
</template>

<script>

import user from "../../../mixins/user";

export default {
  mixins: [user],
  watch: {
    editFormSelectionItems() {
      this.loading = false;
    }
  },
  props: {
    activityLog: {
      require: true,
      type: Object,
    },
  },
  methods: {
    getInfoById(attributeName, id) {
      if (typeof id !== 'number') {
        return id;
      }

      Object.keys(this.editFormSelectionItems).forEach((item) => {
        if (item.includes(attributeName.slice(0, -3))) {
          attributeName = item;
        }
      });

      return this.editFormSelectionItems[attributeName].filter((item) => item.id === id)[0]['title'];

    },
    formatName(text) {
      if (text.includes('_id')) {
        text = text.slice(0, -3);
      }

      return this.$t(text);
    },
    humanizeData(data) {
      data = new Date(data);

      return `${data.getUTCDate().toString().length !== 2 ? '0' + data.getUTCDate() : data.getUTCDate()} -
      ${data.getMonth().toString().length !== 2 ? '0' + (data.getMonth() + 1) : data.getMonth() + 1} - ${data.getUTCFullYear()}`
    }
  }
}
</script>
