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
    <input type="text" v-model="result_name" class="input input_text">
    <button class="input input_button" v-on:click="save">Добавить</button>
    <br>
    <template v-for="type_res in type_results">
        <div>
            {{type_res.name}}
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
        result_name: '',
        type_results: [],
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
        save: function () {
            this.$http.post(this.server + 'addtyperesult', {name: this.result_name}).then(
                function (otvet) {
                    this.type_results = otvet.data;
                },
                function (err) {
                    console.log(err);
                }
            );
        },
    },
    created: function() {
        this.getTypeResults();
    }
})
</script>

</body>
</html>
