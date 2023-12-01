<template>
  <v-container>
    <v-form @submit.prevent="updateRole(body)">
      <v-card v-if="loading" height="800">
        <v-card-text>
          <v-sheet
            color="lighten-4"
          >
            <v-skeleton-loader class="mx-auto" max-height="200" type="article"></v-skeleton-loader>
          </v-sheet>
        </v-card-text>
      </v-card>
      <card v-else :title="$t('edit')">
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
              v-for="(title,i) in processedPermissions"
              :key="i"
            >
              <v-expansion-panel-header>
                {{ $t(title) }}
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <v-checkbox
                  v-for="(permission,i) in processedPermissions[title]"
                  :key="i"
                  v-model="permission.checked"
                  :label="$t(`${permission.title}`)"
                  :true-value="1"
                  @change="addPermission(permission.id, permission.checked)"
                >
                </v-checkbox>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>
          <div v-else>
            <v-layout align-center column fill-height justify-center>
              <v-flex align-center row>
                <v-progress-circular :size="20" color="success" indeterminate>
                </v-progress-circular>
              </v-flex>
            </v-layout>
          </div>
        </template>

        <template v-slot:card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="success"
            outlined
            plain
            type="submit"
          >
            {{ $t('update') }}
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
    errorMessage: '',
    checked: false,
  }),
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
  },
  computed: {
    body() {
      try {
        let role = this.roles.filter((el) => Number(el.id) === Number(this.$route.params.id))[0];

        return {
          id: role.id,
          title: role.name,
          permissions: role.permissions.length ? role.permissions : [],
        };
      } catch (e) {
        console.log('[wait]');
      }
    },
    processedPermissions() {
      let processedPermissions = [];

      this.permissions.map((name, i) => {
        processedPermissions.push(name);
        processedPermissions[name] = []

        this.permissions[name].map((item) => {
          if (!this.body.permissions.includes(item.id)) {
            processedPermissions[name].push({...item, checked: false});
          } else {
            processedPermissions[name].push({...item, checked: true});
          }
        })
      });

      return processedPermissions;
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
      fetchRolesAndPermissions: 'roles/fetchRolesAndPermissions',
      createRole: 'roles/createRole',
      updateRole: 'roles/updateRole',
    }),
    addPermission(permission, checked) {
      if (checked && !this.body.permissions.includes(permission)) {
        this.body.permissions.push(permission)
        checked = true;
      } else {
        this.body.permissions.splice(this.body.permissions.indexOf(permission), 1);
        checked = false;
      }
    }
  }
}
</script>
