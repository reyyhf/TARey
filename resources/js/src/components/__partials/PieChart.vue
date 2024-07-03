<script>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Pie } from 'vue-chartjs'

ChartJS.register(ArcElement, Tooltip, Legend)

export default {
  name: 'PieChart',
  components: { Pie },
  props:{
    width: {
      type: Number,
      default: 300
    },
    height: {
      type: Number,
      default: 270
    },
  }
}
</script>

<template>
    <Pie :width="width" :height="height" v-bind="[$props,$attrs]" v-on="$listeners"
    />
</template>
