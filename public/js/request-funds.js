var i = 0;

var multi = new Vue({
    el: '#multi',
    data: {
        rows: [
        ],
        submitted: false,
    },
    mounted() {
        while (i < JSWSI.getParamsByName('multi')) {
            this.addNewRow();
        }
    },
    computed: {
        errors: function() {
            for (var key in this.rows) {
                if (! this.rows[key].particulars) return true
            }
            for (var key in this.rows) {
                if (! this.rows[key].amount) return true
            }
            for (var key in this.rows) {
                if (! this.rows[key].category) return true
            }

            return false;
        }
    },
    methods: {
        addNewRow(index) {
            var newRow = {
                id: i,
                _particulars: 'request_funds[' + i + '][particulars]',
                _amount: 'request_funds[' + i + '][amount]',
                _category: 'request_funds[' + i + '][category]',
                particulars: '',
                amount: '',
                category: '',
            };
            try {
                this.rows.splice(index + 1, 0, newRow);
            } catch(e)
            {
                console.log(e);
            }
            i++;

        }, 
        removeRow(id, index) {
            console.log(index);
            this.rows.splice(index, 1);
        }
    }
});