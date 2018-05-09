<template>
    <!-- The Modal -->
    <div class="modal fade app-modal" id="app-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">{{ title }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <slot></slot>
                </div>
        
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" @click="$emit('confirm')" class="btn btn-success" data-dismiss="modal">OK</button>
                    <button type="button" @click="$emit('close')" class="btn btn-danger" data-dismiss="modal">Close</button>
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
    props: [
        'title'
    ],
}
</script>
