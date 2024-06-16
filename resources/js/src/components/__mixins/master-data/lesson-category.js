import { mapActions } from "vuex";
import indexMixins from "@Components/__mixins/base/index";

const lessonCategoryMixins = {
    mixins: [
        indexMixins,
    ],
    data() {
        return {
            headers: [
                {
                    text: "No.",
                    value: "number",
                    sortable: true,
                },
                {
                    text: "Nama Kategori Pelajaran",
                    value: "name",
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
                name: null
            },
        };
    },

    methods: {
        ...mapActions({
            fetchData: "lessonCategory/fetchLessonCategory",
            storeData: "lessonCategory/storeLessonCategory",
            updateData: "lessonCategory/updateLessonCategory",
            showData: "lessonCategory/fetchDetailLessonCategory",
            destroyData: "lessonCategory/destroyLessonCategory",
        }),
    },
};

export default lessonCategoryMixins;
