<template>
  <v-container
    fluid
  >
    <card :title="$t('statistics')">
      <template v-slot:card-text>
        <v-toolbar
          flat
        >
          <v-btn
            icon
            @click="fetchStatistics"
            width="40"
            height="40"
          >
            <v-icon>
              mdi-refresh
            </v-icon>
          </v-btn>
          <v-btn
            icon
            @click="dates = []"
            width="40"
            height="40"
          >
            <v-icon>
              mdi-close
            </v-icon>
          </v-btn>
          <v-spacer></v-spacer>
          <v-toolbar-title>
            {{ $t('statistics_done_tasks') }}
          </v-toolbar-title>
          <v-spacer></v-spacer>
          <div class="mt-10" style="width: 400px">
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
                  :label="$t('picker_menu')"
                  prepend-icon="mdi-calendar"
                  readonly
                  outlined
                  dense
                  height="40"
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>

              </template>
              <v-date-picker
                v-model="dates"
                :locale="locale"
                multiple
                no-title
                scrollable
                type="months"
              >
                <v-spacer></v-spacer>
                <v-btn
                  color="primary"
                  text
                  @click="menu = false"
                >
                  {{ $t('cancel') }}
                </v-btn>
                <v-btn
                  color="primary"
                  text
                  @click="fetchStatistics"
                >
                  {{ $t('choice') }}
                </v-btn>
              </v-date-picker>
            </v-menu>
          </div>
        </v-toolbar>
        <v-row>
          <v-col v-if="showChart" class="lg6">
            <apexchart ref="realtimeChartFirst" :options="chartOptions" :series="series" height="350" type="bar"/>
          </v-col>
          <v-col v-if="showChart" class="lg6">
            <apexchart ref="realtimeChartSecond" :options="chartOptions" :series="series" height="350" type="donut"/>
          </v-col>
        </v-row>
      </template>
    </card>
  </v-container>
</template>

<script>
import Card from "../../components/Card.vue";
import moment from "moment";
import {mapGetters} from "vuex";
import axios from "axios";

export default {
  components: {Card},
  data: () => ({
    loading: false,
    dates: [],
    series: [{
      data: []
    }],
    requestDates: {
      start: '',
      end: '',
    },
    menu: true,
    showChart: true,
    chartOptions: {
      chart: {
        height: 350
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          horizontal: false,
        }
      },
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: [],
      },
      noData: {
        text: 'No available data',
        align: 'center',
        verticalAlign: 'middle',
        offsetX: 0,
        offsetY: 0,
        style: {
          color: 'black',
          fontSize: '14px',
        }
      }
    },
  }),
  computed: {
    ...mapGetters({
      statistics: 'statistics/statistics',
      categories: 'statistics/categories',
      locale: 'lang/locale',
    })
  },
  watch: {
    dates: {
      handler() {
        if (this.dates.length > 2) {
          this.dates = [this.dates[0].toString(), this.dates[2].toString()];
        }

        this.processedData();
      }
    }
  },
  mounted() {
    this.showChart = true;
    let currentMonth = new Date();
    this.dates = [
      moment(currentMonth).format('YYYY-MM'),
      moment(currentMonth).format('YYYY-MM'),
    ];

    this.requestDates = {
      start: moment(currentMonth).startOf('month').format('YYYY-MM-DD'),
      end: moment(currentMonth).endOf('month').format('YYYY-MM-DD'),
    };

    this.fetchStatistics();
  },
  methods: {
    processedData() {
      try {
        let selectFirst = new Date(
          Number(this.dates[0].substring(0, 4)),
          Number(this.dates[0].substring(5, 7)) - 1
        );

        let selectSecond = new Date(
          Number(this.dates[1].substring(0, 4)),
          Number(this.dates[1].substring(5, 7)) - 1
        );
        if (moment(selectSecond).isBefore(moment(selectFirst))) {
          let temp = selectSecond;
          selectSecond = selectFirst;
          selectFirst = temp;
          this.dates = [this.dates[1], this.dates[0]];
        }

        this.requestDates = {
          start: moment(selectFirst).startOf('month').format('YYYY-MM-DD'),
          end: moment(selectSecond).endOf('month').format('YYYY-MM-DD'),
        }
      } catch (e) {
        console.log('[SOMETHING WENT WRONG]');
      }
    },
    fetchStatistics() {
      const loading = {
        noData: {
          text: this.$t('loading'),
        }
      };

      const noAvailable = {
        noData: {
          text: this.$t('no_data_text_period'),
        }
      };

      this.$refs.menu.save(this.dates);

      this.$refs.realtimeChartFirst.updateOptions(loading);
      this.$refs.realtimeChartSecond.updateOptions(loading);

      axios.get(`/api/statistics?start=${this.requestDates.start}&end=${this.requestDates.end}`)
        .then(({data}) => {
          let series = [];
          let labels = [];

          data.map((item) => {
            labels.push(Object.keys(item)[0]);
            series.push((Object.values(item)[0]));
          })

          this.$refs.realtimeChartFirst.updateSeries([{
            data: series,
          }]);
          this.$refs.realtimeChartFirst.updateOptions({
            xaxis: {
              categories: labels
            }
          });

          this.$refs.realtimeChartSecond.updateSeries([
            ...series,
          ]);
          this.$refs.realtimeChartSecond.updateOptions({
            labels: [...labels]
          });

          if (!this.series[0].data.length) {
            this.$refs.realtimeChartFirst.updateOptions(noAvailable);
            this.$refs.realtimeChartSecond.updateOptions(noAvailable);
          }
        });
    }
  }
}
</script>
