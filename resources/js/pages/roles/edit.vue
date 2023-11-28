<template>
  <v-container>
    <v-form @submit.prevent="false">
      <card :title="$t('edit')">
        <template v-slot:card-text>
          <v-text-field
            v-model="body.title"
            :error-messages="errorMessage"
            :label="$t('title')"
            dense
            name="name"
            outlined
            type="text"
          ></v-text-field>

          {{ body.permissions }}

          <v-divider/>

          <v-expansion-panels v-if="!loading">
            <v-expansion-panel
              v-for="(title,i) in permissions"
              :key="i"
            >
              <v-expansion-panel-header>
                {{ $t(title) }}
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <v-checkbox
                  v-for="(permission,i) in permissions[title]"
                  :key="i"
                  v-model="checked"
                  :label="$t(`${title}_${permission[0]}`)"
                  @change="addPermission(permission[1])"
                >
                </v-checkbox>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>
          <div v-else>
            <v-row>
              <v-progress-circular indeterminate></v-progress-circular>
            </v-row>
          </div>

          {{ $route.params.id }}

        </template>

        <template v-slot:card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="success"
            outlined
            plain
            type="success"
            @click="updateRole(body)"
          >
            {{ $t('editing') }}
          </v-btn>
        </template>
      </card>
    </v-form>
  </v-container>
</template>

<script>
import Card from "../../components/Card.vue";
import {mapActions, mapGetters} from "vuex";

export default {
  components: {Card},
  data: () => ({
    checked: false,
    errorMessage: '',
  }),
  mounted() {
    this.fetchPermissions();
  },
  watch: {
    errors: {
      handler() {
        try {
          this.errorMessage = this.errors[0].title[0];
        } catch (e) {
          this.errorMessage = '';
          this.title = '';
        }
      },
      deep: true,
    },
  },
  computed: {
    body() {
      return {
        id: this.$route.params.id,
        title: '',
        // title: this.permissions[this.$route.params.id].title,
        permissions: [],
      }
    },

    ...mapGetters({
      roles: 'roles/roles',
      permissions: 'roles/permissions',
      loading: 'roles/loading',
      errors: 'roles/errors',
    }),
  },
  methods: {
    ...mapActions({
      fetchPermissions: 'roles/fetchPermissions',
      createRole: 'roles/createRole',
      updateRole: 'roles/updateRole',
    }),
    addPermission(permission) {
      if (this.checked && !this.body.permissions.includes(permission)) {
        this.body.permissions.push(permission)
      } else {
        this.body.permissions.splice(this.body.permissions.indexOf(permission), 1);
      }
      this.checked = false;
    }
  }
}
</script>
