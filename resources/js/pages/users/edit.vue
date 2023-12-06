<template>
  <div>
    <v-container>
      <v-card>
        <v-tabs background-color="cyan">
          <v-tab class="white--text">
            {{ $t('edit') }}
          </v-tab>
          <v-tab v-if="activityLog.length !== 0" class="white--text">
            {{ $t('activity_log') }}
          </v-tab>
          <v-tab-item>
            <EditUser :current-user="user"/>
          </v-tab-item>
          <v-tab-item v-if="activityLog.length !== 0" @click="loading === true">
            <ActivityLog :activity-log="activityLog"/>
          </v-tab-item>
        </v-tabs>
      </v-card>
    </v-container>
  </div>
</template>

<script>
import Card from "../../components/Card.vue";
import EditUser from "./edit/EditUser.vue";
import ActivityLog from "./edit/ActivityLog.vue";
import axios from "axios";

export default {
  computed: {
    loading() {
      return loading;
    }
  },
  components: {ActivityLog, EditUser, Card},
  data: () => ({
    user: null,
    activityLog: null,
  }),
  mounted() {
    axios.get(`/api/users/${this.$route.params.id}`).then((response) => {
      this.user = {
        ...response.data.user[0],
        role: response.data.user[0].roles.length ? response.data.user[0].roles[0].id : null
      };

      delete this.user.roles;
      delete this.user.job_title;
      delete this.user.department;

      this.activityLog = response.data.activity_log;
    });
  },
}
</script>
