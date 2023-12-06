import {mapActions, mapGetters, mapMutations} from "vuex";

export default {
  computed: {
    ...mapGetters({
      users: 'users/users',
      loading: 'users/loading',
      request_done: 'events/request_done',
      errors: 'events/errors',
    }),
    proccessedErrors() {
      if (Array.isArray(this.errors)) {
        return this.errors[0];
      }

      return this.errors;
    }
  },
  mounted() {
    if (!this.users.length) {
      this.fetchUsers();
    }
  },
  methods: {
    ...mapActions({
      fetchUsers: 'users/fetchUsers',
    }),
    ...mapMutations({
      resetRequestStatus: 'events/resetRequestStatus',
      clearErrors: 'events/clearErrors',
    }),
  },
  watch: {
    request_done: {
      handler() {
        if (this.request_done === true) {
          this.dialogOn = false;
          this.resetRequestStatus();
        }
      }
    },
    dialogOn: {
      handler() {
        if(!this.dialogOn) {
          this.clearErrors();
        }
      }
    }
  }
}
