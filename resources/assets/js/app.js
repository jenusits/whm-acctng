
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
import Datepicker from 'vuejs-datepicker';

// User defined
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('b-modal', require('./components/Modal.vue'));
Vue.component('b-full-modal', require('./components/FullModal.vue'));

var i = 0;

var moment = require('moment');

const app = new Vue({
    el: '#app',
    components: {
        Datepicker
    },
    data: {
        rows: [
        ],
        focusedID: 0,
        reference_number: 0,
        chart_name: '',
        inputFiles: [],
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
        },
        expense_amount: function() {
            var amount = 0;
            for (var key in this.rows) {
                amount += this.rows[key].amount * 1;
            }
            return Number(amount).toFixed(2);
        }
    },
    mounted() {
        // var i = 0;
        var m = this.getParameterByName('multi') || 5;
        var m_e = document.querySelector('#multi form input[name=multi-edit]');

        if (m_e) {
            var form_type = 'request_funds';
            if (document.querySelector('form input[name=form-type]'))
                form_type = document.querySelector('form input[name=form-type]').value;

            var s = this.edit_multi(m_e.value, form_type);
            if (s) {
                var n;
                s.then(function (data) {
                    return data;
                }).then(res => {
                    for (i; i < res.length; i++) {
                        res[i]._id = 'request_funds[' + i + '][id]';
                        res[i]._particulars = 'request_funds[' + i + '][particulars]';
                        res[i]._amount = 'request_funds[' + i + '][amount]';
                        res[i]._category = 'request_funds[' + i + '][category]';
                        res[i]._index = 'request_funds[' + i + '][rfindex]';
                    }
                    this.rows = res;
                });
            }
        } else {
            for (var d = i; d < m; d++) {
                this.addNewRow(i);
            }
        }
    },
    methods: {
        edit_multi(id, type = 'request_funds') {
            var rows;
            return $.ajax({
                type: 'GET',
                url: '/api/particulars/' + type + '/' + id,
                success : function(data) {
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
                _index: 'request_funds[' + i + '][rfindex]',
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
        },
        approveRequest: function() {
            var form = document.querySelector('#form-approve-' + this.focusedID)
            form.submit();
            this.focusedID = 0;
        },
        disapproveRequest: function() {
            var form = document.querySelector('#form-disapprove-' + this.focusedID)
            form.submit();
            this.focusedID = 0;
        },
        inputFileChange: function(el) {
            var files = el.target.files;
            var nfiles = Array.from(files);
            this.inputFiles = nfiles;
        },
        removeFile(index) {
            var newFileList = Array.from(this.inputFiles);
            newFileList.splice(index, 1);
            this.inputFiles = newFileList;
        },
        isValidFileExtension(file) {
            var extension = file.substr((file.lastIndexOf('.') +1));
            if (!/(pdf|zip|doc|docx|xlsx|xls|jpeg|png|jpg|gif)$/ig.test(extension)) {
                alert("Invalid file type: " + extension + ".");
                return false;
            } else
                return true;
        }
    },
});