var i = 0;

var multi = new Vue({
    el: '#multi',
    data: {
        rows: [
        ],
        submitted: false,
    },
    mounted() {
        while (i < this.getParameterByName('multi')) {
            this.addNewRow();
        }
    },
    methods: {
        addNewRow() {
            this.rows.push({
                id: i,
                _particulars: 'request_funds[' + i + '][particulars]',
                _amount: 'request_funds[' + i + '][amount]',
                _category: 'request_funds[' + i + '][category]',
                particulars: '',
                amount: '',
                category: '',
            });
            i++;
        }, 
        removeRow(id, index) {
            // console.log(e);
            this.rows.splice(index, 1);
            // for(var i = 0; i < this.rows.length; i++) {
            //     var obj = this.rows[i];
                
            //     if(e.target.id == obj.id) {
            //         this.rows.splice(i, 1);
            //     }
            // }
        },
        getParameterByName (name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    }
});