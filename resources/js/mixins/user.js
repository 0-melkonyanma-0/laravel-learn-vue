import axios from "axios";
import {mapGetters, mapMutations} from "vuex";

export default {
  data: () => ({
    currentUser: {},
    editFormSelectionItems: [],
    loading: true,
  }),
  watch: {
    request_done: {
      handler() {
        if(this.request_done === true) {
          this.$router.push({name: 'users.index'});
          this.resetRequestStatus();
        }
      }
    }
  },
  computed: {
    ...mapGetters({
      errors: 'users/errors',
      request_done: 'users/request_done',
      success_message_response: 'users/success_message_response',
    }),
    proccessedErrors() {
      if (Array.isArray(this.errors)) {
        return this.errors[0];
      }

      return this.errors;
    }
  },
  methods: {
    ...mapMutations({
      clearErrors: 'users/clearErrors',
      resetRequestStatus: 'users/resetRequestStatus',
    })
  },
  mounted() {
    this.clearErrors();

    axios.get('/api/users-edit-data').then((response) => {
      this.editFormSelectionItems = response.data;
      this.loading = false;
    })
  },
}
