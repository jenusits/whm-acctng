<template>
    <!-- The Modal -->
    <div class="modal fade app-modal" v-bind:id="id" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">{{ title }}</h4>
                <button type="button" @click="$emit('close')" class="close" data-dismiss="modal">&times;</button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <slot></slot>
                </div>
        
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" @click="$emit('confirm')" class="btn btn-success" data-dismiss="modal">{{ confirmText }}</button>
                    <button type="button" @click="$emit('close')" class="btn btn-danger" data-dismiss="modal">{{ cancelText }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
module.exports = {
    data() {
        return {
        }
    },
    props: {
        'title': '',
        'id': '',
        'confirmText': {
            default: 'OK',
        },
        'cancelText': {
            default: 'Close'
        }
    },
}
</script>
