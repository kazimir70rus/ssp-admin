<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link href="<?=BASE_URL?>css/main.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once 'logout.html' ?>

<h3>Редактирование организаций</h3>

<br>

<div id="app">
    <select class="input" v-model="id">
        <option value="0">выбрать для редактирования</option>
        <option v-for="org in organisations" v-bind:value="org.id_organisation">{{org.name}}</option>
    </select>
    <br>
    <div v-if="parseInt(id)">
        отредактируйте или <a href="#" v-on:click="clearId">создайте новую</a>
    </div>
    <div v-else>
        создать новую организацию
    </div>
    <form method="post">
        <input type="text" v-model="name" class="input input_text" name="name" required>
        <input type="hidden" name="id" v-model="id">
        <br>
        <input type="submit" value="Сохранить" class="input input_button">
        <br>
    </form>
    <a href="<?=BASE_URL?>"><button class="input input_button">Отмена</button></a>
</div>

<script src="<?=BASE_URL?>js/vue.min.js"></script>
<script src="<?=BASE_URL?>js/vue-resource.min.js"></script>

<script>

var app = new Vue({
    el: '#app',
    data: {
        server: '<?=BASE_URL?>',
        organisations: [],
        id: 0,
        name: '',
    },
    watch: {
        id: function() {
            if (parseInt(this.id) == 0) {
                this.name = '';

                return;
            }
            for (let i = 0; i < this.organisations.length; ++i) {

                if (this.organisations[i].id_organisation == this.id) {
                    this.name = this.organisations[i].name;

                    break;
                }
            }
        },
    },
    methods: {
        getOrganisations: function() {
            this.$http.get(this.server + 'getorganisations/').then(
                function (otvet) {
                    this.organisations = otvet.data;
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        clearId: function() {
            this.id = 0;
        },
    },
    created: function() {
        this.getOrganisations();
    }
})

</script>

</body>
</html>
