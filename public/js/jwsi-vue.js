Vue.component('b-modal', {
    props: [
        'title'
    ],
    template: `
        <div class="modal fade" id="app-modal">
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
    `,
})


var root = new Vue({
    el: '#root',
    data: {
        button: {

        }
    },
});