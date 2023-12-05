import axios from "axios";
import {mapGetters, mapMutations} from "vuex";

export default {
  data: () => ({
    currentUser: {},
    editFormSelectionItems: [],
    loading: true,
    alert: false,
  }),
  watch: {
    request_done: {
      handler() {
        if(this.request_done === true) {
          this.$router.push({name: 'users.index'});
          this.resetRequestStatus();
          this.alert = true;
        }
      }
    }
  },
  computed: {
    ...mapGetters({
      errors: 'users/errors',
      request_done: 'users/request_done',
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
