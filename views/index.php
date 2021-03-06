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
<a href="<?=BASE_URL?>type_result">Справочник "Вид результата"</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL?>type_report">Справочник "Вид отчета"</a><br><br>
<h3>Добавление нового пользователя</h3>

<br>

<div id="app" class="cont">
    <div style="margin-right: 5rem">
        <div>
            <table style="border-bottom: 2px solid grey;">
                <tr>
                    <td v-on:click="getLead(lead.id_parent)" class="nav">{{lead.login}}</td>
                    <td>{{lead.position}}</td>
                    <td>{{lead.organisation}}</td>
                </tr>
            </table>
        </div>
        <table class="exe">
            <tr>
                <th>логин</th>
                <th>ФИО</th>
                <th>должность</th>
                <th>организация</th>
            </tr>
            <tr v-for="(executor, index) in executors">
                <td v-on:click="getLead(executor.id_user)" class="nav">{{executor.name}}</td>
                <td>{{executor.fio}}</td>
                <td>{{executor.position}}</td>
                <td>{{executor.org}}</td>
                <td v-on:click="editUser(executor.id_user)" class="nav b">&bull;&bull;&bull;</td>
            </tr>
        </table>
    </div>
    <div style="flex-grow: 3; flex-basis: 300px;">
        <div>
            <form method="post">
                Руководитель: {{lead.login}}
                <input type="hidden" v-model="lead.id_user" name="id_parent"><br>
                Организация (<a v-bind:href="'<?=BASE_URL?>organisation/' + id_org">редактирование</a>):<br>
                <select class="input" v-model="id_org" name="id_org">
                    <option v-for="org in organisations" v-bind:value="org.id_organisation">{{org.name}}</option>
                </select>

                <div>
                    Должность:<br><input type="text" v-model="position" name="position" class="input input_text">
                </div>

                <select v-if="pos_visible" v-model="name_position" size="5" class="input" style="height: 90px" v-on:click="hide()">
                    <option v-for="pos in positions" v-bind:value="pos.name">{{pos.name}}</option>
                </select>

                <div>
                    <input type="checkbox" v-model="userData.is_controller" name="is_controller" class="input_checkbox"> контроллер
                </div>

                <div>
                    ФИО:<br><input type="text" v-model="fio" name="fio" class="input input_text">
                </div>

                <div>
                    Телефон:<br><input type="text" v-model="phone" name="phone" class="input input_text">
                </div>

                <div>
                    Логин:<br><input type="text" v-model="userData.login" name="login" class="input input_text">
                </div>

                <div>
                    Пароль:<br><input type="password" v-model="userData.password" name="password" id="pass" class="input input_text">
                </div>

                <div>
                    Подтверждение:<br><input type="password" v-model="userData.password2" name="password2" id="re_pass" class="input input_text">
                </div>

                <div v-if="edit_mode">
                    <input type="button" v-on:click="exitEditMode" value="Отмена" class="input input_button"></br>
                    <input type="button" v-on:click="updateInfo" value="Сохранить" class="input input_button">
                </div>
                <div v-else>
                    <input type="button" v-on:click="saveUser" value="Регистрация" class="input input_button">
                </div>
                <div>{{message}}</div>
            </form>
        </div>

        <div>
        </div>
    </div>
    <div style="flex-grow: 1;">
    </div>
</div>

<script src="<?=BASE_URL?>js/vue.min.js"></script>
<script src="<?=BASE_URL?>js/vue-resource.min.js"></script>

<script>

var app = new Vue({
    el: '#app',
    data: {
        server: '<?=BASE_URL?>',
        executors: [],
        pos_visible: false,
        positions: [],
        position: '',
        name_position: '',
        lead: '',
        controllers: [],
        organisations: [],
        userData: {},
        message: '',
        edit_mode: false,
        fio: '',
        id_org: '',
        phone: '',
    },
    watch: {
        position: function () {
            if ((this.position.length > 1) && (this.position.length < 7)) {
                this.seek_position();
            } else {
                this.pos_visible = false;
            }
        },
        fio: function () {
            // попробуем сформировать логин
            let fio = this.fio;
            if (fio.length == 0) {
                this.userData.login = '';
                return;
            }

            fio = fio.replace('.', ' ');
            m_fio = fio.split(' ');

            let inicials = '';

            for (i = 0; i < m_fio.length; ++i) {
                inicials += m_fio[i].charAt(0).toUpperCase();
            }

            this.userData.login = inicials;
        },
    },
    methods: {
        getLead: function(id) {
            this.$http.get(this.server + 'getlead/' + id).then(
                function (otvet) {
                    this.lead = otvet.data;
                    // после получения информации по лидеру,
                    // очищаем форму если не в режиме редактирования
                    if (!this.edit_mode) {
                        this.clearForm();
                    }
                    // запрашиваем список подчиненных
                    this.getExecutors(id);
                    // запрашиваем организации
                    this.getOrganisations();
                    this.id_org = parseInt(this.lead.id_organisation);
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        getExecutors: function(id) {
            this.$http.get(this.server + 'getexecutors/' + id).then(
                function (otvet) {
                    this.executors = otvet.data;
                },
                function (err) {
                    console.log(err);
                }
            );
        },
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
        saveUser: function(id) {
            this.message = '';
            this.userData.position = this.position;
            this.userData.id_parent = this.lead.id_user;
            this.userData.fio = this.fio;
            this.userData.id_org = this.id_org;
            this.userData.phone = this.phone.replace(/[^\d]/g, '');

            this.$http.post(this.server + 'index/', this.userData).then(
                function (otvet) {
                    this.message = otvet.data.message;
                    this.getLead(this.lead.id_user);
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        seek_position: function() {
            this.$http.get(this.server + 'seekposition/' + this.position).then(
                function (otvet) {
                    this.positions = otvet.data;

                    if (this.positions.length > 0) {
                        this.pos_visible = true;
                    } else {
                        this.pos_visible = false;
                    }
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        editUser: function(id_user) {
            this.message = '';
            this.position = '';
            this.$http.get(this.server + 'getuserinfo/' + id_user).then(
                function (otvet) {
                    this.id_org = otvet.data.id_organisation;
                    this.userData.login = otvet.data.login;
                    this.userData.is_controller = (parseInt(otvet.data.is_controller) == 1);
                    this.userData.id_user = id_user;
                    this.fio = otvet.data.fio;
                    this.phone = (otvet.data.phone) ? otvet.data.phone : '';
                    this.position = otvet.data.position;
                    this.edit_mode = true;
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        exitEditMode: function() {
            this.edit_mode = false;
            this.clearForm();
        },
        updateInfo: function() {
            this.message = '';
            this.userData.position = this.position;
            this.userData.id_parent = this.lead.id_user;
            this.userData.fio = this.fio;
            this.userData.phone = this.phone.replace(/[^\d]/g, '');
            this.userData.id_org = this.id_org;

            this.$http.post(this.server + 'updateinfo/', this.userData).then(
                function (otvet) {
                    this.exitEditMode();
                    this.message = otvet.data.message;
                    this.getLead(this.lead.id_user);
                },
                function (err) {
                    console.log(err);
                }
            );
        },
        hide: function() {
            this.pos_visible = false;
            this.position = this.name_position;
        },
        clearForm: function () {
            this.userData = {};
            this.position = '';
            this.fio = '';
            this.phone = '';
        },
    },
    created: function() {
        this.getLead(1);
    }
})

</script>

</body>
</html>
