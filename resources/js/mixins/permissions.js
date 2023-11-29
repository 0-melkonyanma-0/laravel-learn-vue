export default {
  methods: {
    $can: function (permissionsName) {
      return Permissions.includes(permissionsName);
    },
  },
}
