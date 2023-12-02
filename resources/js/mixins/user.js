import axios from "axios";

export default {
  data: () => ({
    currentUser: {},
    editFormSelectionItems: [],
    loading: true,
  }),
  mounted() {
    axios.get('/api/users-edit-data').then((response) => {
      this.editFormSelectionItems = response.data;
      this.loading = false;
    })
  },
}
