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

                  :label="$t(`${title}_${permission[0]}`)"
                  :true-value="1"
                  @change="addPermission(permission[1])"
                  v-model="checked"
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
          permissions: role.permissions,
        }
      } catch (e) {}
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
    addPermission(permission) {
      console.log(permission);

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
