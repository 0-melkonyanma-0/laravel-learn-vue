// import {mapActions, mapGetters} from "vuex";
//
// export default {
//   computed: {
//     proccessedErrors() {
//       if (Array.isArray(this.errors)) {
//         return this.errors[0];
//       }
//
//       return this.errors;
//     },
//     ...mapGetters({
//       users: 'users/users',
//       errors: 'events/errors'
//     })
//   },
//   mounted() {
//     this.fetchUsers();
//   },
//   methods: {
//     ...mapActions({
//       createEvent: 'events/createEvent',
//       fetchUsers: 'users/fetchUsers',
//     })
//   }
// }

import {mapActions, mapGetters} from "vuex";

export default {
  computed: {
    ...mapGetters({
      users: 'users/users',
      loading: 'users/loading',
      loadingEvents: 'events/loading',
      errors: 'events/errors',
    }),
  },
  mounted() {
    if (!this.users.length){
      this.fetchUsers();
    }
  },
  methods: {
    ...mapActions({
      fetchUsers: 'users/fetchUsers',
    }),
  }
}
