<template>
    <div class = "container-fluid">
        <div class = "row justify-content-center">
            <div
                class = "card login-form col-8 col-sm-6 col-md-5 col-lg-4 col-xl-3 mt-5"
                @submit.prevent = "goToForm2">

                <div class = "card-body" v-if = "showForm1">
                    <p class = "card-title fw-bold pb-4">ورود</p>
                    <form>
                        <input
                            class = "form-control "
                            autofocus
                            type = "text"
                            v-model = "mobile"
                            style = "padding-left:10px"
                            maxlength = "11"
                            minlength = "11"
                            required
                            dir = "ltr"
                            placeholder = "09 _ _ _ _ _ _ _ _ _"
                            oninput = "this.value=this.value.replace(/[^0-9]/g,'');"
                            :class = "{ hasError: mobileError.length != 0,
                            valid: mobileAccepted == true,}"/>

                        <div v-if = "mobileError" class = "error">
                            <small class = "d-block" v-for = "err in mobileError" :key = "err">
                                {{ err }}
                            </small>

                        </div>

                        <div>
                            <button class = "btn btn-primary">دریافت کد تایید</button>
                            <small class="d-block mt-4 mb-1">حساب کاربری ندارید؟ <router-link to="/register">اینجا</router-link> ثبت نام کنید</small>
                        </div>
                    </form>
                </div>
                <div v-if = "showForm2">
                    <form id = "form2" action = "/" method = "get">
                        <p class = "pb-3 m-0 small">
                            لطفا کد 5 رقمی که از طریق پیامک دریافت کردید را وارد کنید
                        </p>

                        <div class = "code flex-row-reverse">
                            <input
                                id = "code1"
                                class = "form-control form-control-lg"
                                :class = "{ hasError: codeError != '',
                                valid: codeAccepted == true, }"
                                value = ""
                                v-on:input = "autoTab($event)"
                                type = "text"
                                required
                                maxlength = "1"
                                minlength = "1"
                                autofocus
                            />
                            <input
                                id = "code2"
                                class = "form-control form-control-lg"
                                :class = "{
                                hasError: codeError != '',
                                valid: codeAccepted == true,
                                }"
                                value = ""
                                v-on:input = "autoTab($event)"
                                type = "text"
                                required
                                maxlength = "1"
                                minlength = "1" />
                            <input
                                id = "code3"
                                class = "form-control form-control-lg"
                                :class = "{
                  hasError: codeError != '',
                  valid: codeAccepted == true,
                }"
                                value = ""
                                v-on:input = "autoTab($event)"
                                type = "text"
                                required
                                maxlength = "1"
                                minlength = "1"
                            />
                            <input
                                id = "code4"
                                class = "form-control form-control-lg"
                                :class = "{
                  hasError: codeError != '',
                  valid: codeAccepted == true,
                }"
                                value = ""
                                v-on:input = "autoTab($event)"
                                type = "text"
                                required
                                maxlength = "1"
                                minlength = "1"
                            />
                            <input
                                id = "code5"
                                class = "form-control form-control-lg"
                                :class = "{
                  hasError: codeError != '',
                  valid: codeAccepted == true,
                }"
                                value = ""
                                v-on:input = "autoTab($event)"
                                type = "text"
                                required
                                maxlength = "1"
                                minlength = "1"
                            />
                        </div>
                        <div>
                            <div v-if = "codeError" class = "error">
                                {{ codeError }}
                            </div>
                            <div class = "d-flex justify-content-start mt-2 mb-3">
                                <small id = "sendAgain" @click = "retrySms" class = " retry text-muted me-2">ارسال
                                    دوباره کد</small>
                                <small id = "timeLeft" class = "timeLeft text-muted">00:</small>
                                <small id = "time" class = "timeLeft text-muted">59</small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                mobile: "",
                showForm1: true,
                showForm2: false,
                code: "",
                codeError: "",
                mobileError: [],
                codeAccepted: false,
                mobileAccepted: false,
                timeLeft: 59,
            };
        },
        mounted() {
            document.querySelector('title').innerHTML = 'ورود | one';

        },
        methods: {
            counter() {
                var distance = 59;

                var x = setInterval(function () {

                    document.getElementById("time").classList.remove('d-none');
                    document.getElementById("timeLeft").classList.remove('d-none');
                    document.getElementById("sendAgain").classList.add('text-muted');
                    document.getElementById("sendAgain").classList.remove('text-primary');
                    document.getElementById("sendAgain").classList.remove('text-decoration-underline');
                    document.getElementById("sendAgain").style.cursor = 'not-allowed';

                    distance--;
                    this.timeLeft = distance;
                    var t = this.timeLeft < 10 ? "0" : "";
                    document.getElementById("time").innerHTML = t + this.timeLeft;


                    if (distance < 1) {
                        clearInterval(x);
                        document.getElementById("time").classList.add('d-none');
                        document.getElementById("timeLeft").classList.add('d-none');
                        document.getElementById("sendAgain").classList.remove('text-muted');
                        document.getElementById("sendAgain").classList.add('text-primary');
                        document.getElementById("sendAgain").classList.add('text-decoration-underline');
                        document.getElementById("sendAgain").style.cursor = 'pointer';

                    }
                }, 1000);

                this.timeLeft = 0;
            },
            goToForm2() {
                this.mobileError = [];
                var tt = this.mobileError;

                if (!this.mobile.startsWith("09")) {
                    this.mobileError.push("mobile must start with 09")
                }
                if (this.mobile.length < 11) {
                    this.mobileError.push("mobile must contain 11 numbers")
                }


                this.mobileError.length == 0 ?
                    (this.mobileAccepted = true,
                        setTimeout(() => {
                            (this.showForm1 = false), (this.showForm2 = true);

                        }, 1500))
                    : (this.mobileAccepted = false);


                // for (let i = 60; i >= 0; i--) {
                //   setTimeout(function(){
                //      i > 9 ? this.timeLeft = i :  this.timeLeft = "0" + i;
                //     console.log(this.timeLeft);
                //   }, 1000);
                this.counter();
            },

            autoTab(e) {
                this.code =
                    document.getElementById("code1").value +
                    document.getElementById("code2").value +
                    document.getElementById("code3").value +
                    document.getElementById("code4").value +
                    document.getElementById("code5").value;
                if (this.code.length == 5) {
                    this.code === "11111"
                        ? (setTimeout(() => {
                            (this.codeError = ""), (this.codeAccepted = true);
                        }, 1000),
                            setTimeout(() => {
                                document.getElementById("form2").submit();
                            }, 3000))
                        : (this.codeError = "Wrong Code");
                }

                if (e.target.value.length == e.target.maxLength) {
                    e.target.nextElementSibling.focus();

                }
            },
            retrySms() {
                if (this.timeLeft == 0) {

                    this.counter();

                }
            }
        },
    };
</script>

<style scoped>
    /* .login-form {
      padding: 30px 20px;
      background-color: whitesmoke;
      border-radius: 3px;
    }
    .login-form form input {
      width: calc(99% - 9px);
      border-radius: 2px;
      border: 0px;
      margin-bottom: 10px;
      height: 25px;
    }*/
    .login-form form .code {
        width: 100% !important;
        display: inline-flex;
        justify-content: space-between !important;
        padding: 0px;
        margin: 0px;
    }

    .login-form form .code input {
        width: 16%;
        padding-right: 0;
        padding-left: 0;
        height: 40px;
        text-align: center;
        direction: ltr;
    }

    .login-form input:focus {
        outline: none !important;
        /* border:1px solid red; */
        box-shadow: 0 0 1.5px gray;
    }

    /* .login-form form button {
      padding: 5px 10px;
      margin-bottom: 5px;
      border: none;
      background-color: #42b983;
      color: whitesmoke;
      border-radius: 2px;
    } */
    .error {
        font-size: 12px;
        margin-bottom: 10px;
        color: lightcoral;
    }

    .hasError {
        border: 1.5px solid lightcoral !important;
        box-shadow: none !important;
    }

    .valid {
        border: 1.5px solid #42b983 !important;
        box-shadow: none !important;
    }

    small {
        -webkit-user-select: none; /* Chrome all / Safari all */
        -moz-user-select: none; /* Firefox all */
        -ms-user-select: none; /* IE 10+ */
        user-select: none;

    }

</style>
