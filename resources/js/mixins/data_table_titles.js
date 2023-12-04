export default {
  computed: {
    tableTitles() {
      return {
        footer: {
          rows_per_page: this.$t('rows_per_page'),
          of: this.$t('of_table')
        },
        no_data_text: this.$t('no_data_text'),
        loading_text: this.$t('loading_please_wait'),
      }
    }
  }
}
