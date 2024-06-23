<script>
export default {
  data() {
    return {
      days: [],
    }
  },
}
</script>

<template>
  <main>
    <card-component title="Jadwal Mata Pelajaran" icon="calendar-clock-outline">
      <v-container>
        <v-row style="max-width: 768px">
          <v-col cols="12" md="12">
            <v-text-field small label="Iterasi" required></v-text-field>
          </v-col>
          <v-col cols="12" md="6" class="d-flex align-center">
            <v-btn block elevation="2" color="primary">Proses</v-btn>
          </v-col>
          <v-col cols="12" md="6" class="d-flex align-center">
            <v-btn block elevation="2" color="success">Simpan</v-btn>
          </v-col>
        </v-row>
      </v-container>
    </card-component>
  </main>
</template>
