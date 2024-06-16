<script>
import userAccessRoleMixins from '@Components/__mixins/master-data/user-role-access';

export default {
    name: 'UserRoleAccessIndex',
    mixins: [
        userAccessRoleMixins,
    ],
}
</script>

<template>
    <div class="user-role-access">
        <card-component title="Hak Akses Pengguna" icon="account-key">
            <table-component :headerData="headers" :result="userRoleAccesses" :withLoading="isLoading">

            </table-component>
        </card-component>
    </div>
</template>
