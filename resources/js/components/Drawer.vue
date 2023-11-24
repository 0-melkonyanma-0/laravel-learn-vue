<template>
  <v-navigation-drawer
    :mini-variant.sync="drawer"
    app
    permanent
  >
    <v-list>
      <v-list-item class="px-2">
        <v-list-item-avatar>
          <v-icon>
            mdi-security
          </v-icon>
        </v-list-item-avatar>
        <v-list-item-title>{{ appName }}</v-list-item-title>
      </v-list-item>
      <v-divider></v-divider>
    </v-list>
    <v-list v-for="group in groups" :key="group.groupName" shaped>
      <v-subheader v-show="!drawer">{{ group.groupName }}</v-subheader>
      <v-list-group class="pr-4">
        <template v-slot:activator>
          <v-list-item-avatar class="pr-4">
            <v-icon>
              {{ group.icon }}
            </v-icon>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>{{ group.groupName }}</v-list-item-title>
          </v-list-item-content>
        </template>
        <v-list-item
          v-for="child in group.children" v-show="!drawer"
          :key="child.name"
          :exact="false"
          class="px-4"
          link
          @click="$router.push(child.path)"
        >
          <v-list-item-content>
            <v-list-item-title>{{ child.name }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
  props: {
    drawer: {
      type: Boolean,
    },
    appName: {
      type: String,
    }
  },
  computed: {
    groups() {
      return [
        {
          groupName: this.$t('users'),
          icon: 'mdi-account-multiple-outline',
          children: [
            {name: this.$t('users_list'), path: {name: 'users.index'}},
            {name: this.$t('departments'), path: {name: 'users.departments'}},
            {name: this.$t('job_titles'), path: {name: 'users.job-titles'}},
            {name: this.$t('roles'), path: {name: 'users.roles'}}
          ]
        },
        {
          groupName: this.$t('events'),
          icon: 'mdi-calendar-multiple',
          children: [
            {name: this.$t('calendar'), path: {name: 'events.calendar'}},
            {name: this.$t('statistics'), path: {name: 'events.statistics'}},
          ]
        },
        {
          groupName: this.$t('settlements'),
          icon: 'mdi-home-city-outline',
          children: [
            {name: this.$t('regions'), path: {name: 'settlements.regions'}},
            {name: this.$t('cities'), path: {name: 'settlements.cities'}},
          ]
        }
      ]
    }
  }
}
</script>

<style scoped>

</style>