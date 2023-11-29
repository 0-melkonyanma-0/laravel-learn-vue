<template>
  <v-container>
    <v-form @submit.prevent="false">
      <card :title="$t('create')">
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
import {mapActions, mapGetters} from "vuex";

export default {
  components: {Card},
  data: () => ({
    body: {
      title: '',
      permissions: [],
    },
    checked: false,
    errorMessage: '',
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
    ...mapGetters({
      permissions: 'roles/permissions',
      loading: 'roles/loading',
      errors: 'roles/errors',
    }),
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
  }
}
</script>
