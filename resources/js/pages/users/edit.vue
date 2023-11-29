<template>
  <v-container>
    <v-form @submit.prevent="false">
      <card :title="$t('edit')">
        <template
          v-slot:card-text
        >
          <v-text-field :label="$t('name')" dense name="name" outlined></v-text-field>
          <v-select :label="$t('sex')" dense name="" outlined></v-select>
          <v-select :label="$t('role')" dense name="" outlined></v-select>
          <v-select :label="$t('department')" dense name="" outlined></v-select>
          <v-select :label="$t('job_title')" dense name="" outlined></v-select>
          <v-text-field :label="$t('email')" dense name="" outlined></v-text-field>
          <v-text-field :label="$t('password')" dense name="" outlined></v-text-field>
          <v-text-field :label="$t('confirm_password')" dense name="" outlined></v-text-field>
          <v-text-field :label="$t('status')" dense name="" outlined></v-text-field>
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
            @click="editUser"
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

export default {
  components: {Card},
  computed: {
    body() {
      return {
        id: this.$route.params.id,
        name: '',
        status: '',
        sex: '',
        department_id: '',
        job_title_id: '',
        email: '',
        password: '',
        password_confirmation: '',
      }
    }
  },
}
</script>
