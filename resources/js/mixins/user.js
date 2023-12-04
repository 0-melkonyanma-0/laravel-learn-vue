import axios from "axios";
import {mapGetters, mapMutations} from "vuex";

export default {
  data: () => ({
    currentUser: {},
    editFormSelectionItems: [],
    loading: true,
  }),
  computed: {
    ...mapGetters({
      errors: 'users/errors'
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
      clearErrors: 'users/clearErrors'
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
