<template>
  <v-container>
    <v-form @submit.prevent="false">
      <v-card v-if="loading" height="800">
        <v-card-text>
          <v-sheet
            color="lighten-4"
          >
            <v-skeleton-loader class="mx-auto" max-height="800" type="article"></v-skeleton-loader>
          </v-sheet>
        </v-card-text>
      </v-card>
      <card v-else :title="$t('edit')">
        <template
          v-slot:card-text
        >
          <v-text-field
            v-model="currentUser.name"
            :label="$t('name')"
            dense
            name="name"
            outlined
          >
          </v-text-field>
          <v-select
            v-model="currentUser.sex"
            :item-value="name"
            :items="editFormSelectionItems.genders"
            :label="$t('sex')"
            dense
            outlined
          >
            <template v-slot:item="{active, item, attrs, on}">
              {{ $t(item) }}
            </template>
            <template v-slot:selection="{active, item, attrs, on}">
              {{ $t(item) }}
            </template>
          </v-select>

          <v-select
            v-model="currentUser.role"
            :items="editFormSelectionItems.roles"
            :label="$t('role')"
            dense
            item-text="name"
            item-value="id"
            outlined
          >
            <template v-slot:item="{active, item, attrs, on}">
              {{ $t(item.name) }}
            </template>
            <template v-slot:selection="{active, item, attrs, on}">
              {{ $t(item.name) }}
            </template>
          </v-select>
          <v-select
            v-model="currentUser.department_id"
            :items="editFormSelectionItems.departments"
            :label="$t('department')"
            dense
            item-text="title"
            item-value="id"
            outlined
          ></v-select>
          <v-select
            v-model="currentUser.job_title_id"
            :items="editFormSelectionItems.job_titles"
            :label="$t('job_title')"
            dense
            item-text="title"
            item-value="id"
            outlined
          ></v-select>
          <v-text-field
            v-model="currentUser.email"
            :label="$t('email')"
            dense
            outlined
          >
          </v-text-field>

          <v-select
            v-model="currentUser.status"
            :items="editFormSelectionItems.statuses"
            :label="$t('status')"
            dense
            outlined
          >
            <template v-slot:item="{active, item, attrs, on}">
              {{ $t(item) }}
            </template>
            <template v-slot:selection="{active, item, attrs, on}">
              {{ $t(item) }}
            </template>
          </v-select>

          <v-divider class="mb-4"></v-divider>

          <v-text-field
            v-model="currentUser.password"
            :label="$t('password')"
            dense
            outlined></v-text-field>
          <v-text-field
            v-model="currentUser.password_confirmation"
            :label="$t('confirm_password')"
            dense
            outlined></v-text-field>
        </template>
        <template
          v-slot:card-actions
        >
          <v-spacer/>
          <v-btn
            color="success"
            outlined
            plain
            type="success"
            @click="updateUser(currentUser)"
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
import axios from "axios";
import {mapActions} from "vuex";

export default {
  components: {Card},
  data: () => ({
    currentUser: {},
    editFormSelectionItems: [],
    loading: true,
  }),
  methods: {
    ...mapActions({
      updateUser: 'users/updateUser',
    }),
  },
  computed: {},
  mounted() {
    axios.get(`/api/users/${this.$route.params.id}`).then((response) => {
      this.currentUser = {
        ...response.data[0],
        role: response.data[0].roles.length ? response.data[0].roles[0].id : null
      };

      delete this.currentUser.roles;
      delete this.currentUser.job_title;
      delete this.currentUser.department;
    });

    axios.get('/api/users-edit-data').then((response) => {
      this.editFormSelectionItems = response.data;
      this.loading = false;
    })
  },
}
</script>
