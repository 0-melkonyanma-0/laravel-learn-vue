import axios from "axios";

export default {
  data: () => ({
    search: '',
    dialogOn: false,
    body: {
      excel_file: null
    },
  }),
  watch: {
    dialogOn() {
      this.body.excel_file = null;
    }
  },
  methods: {
    exportCitiesByRegion() {
      axios(
        {
          url: '/api/export/cities-by-regions', method: 'GET', responseType: 'blob'
        }
      ).then(({data}) => {
        const href = URL.createObjectURL(data);

        const link = document.createElement('a');
        link.href = href;
        link.setAttribute('download', `${this.$t('cities')}_${this.$t('regions')}.xlsx`);
        link.click();
      }).catch(() => {
        this.$store.commit('app/SET_RESPONSE_MESSAGE', {
          message: this.$t('err_export'),
          color: 'red',
          status: 'err'
        }, {root: true});
      });
    },
  },
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
