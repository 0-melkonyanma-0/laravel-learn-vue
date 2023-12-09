<template>
  <v-container>
    <v-form @submit.prevent="false">
      <v-card v-if="loading" height="800">
        <v-card-text>
          <v-sheet
            color="lighten-4"
          >
            <v-skeleton-loader class="mx-auto" max-height="200" type="article"></v-skeleton-loader>
          </v-sheet>
        </v-card-text>
      </v-card>
      <card v-else :title="$t('create')">
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
                  :label="$t(`${permission.title}`)"
                  :true-value="1"
                  @change="addPermission(permission.id)"
                >
                </v-checkbox>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>

        </template>
        <template v-slot:card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="success"
            outlined
            plain
            type="success"
            @click="createRole(body)"
          >
            {{ $t('create') }}
          </v-btn>
        </template>
      </card>
    </v-form>
  </v-container>
</template>

<script>
import Card from "../../components/Card.vue";
import {mapActions, mapGetters, mapMutations} from "vuex";

export default {
  components: {Card},
  computed: {
    ...mapGetters({
      permissions: 'roles/permissions',
      loading: 'roles/loading',
      errors: 'roles/errors',
      responseStatus: 'app/responseStatus',
    }),
  },
  data: () => ({
    body: {
      title: '',
      permissions: [],
    },
    checked: false,
    errorMessage: '',
  }),
  metaInfo() {
    return {title: this.$t('create')}
  },
  methods: {
    ...mapActions({
      fetchRolesAndPermissions: 'roles/fetchRolesAndPermissions',
      createRole: 'roles/createRole',
    }),
    addPermission(permission) {
      if (this.checked && !this.body.permissions.includes(permission)) {
        this.body.permissions.push(permission)
      } else {
        this.body.permissions.splice(this.body.permissions.indexOf(permission), 1);
      }
      this.checked = false;
    }
  },
  mounted() {
    this.fetchRolesAndPermissions();
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
    responseStatus: {
      handler() {
        if (this.responseStatus === true) {
          this.$router.push({name: 'users.roles'});
          this.resetResponseStatus();
        }
      }
    }
  }
}
</script>
