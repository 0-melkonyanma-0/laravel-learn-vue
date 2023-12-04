<template>
  <v-timeline>
    <v-timeline-item
      v-for="(log,idx) in activityLog"
      :key="idx" color="cyan"
    >
      <v-card
        color="cyan"
        width="500"
      >
        <v-card-title class="text-h6 white--text">
          {{ $t('updated_at') }} {{ humanizeData(log.created_at) }}
        </v-card-title>
        <v-card-text class="white text--primary pa-1">
          <div v-for="i in Object.keys(log.properties.old)" class="pa-1">
            {{ i }}
            {{ $t('from') }}
            <v-chip>{{
                log.properties.old[i] !== null ? log.properties.old[i] : $t('not_indicated').toLowerCase()
              }}
            </v-chip>
            {{ $t('to') }}
            <v-chip>{{ log.properties.attributes[i] }}</v-chip>
          </div>
        </v-card-text>
      </v-card>
    </v-timeline-item>
  </v-timeline>
</template>

<script>

export default {
  props: {
    activityLog: {
      require: true,
      type: Object
    }
  },
  methods: {
    humanizeData(data) {
      data = new Date(data);

      return `${data.getUTCDate().toString().length !== 2 ? '0' + data.getUTCDate() : data.getUTCDate()} -
      ${data.getMonth().toString().length !== 2 ? '0' + (data.getMonth() + 1) : data.getMonth() + 1} - ${data.getUTCFullYear()}`
    }
  }
}
</script>
