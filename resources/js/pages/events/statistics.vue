<template>
  <v-container
    fluid
  >
    {{ dates }}
    <card :title="$t('statistics')">
      <template v-slot:card-text>
        <v-toolbar flat>
          <v-spacer></v-spacer>
          <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            :return-value.sync="dates"
            max-width="290px"
            min-width="auto"
            offset-y
            transition="scale-transition"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="dates"
                label="Picker in menu"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="dates"
              :type="type"
              multiple
              no-title
              scrollable
            >
              <v-spacer></v-spacer>
              <v-btn
                color="primary"
                text
                @click="menu = false"
              >
                Cancel
              </v-btn>
              <v-btn
                color="primary"
                text
                @click="fetchStatistics"
              >
                OK
              </v-btn>
            </v-date-picker>
          </v-menu>
        </v-toolbar>
        <v-row>
          <v-col v-if="showChart" class="md6">
            <apexchart :options="chartOptions" :series="series" height="350" type="area"></apexchart>
          </v-col>
        </v-row>
      </template>
    </card>
  </v-container>
</template>

<script>
import Card from "../../components/Card.vue";
import moment from "moment";
import axios from "axios";

export default {
  components: {Card},
  data() {
    return {
      dates: [],
      requestDates: {
        start: '',
        end: '',
      },
      type: 'year',
      menu: true,
      showChart: true,
      series: [{
        name: 'series2',
        data: [11, 32, 45, 32, 34, 52, 41]
      }],
      chartOptions: {
        series: [{
          name: 'Website Blog',
          type: 'column',
          data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
        }, {
          name: 'Social Media',
          type: 'line',
          data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
        }],
        chart: {
          height: 350,
          type: 'line',
        },
        stroke: {
          width: [0, 4]
        },
        title: {
          text: 'Traffic Sources'
        },
        dataLabels: {
          enabled: true,
          enabledOnSeries: [1]
        },
        labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
        xaxis: {
          type: 'datetime'
        },
        yaxis: [{
          title: {
            text: 'Website Blog',
          },

        }, {
          opposite: true,
          title: {
            text: 'Social Media'
          }
        }]
      }
    }
  },
  watch: {
    dates: {
      handler() {
        if (this.dates.length > 2) {
          this.dates.shift();
        } else {
          let month = new Date(
            Number(this.dates[0].substring(0, 4)),
            Number(this.dates[0].substring(5, 7)) - 1
          );

          this.dates = [this.dates[0], this.dates[0]];

          this.requestDates = {
            start: moment(month).startOf('month').format('YYYY-MM-DD'),
            end: moment(month).endOf('month').format('YYYY-MM-DD'),
          }
        }
      }
    }
  },
  mounted() {
    this.showChart = true
  },
  methods: {
    fetchStatistics() {
      this.$refs.menu.save(this.dates);

      axios.get(`/api/statistics?start=${this.requestDates.start}&end=${this.requestDates.end}`).then((response) => {
        console.log(response.data);
      });
    }
  }
}
</script>
