<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link href="<?=BASE_URL?>css/main.css" rel="stylesheet" type="text/css">
    <style>
        .cont {
            display: flex;
        }

        .el {
        }
        .exe {
            margin-left: 3rem;
            margin-top: 0.5rem;
        }
        .nav {
            text-decoration: underline;
            cursor: pointer;
            color: blue;
        }
    </style>
</head>
<body>

<?php require_once 'logout.html' ?>

<h3>Добавление нового пользователя</h3>

<br>

<div id="app" class="cont">
    <div class="el" style="flex-grow: 1; flex-basis: 200px;">
        <div>
            <span v-on:click="getLead(lead.id_parent)" class="nav">{{lead.name}}</span>
        </div>
        <div v-for="(executor, index) in executors" class="exe">
            <span v-on:click="getLead(executor.id_user)" class="nav">{{executor.name}} - {{executor.org}}</span>
        </div>
    </div>
    <div class="el" style="flex-grow: 3; flex-basis: 500px;">
        <div>
            <form method="post">
                Руководитель: {{lead.name}}
                <input type="hidden" v-model="lead.id_user" name="id_parent"><br>
                Организация: {{lead.org}}
                <input type="hidden" v-model="lead.id_org" name="id_org"><br>
                <div>
                    Должность:<br><input type="text" name="position" class="input input_text">
                </div>
                <div>
                    Логин:<br><input type="text" name="login" class="input input_text">
                </div>
                <div>
                    Пароль:<br><input type="password" name="password" id="pass" class="input input_text">
                </div>
                <div>
                    Подтверждение:<br><input type="password" name="password2" id="re_pass" class="input input_text">
                </div>
                <input type="submit" name="GO" value="Регистрация" class="input input_button">
            </form>
        </div>

        <div>
        </div>
    </div>
</div>

<div><?=$msg->popValue()?></div>

<script src="<?=BASE_URL?>js/vue.min.js"></script>
<script src="<?=BASE_URL?>js/vue-resource.min.js"></script>

<script>

var app = new Vue({
    el: '#app',
    data: {
        server: '<?=BASE_URL?>',
        txt: 'навигационная панель',
        executors: [],
        lead: '',
        controllers: [],
    },
    methods: {
        getLead: function(id) {
            this.$http.post(this.server + 'getlead/' + id).then(
                function (otvet) {
                    this.lead = otvet.data;
                    console.log(otvet.data);
                    // после получения информации по лидеру,
                    // запрашиваем список подчиненных
                    this.getExecutors(id);
                    this.getControllers();
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        getExecutors: function(id) {
            this.$http.post(this.server + 'getexecutors/' + id).then(
                function (otvet) {
                    this.executors = otvet.data;
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        getControllers: function() {
        },
    },
    created: function() {
        this.getLead(1);
    }
})

</script>

</body>
</html>
