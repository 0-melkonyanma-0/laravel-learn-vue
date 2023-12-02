import {mapGetters} from "vuex";

export default {
  computed: {
    ...mapGetters({
      permissions: 'auth/permissions'
    }),
  },
  methods: {
    $can: function (permissionsName) {
      return this.permissions.includes(permissionsName);
    },
  },
}
