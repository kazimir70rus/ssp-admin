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
    <input type="text" v-model="result_name" class="input input_text"><br>
    <div v-if="edit_mode">
        <button class="input input_button" v-on:click="save">Сохранить изменения</button><br>
        <button class="input input_button" v-on:click="exit_edit">Отмена</button>
    </div>
    <div v-else>
        <button class="input input_button" v-on:click="save">Добавить</button>
    </div>
    <br>
    <table>
        <tr>
            <th>Видимость</th>
            <th>Наименование (редактир.)</th>
        </tr>
        <template v-for="(type_res, index) in type_results">
            <tr>
                <td><input
                        type="checkbox"
                        v-model="type_res.visible"
                        v-bind:true-value="1"
                        v-bind:false-value="0"
                        v-on:click="change_visible(index)"
                    ></td>
                <td><a href="#" v-on:click="edit(index)">{{type_res.name}}</a></td>
            </tr>
        </template>
    </table>
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
        result_name: '',
        type_results: [],
        id_result: '',
        edit_mode: false,
    },
    watch: {
    },
    methods: {
        getTypeResults: function () {
            this.$http.get(this.server + 'gettyperesults').then(
                function (otvet) {
                    this.type_results = otvet.data;
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        change_visible: function (index) {
            const state = (this.type_results[index].visible == '0') ? '1' : '0';
            this.$http.post(this.server + 'res_visible_change', {id_result: this.type_results[index].id_result, visible: state}).then(
                function (otvet) {
                    this.exit_edit();
                    this.getTypeResults();
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        save: function () {
            this.$http.post(this.server + 'addtyperesult', {name: this.result_name, id_result: this.id_result}).then(
                function (otvet) {
                    this.exit_edit();
                    this.getTypeResults();
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        edit: function (index) {
            this.result_name = this.type_results[index].name;
            this.id_result = this.type_results[index].id_result;
            this.edit_mode = true;
        },
        exit_edit: function () {
            this.result_name = '';
            this.id_result = '';
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
