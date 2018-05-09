
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('b-modal', require('./components/Modal.vue'));

var i = 0;
const app = new Vue({
    el: '#app',
    data: {
        rows: [
        ],
        focusedID: 0,
        reference_number: 0,
        chart_name: '',
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
    mounted() {
        // var i = 0;
        var m = this.getParameterByName('multi') || 2;
        var m_e = document.querySelector('#multi form input[name=multi-edit]');

        if (m_e) {
            var s = this.edit_multi(m_e.value);
            if (s) {
                var n;
                s.then(function (data) {
                    return data;
                }).then(res => {
                    // this.rows = res
                    for (i; i < res.length; i++) {
                        res[i]._id = 'request_funds[' + i + '][id]';
                        res[i]._particulars = 'request_funds[' + i + '][particulars]';
                        res[i]._amount = 'request_funds[' + i + '][amount]';
                        res[i]._category = 'request_funds[' + i + '][category]';
                    }
                    this.rows = res;
                });
                // console.log(s);
                // this.rows = s;
            }
        } else {
            while (i < m) {
                this.addNewRow();
                i++;
            }
        }
    },
    methods: {
        edit_multi(id) {
            var rows;
            return $.ajax({
                type: 'GET',
                url: '/api/particulars/' + id,
                success: function(data) {
                    this.rows = data;
                }
            });
        },
        deleteRequest: function() {
            var form = document.querySelector('#form-' + this.focusedID)
            form.submit();
            this.focusedID = 0;
        },
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
        },
        getParameterByName (name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        },
        deleteChart: function() {
            var form = document.querySelector('#form-' + this.focusedID)
            form.submit();
            this.focusedID = 0;
        }
    },
});
