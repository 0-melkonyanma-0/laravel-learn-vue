<template>
  <div>
    <v-app-bar
      app
      fixed
    >
      <v-app-bar-nav-icon
        @click="drawer = !drawer"
      >
      </v-app-bar-nav-icon>
      <v-spacer></v-spacer>
      <v-btn plain>
        <locale-dropdown/>
      </v-btn>
      <v-menu offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-badge
            bordered
            bottom
            color="success"
            dot
            offset-x="10"
            offset-y="10"
          >
            <v-avatar
              size="40"
              v-bind="attrs"
              v-on="on"
            >
              <v-img :src="user.photo_url"/>
            </v-avatar>
          </v-badge>
        </template>
        <v-list dense>
          <v-list-item-group>
            <div @click.prevent="logout">
              <menu-button :icon="'mdi-logout'">
                {{ $t('logout') }}
              </menu-button>
            </div>
          </v-list-item-group>
        </v-list>
      </v-menu>
    </v-app-bar>
    <drawer
      v-if="user"
      :drawer="drawer"
      :app-name="appName">
    </drawer>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
import LocaleDropdown from './LocaleDropdown'
import Drawer from "./Drawer.vue";
import MenuButton from "./MenuButton.vue";

export default {
  components: {
    MenuButton,
    Drawer,
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName,
    drawer: true,
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout() {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({name: 'login'})
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}

.container {
  max-width: 1100px;
}
</style>
