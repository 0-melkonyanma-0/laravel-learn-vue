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
      <card v-else :title="$t('create')">
        <template
          v-slot:card-text
        >
          <v-text-field
            v-model="currentUser.name"
            :label="$t('name')"
            :error-messages="proccessedErrors.name"
            dense
            outlined
          >
          </v-text-field>
          <v-select
            v-model="currentUser.sex"
            :item-value="name"
            :items="editFormSelectionItems.genders"
            :label="$t('sex')"
            :error-messages="proccessedErrors.sex"
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
            :error-messages="proccessedErrors.role"
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
            :error-messages="proccessedErrors.department_id"
            dense
            item-text="title"
            item-value="id"
            outlined
          ></v-select>
          <v-select
            v-model="currentUser.job_title_id"
            :items="editFormSelectionItems.job_titles"
            :label="$t('job_title')"
            :error-messages="proccessedErrors.job_title_id"
            dense
            item-text="title"
            item-value="id"
            outlined
          ></v-select>
          <v-text-field
            v-model="currentUser.email"
            :error-messages="proccessedErrors.email"
            :label="$t('email')"
            dense
            outlined
          >
          </v-text-field>

          <v-select
            v-model="currentUser.status"
            :items="editFormSelectionItems.statuses"
            :label="$t('status')"
            :error-messages="proccessedErrors.status"
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

          <v-text-field
            v-model="currentUser.password"
            :label="$t('password')"
            dense
            outlined
            :error-messages="proccessedErrors.password"
            type="password"
          ></v-text-field>
          <v-text-field
            v-model="currentUser.password_confirmation"
            :label="$t('confirm_password')"
            dense
            outlined
            type="password"
          ></v-text-field>
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
            @click="createUser(currentUser)"
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
import {mapActions} from "vuex";
import user from "../../mixins/user";

export default {
  components: {Card},
  mixins: [user],
  methods: {
    ...mapActions({
      createUser: 'users/createUser',
    }),
  },
  metaInfo() {
    return {title: this.$t('create')}
  },
}
</script>
