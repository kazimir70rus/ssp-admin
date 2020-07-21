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
            border: 1px solid grey;
        }
        .exe {
            margin-left: 3rem;
        }
    </style>
</head>
<body>
<?php require_once 'logout.html' ?>

<h3>Добавление нового пользователя</h3>

<div id="app" class="cont">
    <div class="el" style="flex-grow: 1">
        <div><span v-on:click="getLead(lead.id_parent)">{{lead.name}}</span></div>
        <div v-for="(executor, index) in executors" class="exe"><span v-on:click="getLead(executor.id_user)">{{executor.name}} - {{executor.org}}</span></div>
    </div>
    <div class="el" style="flex-grow: 4">
        <div>
            <form method="post">
                Логин:<br><input type="text" name="login" id="login"><br>
                Должность:<br><input type="text" name="position" id="position"><br>
                Руководитель: {{lead.name}}<br>
                <input type="hidden" v-model="lead.id_user" name="id_parent">
                <br>
                Организация: {{lead.org}}<br>
                <input type="hidden" v-model="lead.id_org" name="id_org">                
                <br>
                Пароль:<br><input type="password" name="password" id="pass"><br>
                Подтверждение:<br><input type="password" name="password2" id="re_pass" ><br>
                <input type="submit" name="GO" value="Регистрация">
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
