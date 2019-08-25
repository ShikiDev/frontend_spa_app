<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Тестовое задание</title>
    <script src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/fontawesome-free-5.10.2-web/css/all.css">
    <script src="fontawesome-free-5.10.2-web/js/all.js"></script>
    <script type="text/javascript" src="js/main.js" async></script>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<div id="app">
    <section id="tariff_types">
        <div class="container flex-container">
            <div class="tariff" v-for="tariff in tariffs">
                <div class="tariff-box">
                    <div class="tariff-container tariff-kinds" v-on:click="selectedTariffKind=tariff['id']">
                        <div class="head">
                            <div class="head-title">{{tariff['name']}}</div>
                        </div>
                        <div class="body">
                            <div class="speed" :class="tariff['class_name']">
                                <div class="speed-content">
                                    <div class="speed-value">{{tariff['speed']}}</div>
                                    <div class="speed-name">Mбит/c</div>
                                </div>
                            </div>
                            <div class="price">
                                <div class="price-content">{{tariff['price_range']}}</div>
                            </div>
                            <div class="clear"></div>
                            <div class="free-options">{{tariff['free_options']}}</div>
                        </div>
                    </div>
                    <div class="tariff-box-footer">
                        <div class="bottom">
                            <a :href="tariff['link']" target="_blank">узнать подробнее на сайте www.sknt.ru</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="tariff_list">
        <div class="tariff-name-block">
            <div class="back-button" v-on:click="getBackToTariffKinds">
                <div class="arrow-btn"><i class="fas fa-angle-left"></i></div>
            </div>
            <div class="tariff-name">{{selectedTariffName}}</div>
        </div>
        <div class="container flex-container">
            <div class="tariff" v-for="tariff_type in selectedTariffList">
                <div class="tariff-box">
                    <div class="tariff-container">
                        <div class="head">
                            <div class="head-title">{{tariff_type.title}}</div>
                        </div>
                        <div class="type-block">
                            <div class="body">
                                <div class="price">
                                    <div class="price-content">
                                        {{tariff_type.price_one}}
                                    </div>
                                </div>
                                <div class="free-options-types">
                                    <span>разовый платеж - {{tariff_type.price}}</span>
                                </div>
                            </div>
                            <div class="go-to-button" v-on:click="selectedTariff=tariff_type.ID">
                                <div class="arrow-btn">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="tariff_info">
        <div class="tariff-name-block">
            <div class="back-button" v-on:click="getBackToTariffLists">
                <div class="arrow-btn"><i class="fas fa-angle-left"></i></div>
            </div>
            <div class="tariff-name" >Выбор тарифа</div>
        </div>
        <div class="container flex-container">
            <div class="tariff-one" v-for="tariffData in selectedTariffData">
                <div class="tariff-block">
                    <div class="tariff-container">
                        <div class="head">
                            <div class="head-title">{{tariffData.title}}</div>
                        </div>
                        <div class="body">
                            <div class="price">
                                <div class="price-content">
                                    <span>Период оплаты - {{tariffData.pay_period}}</span><br>
                                    <span>{{tariffData.price_one}}</span>

                                </div>
                            </div>
                            <div class="free-options">
                                <span>разовый платеж - {{tariffData.price + tariffData.price_add}}</span><br>
                                <span>со счёта спишется - {{tariffData.price + tariffData.price_add}}</span>
                                <div class="faded">
                                    <span>вступит в силу - сегодня</span><br>
                                    <span>активно до - {{tariffData.new_payday}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tariff-box-footer">
                        <div class="btn-block">
                            <button class="btn btn-color" @click.prevent="btnPress">Выбрать</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>