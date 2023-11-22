import Vue from 'vue'
import Vuetify from 'vuetify'
import * as components from 'vuetify/lib/components'
import * as directives from 'vuetify/lib/directives'

const opts = {
  components,
  directives
}

Vue.use(Vuetify)

export default new Vuetify({
  opts
})
