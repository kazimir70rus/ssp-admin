<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link href="<?=BASE_URL?>css/main.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once 'logout.html' ?>
<div id="app">
    <input type="text" v-model="report_name" class="input input_text"><br>
    <div v-if="edit_mode">
        <button class="input input_button" v-on:click="save">Сохранить изменения</button><br>
        <button class="input input_button" v-on:click="exit_edit">Отмена</button>
    </div>
    <div v-else>
        <button class="input input_button" v-on:click="save">Добавить</button>
    </div>
    <br>
    <template v-for="(type_res, index) in type_reports">
        <div>
            <a href="#" v-on:click="edit(index)">{{type_res.name}}</a>
        </div>
    </template>
    <br>
    <a href="<?=BASE_URL?>"><button class="input input_button">Назад</button></a>
</div>

<script src="<?=BASE_URL?>js/vue.min.js"></script>
<script src="<?=BASE_URL?>js/vue-resource.min.js"></script>

<script>

var app = new Vue({
    el: '#app',
    data: {
        server: '<?=BASE_URL?>',
        report_name: '',
        type_reports: [],
        id_report: '',
        edit_mode: false,
    },
    watch: {
    },
    methods: {
        getTypeResults: function () {
            this.$http.get(this.server + 'gettypereports').then(
                function (otvet) {
                    this.type_reports = otvet.data;
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        save: function () {
            this.$http.post(this.server + 'addtypereport', {name: this.report_name, id_report: this.id_report}).then(
                function (otvet) {
                    //this.type_reports = otvet.data;
                    this.exit_edit();
                    this.getTypeResults();
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        edit: function (index) {
            this.report_name = this.type_reports[index].name;
            this.id_report = this.type_reports[index].id_report;
            this.edit_mode = true;
        },
        exit_edit: function () {
            this.report_name = '';
            this.id_report = '';
            this.edit_mode = false;
        },
    },
    created: function() {
        this.getTypeResults();
    }
})
</script>

</body>
</html>
