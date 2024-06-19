<script>
export default {
  name: 'TableComponent',
  data: () => ({
    search: '',
    emptyDataText: 'Data tidak ditemukan',
  }),
  props: {
    itemKey: String,
    headerData: Array,
    icon: String,
    withLoading: Boolean,
    withViewData: Boolean,
    withDetail: Boolean,
    withDestroyData: {
      type: Boolean,
      default: true,
    },
    result: Array,
    editData: Function,
    destroyData: Function,
    viewData: Function,
    withCustomFilter: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    hideFooterAction() {
      if (this.result.length <= 10) return true
      return false
    },
  },
    name: 'TableComponent',
    data: () => ({
        search: '',
        emptyDataText: 'Data tidak ditemukan',
    }),
    props: {
        itemKey: String,
        headerData: Array,
        icon: String,
        withLoading: Boolean,
        withViewData: Boolean,
        withDestroyData: {
            type: Boolean,
            default: true,
        },
        result: Array,
        editData: Function,
        destroyData: Function,
        viewData: Function,
        withCustomFilter: {
            type: Boolean,
            default: false
        },
        isSearchHidden: {
            type: Boolean,
            default : false
        }
    },
    computed: {
        hideFooterAction() {
            if (this.result.length <= 10) return true;
            return false;
        }
    }
}
</script>

<template>
  <v-data-table
    class="elevation-1 ma-3 pb-3"
    :item-key="itemKey"
    :search="search"
    :headers="headerData"
    :items="result"
    :hide-default-footer="hideFooterAction"
    :loading="withLoading"
    :no-data-text="emptyDataText"
    :no-results-text="emptyDataText"
  >
    <template v-slot:top>
      <v-row>
        <v-col cols="6">
          <v-text-field
            outlined
            dense
            v-model="search"
            label="Cari Data"
            class="mx-4 pt-4" :class="{ 'd-none': isSearchHidden }"
          ></v-text-field>
        </v-col>

        <v-col cols="6" v-if="withCustomFilter">
          <div class="mx-4 pt-1">
            <slot name="custom-filter"></slot>
          </div>
        </v-col>
      </v-row>
    </template>

    <template v-slot:item.number="{ item, index }">
      {{ index + 1 }}
    </template>

    <template v-slot:item.curricular="{ item }">
      <div
        class="d-grid my-2"
        v-for="curriculum in item.curricular"
        :key="curriculum.lesson_name"
      >
        <v-chip color="info">
          {{ curriculum.classroom_label }}
        </v-chip>

        <v-chip class="mx-3" color="success">
          Maksimal Jam Per Minggu :
          {{ curriculum.maximum_hours_per_week }}
        </v-chip>
      </div>
    </template>

    <template v-slot:item.acronym="{ item }">
      <span class="font-weight-bold">[{{ item.acronym }}]</span>
    </template>

    <template v-slot:item.is_break_hour="{ item }">
      <v-chip small :color="item.is_break_hour ? 'success' : 'info'" dark>
        {{ item.is_break_hour ? 'Jam Istirahat' : 'Jam Pelajaran' }}
      </v-chip>
    </template>

    <template v-slot:item.is_active="{ item }">
      <v-chip small :color="item.is_active ? 'success' : 'error'" dark>
        {{ item.is_active ? 'Aktif' : 'Tidak Aktif' }}
      </v-chip>
    </template>

    <template v-slot:item.user_activation_status="{ item }">
      <v-chip
        small
        :color="item.user_activation_status === 'Aktif' ? 'success' : 'error'"
        dark
      >
        {{ item.user_activation_status }}
      </v-chip>
    </template>

    <template v-slot:item.semester_year="{ item }">
      <span
        >{{ item.semester.started_year }} - {{ item.semester.ended_year }}</span
      >
    </template>

    <template v-slot:item.actions="{ item }">
      <v-container class="d-flex justify-center">
        <v-btn
          v-if="withViewData"
          outlined
          v-on:click="$emit('view-data', item.id)"
          color="info"
        >
          <v-icon left> mdi-eye </v-icon>
          Lihat
        </v-btn>
        <v-btn
          v-if="withDetail"
          outlined
          color="info"
          :to="{ name: `detail-${$route.name}`, params: { id: item.id } }"
        >
          <v-icon left> mdi-eye </v-icon>
          Detail
        </v-btn>
        <v-btn
          outlined
          v-on:click="$emit('edit-data', item.id)"
          color="primary"
          class="mx-3"
        >
          <v-icon left> mdi-pencil </v-icon>
          Edit
        </v-btn>
        <v-btn
          outlined
          v-if="withDestroyData"
          v-on:click="$emit('destroy-data', item.id)"
          color="error"
        >
          <v-icon left> mdi-delete </v-icon>
          Hapus
        </v-btn>
      </v-container>
    </template>
  </v-data-table>
</template>
