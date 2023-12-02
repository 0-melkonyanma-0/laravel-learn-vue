export default {
  data: () => ({
    search: ''
  }),
  computed: {
    settlementsHeader() {
      let header = [
        {text: this.$t('title'), value: 'title', sortable: true}
      ];

      if (this.$can('edit settlements') || this.$can('delete settlements')) {
        header.push({text: this.$t('actions'), value: 'actions', align: 'end', sortable: false});
      }

      return header;
    }
  }
}
