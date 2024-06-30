<script>
import CurriculumMixins from '@Components/__mixins/master-data/curriculum';

export default {
    name: 'CurriculumIndex',
    mixins: [
        CurriculumMixins,
    ],
}
</script>

<template>
    <div class="lesson-category">
        <card-component title="Struktur Kurikulum" icon="notebook-multiple" :withButtonAction="true"
            :buttonAction="buttonAction">

            <v-data-table :headers="[]" :items="results" class="elevation-1">
        <template v-slot:header>
          <thead>
            <tr>
              <th rowspan="2" colspan="1">No</th>
              <th rowspan="2" colspan="1">Nama Mata Pelajaran</th>
              <th
                rowspan="1"
                colspan="6"
                style="text-align: center"
                align="center"
              >
                Jadwal Minggu / Jam
              </th>
              <th
                rowspan="2"
                colspan="1"
                style="text-align: center"
                align="center"
              >
                Aksi
              </th>
            </tr>
            <tr>
              <td colspan="1" rowspan="1">X IPA</td>
              <td colspan="1" rowspan="1">X IPS</td>
              <td colspan="1" rowspan="1">XI IPA</td>
              <td colspan="1" rowspan="1">XI IPS</td>
              <td colspan="1" rowspan="1">XII IPA</td>
              <td colspan="1" rowspan="1">XII IPS</td>
            </tr>
          </thead>
        </template>
        <template v-slot:body="{ items }">
          <tbody>
            <tr v-for="(curriculumLesson, index) in items" :key="curriculumLesson.id">
              <td>
                {{ index + 1 }}
              </td>
              <td>
                {{ curriculumLesson.lesson_name }}
              </td>
              <td>
                {{
                    curriculumLesson.curricular.find((classroom) =>
                    classroom.classroom_label.startsWith('X IPA')
                    )?.maximum_hours_per_week || ''
                }}
              </td>
              <td>
                {{
                  curriculumLesson.curricular.find((classroom) =>
                    classroom.classroom_label.startsWith('X IPS')
                    )?.maximum_hours_per_week || ''
                }}
              </td>
              <td>
                {{
                  curriculumLesson.curricular.find((classroom) =>
                    classroom.classroom_label.startsWith('XI IPA')
                    )?.maximum_hours_per_week || ''
                }}
              </td>
              <td>
                {{
                 curriculumLesson.curricular.find((classroom) =>
                    classroom.classroom_label.startsWith('XI IPS')
                    )?.maximum_hours_per_week || ''
                }}
              </td>
              <td>
                {{
                  curriculumLesson.curricular.find((classroom) =>
                    classroom.classroom_label.startsWith('XII IPA')
                    )?.maximum_hours_per_week || ''
                }}
              </td>
              <td>
                {{
                  curriculumLesson.curricular.find((classroom) =>
                    classroom.classroom_label.startsWith('XII IPS')
                    )?.maximum_hours_per_week || ''
                }}
              </td>
              <td>
                <v-container class="d-flex justify-center" style="gap: 12px">

                  <v-btn outlined v-on:click="view(curriculumLesson.id)" color="primary">
                    <v-icon left> mdi-pencil </v-icon>
                    Edit
                  </v-btn>
                  <v-btn
                    outlined
                    v-on:click="showDestroyModal(curriculumLesson.id)"
                    color="error"
                  >
                    <v-icon left> mdi-delete </v-icon>
                    Hapus
                  </v-btn>
                </v-container>
              </td>
            </tr>
          </tbody>
        </template>
      </v-data-table>
        </card-component>

        <update-or-create-component :closeAction="closeModal" :title="`${updateOrCreateTitle} Data`" v-model="showModal"
            :width="width">
            <template v-slot:form>
                <form-component ref="form" :methodHandler="submit" buttonSubmitText="Simpan">
                    <auto-complete-component v-model="payload.lesson_id" icon="book-outline" label="Nama Mata Pelajaran"
                        itemName="name" rules="required" :originData="lessons">
                    </auto-complete-component>

                    <input-component v-model="lessonData.acronym" icon="tag-outline" label="Akronim" :disabled="true">
                    </input-component>

                    <input-component v-model="lessonData.lesson_category_name" icon="book-search"
                        label="Nama Kategori Pelajaran" :disabled="true">
                    </input-component>

                    <v-row v-if="payload.curricular.length > 0" v-for="curriculum, index in payload.curricular"
                        :key="index">
                        <v-col cols="6">
                            <auto-complete-component v-model="curriculum.classroom_label" icon="book-outline"
                                label="Kelompok Kelas" itemName="label" rules="required" :originData="classroomLabels">
                            </auto-complete-component>
                        </v-col>

                        <v-col cols="6">
                            <input-component v-model="curriculum.maximum_hours_per_week" icon="clock-outline"
                                label="Maksimal Jumlah Jam Perminggu" type="number"
                                rules="required|integer|min_value:1">
                            </input-component>
                        </v-col>

                        <v-container>
                            <v-btn block color="error" @click="removeCurriculumData(index)">
                                <v-icon left> mdi-delete </v-icon>
                                Hapus Data
                            </v-btn>
                        </v-container>
                    </v-row>

                    <v-btn @click="addCurriculumData" class="mt-6" color="primary" block>
                        <v-icon left> mdi-plus </v-icon>
                        Tambah Kelompok Kelas
                    </v-btn>
                </form-component>
            </template>
        </update-or-create-component>

        <dialog-component v-on:confirm-action="destroy" confirmText="Hapus" title="Hapus Data" v-model="dialog"
            v-on:close-dialog="dialog = false">
            <template v-slot:message>
                <v-container>
                    <p class="text-center font-weight-bold">
                        Apakah anda yakin akan menghapus data ini ?
                    </p>
                </v-container>
            </template>
        </dialog-component>

        <alert-component ref="alert"></alert-component>
    </div>
</template>
