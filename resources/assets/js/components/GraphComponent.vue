<template>
  <GChart
    :settings="{packages: ['bar']}"
    :data="chartData"
    :options="chartOptions"
    :createChart="(el, google) => new google.charts.Bar(el)"
  />
</template>

<script>
  import { GChart } from 'vue-google-charts'
  export default {
    mounted () {
      var events = $(this.$el).data('events')
      var months = $(this.$el).data('months')
      var participations = []

      for (var i=0; i < events.length; i++) {
        var eventDate = new Date(events[i].start_date)
        var eventMonth = eventDate.getMonth()
        if (participations[eventMonth] == undefined) {
          participations[eventMonth] = 1
        } else {
          participations[eventMonth]++
        }
      }

      var i = 0
      var month = new Date().getMonth() + 2
      while (i<=11) {
        this.chartData.push([months[month], participations[month], participations[month]])
        month = month == 11 ? 0 : ++month
        i++
      }
    },
    data () {
      return {
        chartData: [['', 'Participations', {role: 'annotation'}]],
        chartOptions: {
          chart: {
            title: 'Participations',
            subtitle: 'Participations sur une année',
          },
          legend: {
            position: 'none'
          },
        },
      }
    }
  }
</script>
