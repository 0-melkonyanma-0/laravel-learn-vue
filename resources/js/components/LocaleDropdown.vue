<template>
  <div>
    <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          plain
          v-bind="attrs"
          v-on="on"
        >
          {{ locales[locale] }}
        </v-btn>
      </template>
      <v-list>
        <v-list-item
          v-for="(value, key)  in locales" :key="key"
          @click.prevent="setLocale(key)"
        >
          {{ value }}
        </v-list-item>
      </v-list>
    </v-menu>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
import {loadMessages} from '~/plugins/i18n'

export default {
  computed: mapGetters({
    locale: 'lang/locale',
    locales: 'lang/locales'
  }),

  methods: {
    setLocale(locale) {
      if (this.$i18n.locale !== locale) {
        loadMessages(locale)

        this.$store.dispatch('lang/setLocale', {locale})
      }
    }
  }
}
</script>
