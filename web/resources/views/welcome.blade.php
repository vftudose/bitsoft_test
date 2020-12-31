<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tudose Valentin - BitSoftTest</title>
    <link rel="stylesheet" href="https://unpkg.com/buefy@0.9.4/dist/buefy.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.3.45/css/materialdesignicons.min.css">
    <style>
        html, body {
            min-height: 100vh;
            background-color: PowderBlue;
        }

        .container {
            padding-top: 10px;
        }

        .columns {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            vertical-align: center;
        }

        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .color {
            text-align: center;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            background-color: #0c5460;
        }

        .box {
            width: 150px;
            height: 150px;
            background-color: white;
        }

        .small-color {
            width: 25px;
            height: 25px;
            padding: 2px;
        }

        .flex-start {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .random-button {
            align-self: flex-end;
        }

    </style>
</head>
<body class="antialiased">
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script src="https://unpkg.com/buefy@0.9.4/dist/buefy.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<div id="app">
    <section>
        <div class="container container-fluid">
            <div class="columns">
                <div class="column is-one-fifth">
                    <b-field label="How Many Colors?">
                        <b-numberinput type="is-success" :min="0" :max="10" v-model="totalBoxes"></b-numberinput>
                    </b-field>
                </div>
                <div class="column is-one-fifth random-button">
                    <b-button @click="doRandomDistribution" type="is-success">Random distribution
                    </b-button>
                </div>
            </div>

            <div class="columns">
                <div v-for="(box, key) in totalBoxes" v-bind:key="key" class="column flex-center is-one-fifth">
                    <div class="color flex-center"
                         :style="'background-color: ' + colors[key]['color'] + '; padding: 5px;'">
                        <b-field>
                            <b-numberinput :min="0" type="is-success" v-model="colors[key]['count']"
                                           size="is-small"></b-numberinput>
                        </b-field>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column flex-center is-one-fifth">
                    <b-button @click="distributeColoredBalls" :loading="loading" type="is-success">Sort them out!
                    </b-button>
                </div>
            </div>

            <div class="columns" v-if="loading">
                <div v-for="(box, key) in totalBoxes" class="column flex-center is-one-fifth">
                    <div class="box" style="padding: 0;">
                        <b-skeleton height="150px"></b-skeleton>
                    </div>
                </div>
            </div>

            <div class="columns" v-if="!loading">
                <div v-for="(box, key) in boxes" v-bind:key="'box-' + key" class="column flex-center is-one-fifth">
                    <div class="box flex-start">
                        <div v-for="(color, key) in box" :style="'background-color: ' + color + ';'"
                             class="color small-color"></div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script type="application/javascript">
    axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'
    axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

    var vm = new Vue({
        el: '#app',
        data() {
            return {
                loading: false,
                totalBoxes: 3,
                colors: [
                    {color: 'red', count: 0},
                    {color: 'blue', count: 0},
                    {color: 'yellow', count: 0},
                    {color: 'green', count: 0},
                    {color: 'violet', count: 0},
                    {color: 'orange', count: 0},
                    {color: 'purple', count: 0},
                    {color: 'salmon', count: 0},
                    {color: 'indigo', count: 0},
                    {color: 'cyan', count: 0},
                ],
                boxes: []
            }
        },
        methods: {
            doRandomDistribution: function () {
                let totalBalls = this.totalBoxes;

                for (let i = 0; i < this.totalBoxes; i++) {
                    let random = Math.round(Math.random() * totalBalls);

                    while (random < (this.totalBoxes / 2)) {
                        random = Math.round(Math.random() * totalBalls);
                    }

                    if (i === this.totalBoxes - 1) {
                        this.colors[i]['count'] = totalBalls;
                    } else {
                        this.colors[i]['count'] = random;
                    }

                    totalBalls = this.totalBoxes + (totalBalls - random);
                }

            },
            distributeColoredBalls: function () {
                this.loading = true;
                axios({
                    url: 'http://localhost:8000/distribute',
                    method: 'post',
                    data: {
                        totalColors: this.totalBoxes,
                        colors: this.colors
                    }
                }).then((response) => {
                    this.boxes = response.data;
                }).catch((err) => {
                    this.warning(err.response.data[0]);
                }).finally(() => {
                    this.loading = false;
                })
            },
            warning(errMessage) {
                this.$buefy.snackbar.open({
                    message: errMessage,
                    type: 'is-warning',
                    position: 'is-top',
                    indefinite: true,
                })
            },
        }
    });

</script>
</body>
</html>
