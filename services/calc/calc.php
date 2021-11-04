<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
//require($_SERVER["DOCUMENT_ROOT"]."/local/templates/titan/header.php");
/**
 * Created by PhpStorm.
 * User: Jager
 * Date: 30.09.2020
 * Time: 11:55
 */
/** @var TYPE_NAME $APPLICATION */
//$APPLICATION->SetTitle("калькулятор стоимости договора");
//$APPLICATION->ShowTitle(false);
//if($_POST['type'] == 'calcResult') return "ccc";
//\Bitrix\Main\Diag\Debug::writeToFile($_REQUEST);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Расчет стоимости Технического обслуживания в соответствии с ПП РФ 410 (ВДГО и ВКГО)</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        #main {text-align:center;}
        #main select{min-width:8rem}
        /*#main input{max-width:8rem}*/
        #main label{display: flex;flex-direction: column;}
        #main .sel_pascade{overflow-y: hidden;border:none;}
        #main .sel_pascade option{display:inline-flex;flex-direction:column;height:100%;font-weight:bold;}
        #main .pack_desc{display:inline-flex;flex-direction:column;height:100%;}
        #main .pack_desc .pack_price, #main ul.errors{color:red;font-weight:bold;list-style-type: none;}
        #main .sel_pascade option.active{background-color: blue!important;text-decoration: underline;}
        #main select:hover{cursor:pointer}
        #main .has-error input{border-color:red;}
        #main #redirectTimer{margin-top:30%}
        #main .services {margin-bottom: 2rem;}
        #main .service_system .height3rem{min-height: 3rem;}
        #main span.h4{color:#000066;border-top:1px solid #330000;border-bottom:1px solid #330000;background-color: #f0f3f9;}
        #main table.table td {width: 50%;}
        #main p{margin-bottom: 0.5rem;}
        #main .pack_sel{display: inline-flex;justify-content: center;}
        #main .pack_sel input[type=radio] {width:1rem;height:1rem;margin: 4px 6px;}
        #main textarea{width:100%;height:2rem;max-height:10rem;}

    </style>
</head>

<div id="main" class="container" v-cloak>
    <div class="row"><span class="col h3">Расчет стоимости Технического обслуживания <br>в соответствие с ПП РФ 410 (ВДГО и ВКГО)</span></div>

    <div class="services row">

        <span class="col-12 h4">Котел<p class="text-danger"><small>* выбор обязателен для расчета</small></p></span>

        <label class="col-3" for="boiler_type">
            <p>Тип</p>
            <select name="boiler_type" v-model="selectedBT" v-bind:class="[ selectedBT.text ? 'active' : '']">
                <option v-for="option in boiler_type" :value="option">
                    {{ option.text }}
                </option>
            </select>
        </label>

        <label class="col-3" for="boiler_brand">
            <p>Марка</p>
            <select name="boiler_brand" v-model="selectedBB"  v-bind:class="[ selectedBB.text ? 'active' : '']">
                <option v-for="option in boiler_brand" :value="option">
                    {{ option.text }}
                </option>
            </select>
        </label>

        <label class="col-3" for="boiler_power">
            <p>Мощность,кВт </p>
            <input type="number" class="col-xs-2 align-self-center" size="4" maxlength="4" name="boiler_power" min="1" max="359" step="1" value="0" required v-model="selectedBP" v-bind:class="[ selectedBP ? 'active' : '']">
        </label>

        <label class="col-3" for="boiler_cond">
            <p>Конденсационный</p>
            <select name="boiler_cond" v-model="selectedBC"  v-bind:class="[ selectedBC.text ? 'active' : '']">
                <option v-for="option in boiler_cond" :value="option">
                    {{ option.text }}
                </option>
            </select>
        </label>
    </div>

    <div class="services row service_system">
        <span class="col-12 h4">Обслуживание инженерных систем</span>

        <label class="col-3" for="service_system1">
            <span class="height3rem">Внутридомовые газопроводы</span>
            <select name="service_system1" v-model="selected_service1" :disabled="disable_select_service > 0">
                <option v-for="option in select_service1" :value="option.text" :selected="option.id === 0" :class="{ 'active': option.id === 0 }">
                    {{ option.text }}
                </option>
            </select>
        </label>

        <label class="col-3" for="service_system2">
            <span class="height3rem">Внешние газопроводы</span>
            <select name="service_system1" v-model="selected_service2" :disabled="disable_select_service > 0">
                <option v-for="option in select_service1" :value="option.text" :selected="option.id === 0" :class="{ 'active': option.id === 0 }">
                    {{ option.text }}
                </option>
            </select>
        </label>

        <label class="col-3" for="service_system3">
            <span class="height3rem">Газовая плита</span>
            <select name="service_system1" v-model="selected_service3" :disabled="disable_select_service > 0">
                <option v-for="option in select_service1" :value="option.text" :selected="option.id === 0" :class="{ 'active': option.id === 0 }">
                    {{ option.text }}
                </option>
            </select>
        </label>
        <label class="col-3" for="service_system4">
            <span class="height3rem">Газовый водонагреватель</span>
            <select name="service_system1" v-model="selected_service4" :disabled="disable_select_service > 0">
                <option v-for="option in select_service1" :value="option.text" :selected="option.id === 0" :class="{ 'active': option.id === 0 }">
                    {{ option.text }}
                </option>
            </select>
        </label>
    </div>

    <div class="services row">
        <span class="col-12 h4">Пакет услуг <br> <small>выбран: {{selectedPackage.text}}</small></span>

        <div class="col-4  pack_sel" v-for="option in select_package">
            <input type="radio" v-bind:name="option.text" v-bind:value="option" v-model="selectedPackage" v-on:click="toggleActive(option)" >
            <label v-bind:for="option.text">
                <span class="h5">{{ option.text }}</span>
            </label>
        </div>

        <div class="col-4 pack_desc" v-for="option in select_package">
            <p>Стоимость: <span class="pack_price">{{ option.price }}</span></p>
            <small class="pack_desc_text">{{ option.desc }}</small>
        </div>
    </div>

    <div class="services row service_system">
        <span class="col-12 h4">Контактные данные<p class="text-danger"><small>* заполнение обязателено</small></p></span>

        <label class="col-3" for="contact1">
            <span class="height3rem">ФИО</span>
            <input type="text" class="col-xs-2 align-self-center" maxlength="100" name="contact1"  required v-model="fio">
        </label>
        <label class="col-3" for="contact2">
            <span class="height3rem">Телефон</span>
            <div class="flex-row">
                <span>+7</span><input type="text" id="phone" class="align-self-center" name="contact2" required v-model="phone" @input="acceptNumber">
            </div>
        </label>
        <label class="col-3" for="contact3" :class="['input-group', isEmailValid()]">
            <span class="height3rem">Емайл</span>
            <input type="email" class="col-xs-2 align-self-center" maxlength="30" name="contact3" placeholder="Email" required v-model="email">
        </label>
        <label class="col-3" for="contact4">
            <span class="height3rem">Комментарий</span>
            <textarea id="comment" type="email" class="col-xs-2 align-self-center" maxlength="300" name="contact4" placeholder="Комментарий" v-model="comment"></textarea>
        </label>

    </div>

    <hr>
    <div class="total row">
        <p v-if="errors.length">
            <span class="h6 text-center">Пожалуйста исправьте указанные ошибки:</span><br>
        <ul class="errors">
            <li v-for="error in errors">{{ error }}</li>
        </ul>
        </p>
        <span class="col-12 text-danger">Стоимость договора:  {{ getTotalPrice() }} ₽</span><span class="col-12"><input type="submit" value="Отправить заявку" v-on:click="sendResult" ></span>

        <div class="col-12 mb-3"><hr>
            <small class="text-center">1. Не является офертой <br>
                2. Возможны дополнительные скидки. Окончательная стоимость будет озвучена нашим менеджером после отправки вами заявки.<br>
                3. Стоимость ТО электрических котлов оговаривается индивидуально.</small>
        </div>

        <table id="resultToSend" class="table table-striped table-hover table-sm" hidden>
            <tbody>
            <tr><td colspan="2" class="h5 text-center">Заказчик</td></tr>
            <tr><td>ФИО</td><td> {{ fio }}</td></tr>
            <tr><td>Телефон</td><td> {{ phone }}</td></tr>
            <tr><td>Емайл</td><td> {{ email }}</td></tr>
            <tr><td colspan="2" class="h5 text-center">Выбранные опции</td></tr>
            <tr><td>Пакет & расчетная стоимость</td><td> {{ selectedPackage.text }} - {{ getTotalPrice() }}</td></tr>
            <tr><td>Тип котла</td><td> {{ selectedBT.text }}</td></tr>
            <tr><td>Марка котла</td><td> {{ selectedBB.text }}</td></tr>
            <tr><td>Класс котла</td><td> {{ boilerClass }}</td></tr>
            <tr><td>Мощность котла</td><td> {{ selectedBP }}</td></tr>
            <tr><td>Конденсационный</td><td> {{ selectedBC.text }}</td></tr>
            <tr><td>внутридомовые газопроводы</td><td> {{ selected_service1 }}</td></tr>
            <tr><td>внешние газопроводы</td><td> {{ selected_service2 }}</td></tr>
            <tr><td>газовая плита</td><td> {{ selected_service3 }}</td></tr>
            <tr><td>газовый водонагреватель</td><td> {{ selected_service4 }}</td></tr>
            <tr><td>коммент</td><td> {{ comment }}</td></tr>
            </tbody>
        </table>

    </div>
</div>

<script>
    var app2 = new Vue({
        el: '#main',
        data() {
            return {
                finalPrice:0,
                selectedBT:{},//type
                selectedBB:{},//brand
                selectedBP:null,//power
                selectedBC:{},//condensat bool
                selectedPackage:{},//base,extended,extended+ && price for package
                selectedPG:null,//power class
                selected_service1:'Нет',
                selected_service2:'Нет',
                selected_service3:'Нет',
                selected_service4:'Нет',

                boiler_type: [
                    {text: 'Настенный', coef: 1},
                    {text: 'Напольный', coef: 2},
                    {text: 'Дизельный', coef: 4}
                ],
                boiler_brand: [
                    {text: 'Alphatherm', coef: 2},
                    {text: 'Ariston', coef: 2},
                    {text: 'Baxi', coef: 2},
                    {text: 'Beretta', coef: 2},
                    {text: 'Bosch', coef: 3},
                    {text: 'Buderus', coef: 3},
                    {text: 'Chaffoteaux', coef: 2},
                    {text: 'Electrolux', coef: 2},
                    {text: 'Ferroli', coef: 2},
                    {text: 'ICI', coef: 3},
                    {text: 'Kentatsu', coef: 2},
                    {text: 'Kiturami', coef: 2},
                    {text: 'Laars', coef: 3},
                    {text: 'Mora', coef: 2},
                    {text: 'NAVIEN', coef: 2},
                    {text: 'Nova Florida', coef: 2},
                    {text: 'Protherm', coef: 2},
                    {text: 'Rapido', coef: 2},
                    {text: 'Rendamax', coef: 3},
                    {text: 'Rinnai', coef: 2},
                    {text: 'Sime', coef: 2},
                    {text: 'Termet', coef: 2},
                    {text: 'Thermona', coef: 2},
                    {text: 'TITAN', coef: 2},
                    {text: 'Vaillant', coef: 3},
                    {text: 'Viessmann', coef: 3},
                    {text: 'WESTEN', coef: 2},
                    {text: 'Wolf', coef: 3},
                    {text: 'Ишма', coef: 1},
                    {text: 'Лемакс', coef: 2},
                    {text: 'Другое*', coef: 2}
                ],
                boiler_cond: [
                    {text: 'Да', coef: 4},
                    {text: 'Нет', coef: 0}
                ],

                select_package:[
                    {text: 'Базовый',coef: 1,active:'checked',price:null, desc: 'Скоро тут будет описание'},
                    {text: 'Расширенный',coef: 2,active:false,price:null, desc: 'Скоро тут будет описание'},
                    {text: 'Расширенный+',coef: 3,active:false,price:null, desc: 'Скоро тут будет описание'},
                ],

                select_service1:[{id:0,text:'Нет',price:0},{id:1,text:'Да',price:400}],//внутридомовые газопроводы   400
                select_service2:[{id:0,text:'Нет',price:0},{id:1,text:'Да',price:400}],//внешние газопроводы         400
                select_service3:[{id:0,text:'Нет',price:0},{id:1,text:'Да',price:400}],//газовая плита               400
                select_service4:[{id:0,text:'Нет',price:0},{id:1,text:'Да',price:600}],//газовый водонагреватель     600
                disable_select_service: 0,

                power_group:[
                    {id:1,min:1,max:20},
                    {id:2,min:21,max:30},
                    {id:3,min:31,max:60},
                    {id:4,min:61,max:140},
                    {id:5,min:141,max:359}
                ],

                price_base:[4500,5000,6000,7000,10000],
                price_ext:[
                    [6500,7000,7000,17900],
                    [6500,8000,9000,17900],
                    [7000,9000,10000,17900],
                    [7500,12000,12000,20300],
                    [15000,15000,15000,23900]
                ],

                errors: [],
                fio:'',
                email: '',
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                phone: '',
                comment: ''

            }
        },
        created: function () {
            this.selectedPackage = this.select_package[0];
            this.select_package[0].desc = "Только ТО. Работы: в договор входит 1 (одно) техническое обслуживание с минимальным перечнем работ в соответствие с ПП РФ №410. Все дополнительные выезды, работы и з/ч оплачиваются дополнительно";
            this.select_package[1].desc = "ТО + выезд. Работы: в договор входит 1 (одно) техническое обслуживание с расширенным перечнем работ (минимальным в соответствие с ПП РФ №410 + рекомендации производителей) + 1 возможный ремонтный выезд.Все дополнительные выезды (сверх одного входящего в договор), работы и з/ч оплачиваются дополнительно";
            this.select_package[2].desc = "ТО + 2 выезда. Работы: в договор входит 1 (одно) техническое обслуживание с расширенным перечнем работ (минимальным в соответствие с ПП РФ №410 + рекомендации производителей) + 2 возможных ремонтных выезда. Все дополнительные выезды (сверх двух входящих в договор), работы и з/ч оплачиваются дополнительно";
        },
        computed: {
            boilerClass: function (){
                let m = 'не выбраны необходимые параметры котла';
                if(this.selectedBB.coef) m = this.selectedBB.coef;
                if(this.selectedBC.coef) m = this.selectedBC.coef;
                return m;
            },
        },
        methods: {
            toggleActive: function(event){
                this.select_package.map(function(key) {
                    //console.log(key);
                    key.active = false;
                    //app2.fixServices(event.coef);
                });

                return event.active = 'checked';
            },
            /*fixServices(id){
                if(id > 1){
                    this.selected_service1 = 'Да';
                    this.selected_service2 = 'Да';
                    this.selected_service3 = 'Да';
                    this.selected_service4 = 'Да';
                    this.disable_select_service = 1;
                }else{
                    this.selected_service1 = 'Нет';
                    this.selected_service2 = 'Нет';
                    this.selected_service3 = 'Нет';
                    this.selected_service4 = 'Нет';
                    this.disable_select_service = 0;
                }
            },*/
            getPowerGroup(power){
                let pg = false;
                this.power_group.map( function(value) {
                    if (power >= value.min && power <= value.max) pg = value.id;
                });

                this.selectedPG = pg;
                return pg;
            },
            calcServices(){
                let zero = 0;
                //if(this.selectedPackage.coef === 1){
                    if(this.selected_service1 === 'Да') zero += this.select_service1[1].price;
                    if(this.selected_service2 === 'Да') zero += this.select_service2[1].price;
                    if(this.selected_service3 === 'Да') zero += this.select_service3[1].price;
                    if(this.selected_service4 === 'Да') zero += this.select_service4[1].price;
                //}
                //console.log(this.selectedPackage);
                return zero;
            },
            calcPrices(){
                //console.log(this.selectedBT.coef,this.selectedBB.coef,this.selectedBP,this.selectedBC.coef);
                if(this.selectedBT.coef > 0 && this.selectedBB.coef > 0 && this.selectedBP > 0 && this.selectedBC.text) {
                    this.selectedPG = this.getPowerGroup(this.selectedBP);

                    let services_price = 0;
                    services_price = app2.calcServices();

                    this.select_package.map(function(key) {
                        //console.log(key);
                        // calc base price
                        if(key.coef === 1){
                            //console.log(app2.selectedPackage);

                            //console.log(app2.$data.selectedPackage);
                            key.price = app2.price_base[(app2.selectedPG - 1)] + services_price;
                        }
                        // calc ext price
                        if(key.coef === 2){
                            key.price = app2.price_ext[(app2.selectedPG - 1)][(app2.boilerClass - 1)] + services_price;
                        }
                        // calc ext+ price
                        if(key.coef === 3){
                            let arPrices = [16000,20000,21000,21000];
                            if(app2.selectedBP <= 140){
                                //console.log(app2.selectedBT);
                                key.price = arPrices[(app2.selectedBT.coef - 1)] + services_price;
                            }else{
                                key.price = (app2.selectedBP * 160) + services_price;
                            }

                        }
                    });
                } else return false;
            },
            getTotalPrice() {
                this.calcPrices();
                //console.log(this.selected_service1);
                return (this.selectedPackage.price > 0) ? this.selectedPackage.price : '';
            },
            isEmailValid: function() {
                return (this.email === "")? "" : (this.reg.test(this.email)) ? 'has-success' : 'has-error';
            },
            acceptNumber() {
                let x = this.phone.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                this.phone = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            },
            checkForm: function () {
                this.errors = [];

                if (this.phone.length !== 14 ) {
                    console.log('fuck phone');
                    this.errors.push('Требуется указать правильный телефон.');
                }
                if (this.email.length < 1 || this.isEmailValid() === 'has-error') {
                    console.log('fuck email');
                    this.errors.push('Требуется указать правильный email.');
                }
                if (!this.fio) {
                    console.log('fuck fio');
                    this.errors.push('Требуется указать ФИО.');
                }
                if (this.getTotalPrice() <= 0) {
                    this.errors.push('Требуется выбрать параметры котла и пакет услуг.');
                }

                if (this.errors.length > 0) return false;

                return true;
            },
            sendResult(){
                if(!this.checkForm()) return false;
                let arResult = {
                    'type':'calcResult',
                    'email':this.email,
                    'fio':this.fio,
                    'phone':this.phone,
                    // params
                    'pascage':this.selectedPackage.text,
                    'price':this.selectedPackage.price,
                    'b_type':this.selectedBT.text,
                    'b_brand':this.selectedBB.text,
                    'b_cond':this.selectedBC.text,
                    'b_power':this.selectedBP,
                    's_1':this.selected_service1,
                    's_2':this.selected_service2,
                    's_3':this.selected_service3,
                    's_4':this.selected_service4,
                    'comment':this.comment
                };
                //console.log(arResult);
                const param = JSON.stringify(arResult);
                axios({
                    method: 'post',
                    url: '/services/calc/calc_result.php',
                    data: param,
                }).then(function (response) {
                    if(response.data === 555) {
                        document.getElementById("main").innerHTML = "<div class=\"h3 alert-success\">Спасибо, Ваша заявка принята и вскоре менеджер свяжется с Вами</div><hr><div class=\"h4 alert-danger\">А сейчас вы будете перенаправлены на главную страницу сайта</div>";
                        let timerDiv = document.createElement('div');
                        timerDiv.id = "redirectTimer";
                        timerDiv.className = "btn btn-secondary btn-lg btn-alert";
                        timerDiv.innerHTML = 9;
                        document.getElementById("main").append(timerDiv);

                        function timer(){
                            var obj=document.getElementById('redirectTimer');
                            obj.innerHTML--;
                            if(obj.innerHTML==0){
                                document.location.href='/';
                                setTimeout(function(){},1000);
                            } else{setTimeout(timer,1000);}
                        }
                        setTimeout(timer,1000);

                        console.log("good fuck!");
                    }
                })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
        }
    });

</script>


</html>

