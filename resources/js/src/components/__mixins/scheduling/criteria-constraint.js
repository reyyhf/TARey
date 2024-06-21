import { mapActions } from "vuex";
import indexMixins from "@Components/__mixins/base/index";


const criteriaConstraintMixins = {
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
                    text: "Kriteria Constraint",
                    value: "type",
                    sortable: true,
                },
                {
                    text: "Constraint",
                    value: "constraint",
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
                type: null,
                constraint: null,
                is_dynamic: false,
                max_teaching_hours: null,
                max_subject_hours: null
            },
        };
    },
    methods: {
        ...mapActions({
            fetchData: "criteriaConstraint/fetchCriteriaConstraint",
        })
    }

}

export default criteriaConstraintMixins;
