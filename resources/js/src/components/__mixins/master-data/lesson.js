import { mapActions, mapGetters } from "vuex";
import indexMixins from "@Components/__mixins/base/index";

const lessonMixins = {
    mixins: [
        indexMixins,
    ],
    data() {
        return {
            lessonCategories: [],
            headers: [
                {
                    text: "No.",
                    value: "number",
                    sortable: true,
                },
                {
                    text: "Nama Mata Pelajaran",
                    value: "name",
                    sortable: true,
                },
                {
                    text: "Akronim",
                    value: "acronym",
                    sortable: true,
                },
                {
                    text: "Kategori Pelajaran",
                    value: "lesson_category_name",
                    sortable: true,
                },
                {
                    text: "Aksi",
                    value: "actions",
                    align: "center",
                    sortable: false,
                },
            ],
            payload: {
                name: null,
                acronym: null,
                lesson_category_id: null,
            },
        };
    },

    methods: {
        ...mapActions({
            fetchLessonCategoriesData: "lessonCategory/fetchLessonCategory",
            fetchData: "lesson/fetchLesson",
            storeData: "lesson/storeLesson",
            updateData: "lesson/updateLesson",
            showData: "lesson/fetchDetailLesson",
            destroyData: "lesson/destroyLesson",
        }),
    },

    async created() {
        await this.fetchLessonCategoriesData().then((result) => {
            let data = result.data.data;
            this.lessonCategories = data;
        }).catch((err) => {
            console.error(err);
        });
    }
};

export default lessonMixins;
