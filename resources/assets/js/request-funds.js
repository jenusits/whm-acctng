var multi = new Vue({
    el: '#root',
    data: {
        rows: [
        ]
    },
    mounted() {
        var i = 0;
        while (i < this.getParameterByName('multi')) {
            this.addNewRow();
            i++;
        }
    },
    methods: {
        addNewRow() {
            this.rows.push({});
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