<script>
import CriteriaConstraintMixins from '@Components/__mixins/scheduling/criteria-constraint';

export default {
    name: 'CriteriaConstraintIndex',
    mixins: [
        CriteriaConstraintMixins,
    ],
}
</script>

<template>
    <div class="criteria-constraint">
        <card-component class="mt-5" title="Simpan Constraint Dinamis">
            <form-component ref="form" :methodHandler="submit" buttonSubmitText="Simpan Data">
                    <div class="d-flex">
                        <input-component v-model="payload.max_teaching_hours" type="number" class="mr-3 flex-grow-1" label="jam mengajar di kelas yang sama">
                        </input-component>
                        <input-component v-model="payload.max_subject_hours" type="number" class="flex-grow-1" label="jam maksimal matpel berurutan perhari">
                        </input-component>
                    </div>
                </form-component>
        </card-component>
        <card-component class="mt-5" title="Kriteria Constraint" icon="cogs">
            <table-component v-on:edit-data="view" v-on:destroy-data="showDestroyModal" :withLoading="isLoading"
                    :headerData="headers" :result="results" :isSearchHidden="true">
            </table-component>
        </card-component>

        <alert-component ref="alert"></alert-component>
    </div>
</template>
