<template>
  <div id="app">
    <v-app>
      <v-main>
        <loading ref="loading"/>

        <transition mode="out-in" name="page">
          <component :is="layout" v-if="layout"/>
        </transition>
        <v-snackbar
          v-for="(responseMessage, idx) in responseMessages"
          :key="idx"
          :color="responseMessage.color"
          :timeout="responseMessage.timeout"
          :value="responseMessage.show"
          :style="`bottom: ${idx * 75}px`"
          absolute
          bottom
          multi-line
          right
          border="right"
          rounded
          height="40"
        >
          <v-icon>{{ responseMessage.icon }}</v-icon>
          <span class="ml-4">{{ responseMessage.message }}</span>
        </v-snackbar>
      </v-main>
    </v-app>
  </div>
</template>

<script>
import Loading from './Loading'
import {mapGetters} from "vuex";

// Load layout components dynamically.
const requireContext = require.context('~/layouts', false, /.*\.vue$/)

const layouts = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)]
  )
  .reduce((components, [name, component]) => {
    components[name] = component.default || component
    return components
  }, {})

export default {
  components: {
    Loading
  },

  computed: {
    ...mapGetters({
      responseMessages: 'app/responseMessages',
    }),
  },

  data: () => ({
    layout: null,
    defaultLayout: 'default'
  }),
  el: '#app',
  metaInfo() {
    const {appName} = window.config

    return {
      title: appName,
      titleTemplate: `%s / ${appName}`
    }
  },

  methods: {
    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
    setLayout(layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout
      }

      this.layout = layouts[layout]
    }
  },

  mounted() {
    this.$loading = this.$refs.loading
  }
}
</script>
