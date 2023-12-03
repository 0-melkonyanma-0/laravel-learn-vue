import axios from "axios";

export default {
  data: () => ({
    search: '',
    dialogOn: false,
    body: {
      excel_file: null
    },
  }),
  methods: {
    exportCitiesByRegion() {
      axios(
        {
          url: '/api/export/cities-by-regions', method: 'GET', responseType: 'blob'
        }
      ).then((response) => {
        const href = URL.createObjectURL(response.data);
        console.log(response.data);

        const link = document.createElement('a');
        link.href = href;
        link.setAttribute('download', `${this.$t('cities')}_${this.$t('regions')}.xlsx`);
        link.click();
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
