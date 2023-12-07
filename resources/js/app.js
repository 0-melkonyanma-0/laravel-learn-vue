import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import vuetify from '~/plugins/vuetify'
import Chart from '~/plugins/apexchart';

import '~/plugins'
import '~/components'
import permissions from './mixins/permissions'

Vue.config.productionTip = false

/* eslint-disable no-new */
Vue.mixin(permissions)

new Vue({
  vuetify,
  i18n,
  store,
  router,
  ...App
})
