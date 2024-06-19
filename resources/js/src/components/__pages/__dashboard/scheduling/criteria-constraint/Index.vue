<script>
import CriteriaConstraintMixins from '@Components/__mixins/scheduling-data/criteria-constraint';

export default {
    name: 'CriteriaConstraintIndex',
    mixins: [
        CriteriaConstraintMixins,
    ],
}
</script>

<template>
    <div class="criteria-constraint">
        <card-component>
            <form-component methodHandler="PUT" buttonSubmitText="Simpan Data">
                <div class="d-flex">
                    <input-component class="mr-3 flex-grow-1" label="jam mengajar di kelas yang sama">
                    </input-component>
                    <input-component class="flex-grow-1" label="jam maksimal matpel berurutan perhari">
                    </input-component>
                </div>
            </form-component>
        </card-component>

        <card-component class="mt-5" title="Kriteria Constraint" icon="cogs" >
            <table-component v-on:edit-data="view" v-on:destroy-data="showDestroyModal" :withLoading="isLoading"
                    :headerData="headers" :result="results" isSearchHidden="true">
            </table-component>
        </card-component>
    </div>
</template>
