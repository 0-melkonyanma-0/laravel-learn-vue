import axios from "axios";
import {mapGetters, mapMutations} from "vuex";

export default {
  computed: {
    ...mapGetters({
      errors: 'users/errors',
      responseStatus: 'app/responseStatus',
    }),
    proccessedErrors() {
      if (Array.isArray(this.errors)) {
        return this.errors[0];
      }

      return this.errors;
    }
  },
  data: () => ({
    currentUser: {},
    editFormSelectionItems: [],
    loading: true,
  }),
  methods: {
    ...mapMutations({
      clearErrors: 'users/clearErrors',
    })
  },
  mounted() {
    this.clearErrors();

    axios.get('/api/users-edit-data').then((response) => {
      this.editFormSelectionItems = response.data;
      this.loading = false;
    })
  },
  watch: {
    responseStatus: {
      handler() {
        if (this.responseStatus === true) {
          this.$router.push({name: 'users.index'});
          this.resetRequestStatus();
        }
      }
    },
  },
}
