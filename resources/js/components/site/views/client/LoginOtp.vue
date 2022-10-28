<template>
    <div class = "container-fluid">
        <div class = "row justify-content-center">
            <div class = "col-md-10 col-lg-8 row justify-content-center row">
                <div class = "card login-form col-12 col-md-10 col-xl-6  mt-5 mb-5 justify-content-center"
                     @submit.prevent = "getCode">

                    <div v-show = "showForm1" class = "card-body">
                        <p class = "card-title fw-bold pb-4 text-center">وارد شوید</p>
                        <form>
                            <input
                                id = "mobile"
                                class = "form-control mb-3"
                                autofocus
                                type = "text"
                                v-model = "mobile"
                                style = "padding-left:10px"
                                maxlength = "11"
                                minlength = "11"
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
                                <button class = "btn btn-primary" @click = "getCode">دریافت کد تایید</button>
                                <router-link to = "/login"><small class = "mx-3">ورود با ایمیل</small></router-link>

                                <small class = "d-block mt-4 mb-1">حساب کاربری ندارید؟
                                    <router-link to = "/register">اینجا</router-link>
                                    ثبت نام کنید</small>
                            </div>
                        </form>
                    </div>
                    <div v-show = "showForm2" class = "card-body py-5">
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
                                    minlength = "1"/>
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
                                <div v-if = "codeError" id = "msg" class = "error">
                                    {{ codeError }}
                                </div>
                                <div class = "d-flex justify-content-start mt-2 mb-3">
                                    <small id = "sendAgain" @click = "getCode" class = " retry text-muted me-2">ارسال
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
    </div>
</template>

<script>
    import App from "../Site";

    export default {
        data() {
            return {
                mobile: "",
                showForm1: true,
                showForm2: false,
                code: "",
                otp: "",
                codeError: "",
                mobileError: [],
                codeAccepted: false,
                mobileAccepted: false,
                timeLeft: 59,
                user: {},
            };
        },
        mounted() {
            document.querySelector('title').innerHTML = 'ورود | one';

            localStorage.removeItem('user');
            localStorage.removeItem('expire');
            localStorage.removeItem('access_token');

            document.getElementById('login').classList.remove('d-none');
            document.getElementById('register').classList.remove('d-none');
            document.getElementById('profile').classList.add('d-none');
            document.getElementById('logout').classList.add('d-none');
            document.getElementById('cart').classList.add('d-none');
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
                        document.getElementById("sendAgain").classList.add('text-decoration-underline');
                        document.getElementById("sendAgain").style.cursor = 'pointer';

                    }
                }, 1000);

                this.timeLeft = 0;
            },
            getCode() {
                this.mobileError = [];

                if (this.mobile === "") {
                    this.mobileError.push("لطفا شماره موبایل را وارد کنید")
                } else {
                    if (!this.mobile.startsWith("09")) {
                        this.mobileError.push("شماره موبایل باید با 09 شروع شود")
                    }
                    if (this.mobile.length < 11) {
                        this.mobileError.push("شماره موبایل باید 11 رقم باشد")
                    }
                }


                if (this.mobileError.length === 0) {
                    this.mobile = document.getElementById('mobile').value;
                    axios.get('/api/get/otp/' + this.mobile)
                        .then((response) => {
                            console.log(response);
                            if (response.status === 200) {

                                this.otp = response.data.otp;
                                this.user = response.data.user;

                                this.mobileAccepted = true;
                                setTimeout(() => {
                                    this.showForm1 = false;
                                    this.showForm2 = true;

                                }, 1500);
                            } else {
                                (this.mobileAccepted = false);
                            }

                        })
                        .catch((error) => {

                            console.log(error)
                            if (error.status === 400) {
                                this.mobileError.push(error.data)

                            }

                        })
                    ;


                    // for (let i = 60; i >= 0; i--) {
                    //   setTimeout(function(){
                    //      i > 9 ? this.timeLeft = i :  this.timeLeft = "0" + i;
                    //     console.log(this.timeLeft);
                    //   }, 1000);
                    this.counter();
                }
            }
            ,

            autoTab(e) {
                this.code =
                    document.getElementById("code1").value +
                    document.getElementById("code2").value +
                    document.getElementById("code3").value +
                    document.getElementById("code4").value +
                    document.getElementById("code5").value;
                if (this.code.length === 5 && this.code == this.otp) {

                    console.log('otp',this.otp);
                    axios.get('/api/login/otp/'+this.user.id).then((response) => {
                        console.log(response);
                        //     ? (setTimeout(() => {
                        //         (this.codeError = ""),
                        //             (this.codeAccepted = true);
                        //     }, 1000),
                        //         setTimeout(() => {
                        //             document.getElementById("form2").submit();
                        //         }, 3000))
                        //     : (this.codeError = "Wrong Code");
                        if (response.status === 200) {
                            //enter
                            async function jobs() {
                                await localStorage.setItem('access_token', response.data.access_token);
                                await localStorage.setItem('user', JSON.stringify(response.data.user));
                                await localStorage.setItem('expire', response.data.expire);
                                await document.getElementById('login').classList.add('d-none');
                                await document.getElementById('register').classList.add('d-none');
                                await document.getElementById('profile').classList.remove('d-none');
                                await document.getElementById('logout').classList.remove('d-none');
                                await document.getElementById('cart').classList.remove('d-none');
                            }

                            jobs();
                            localStorage.setItem('user', JSON.stringify(response.data));
                            setTimeout(() => {
                                this.codeError = "";
                                this.codeAccepted = true;
                            }, 1000);
                            setTimeout(() => {
                                document.getElementById("form2").submit();
                            }, 3000);

                            App.methods.checkUser();
                            // setTimeout(() => {
                            //     window.location = '/';
                            // }, 200);

                        } else if (response.data.user?.scope === 'admin') {
                            document.getElementById('mobileHelp').innerText = 'کاربر مجاز نیست. لطفا با ایمیل دیگری ثبت نام کنید.';
                        }


                    })
                        .catch((error) => {
                            // if (error.status === 400){
                            //     console.log(error);
                            //     console.log(error);
                            //     console.log(error.data);
                            //     console.log(error.message);
                            //     console.log(error.data.message);
                            this.codeError = error.response.data;
                            // }
                        })
                    ;

                    // this.code === "11111"
                    //     ? (setTimeout(() => {
                    //         (this.codeError = ""),
                    //             (this.codeAccepted = true);
                    //     }, 1000),
                    //         setTimeout(() => {
                    //             document.getElementById("form2").submit();
                    //         }, 3000))
                    //     : (this.codeError = "Wrong Code");
                }

                if (e.target.value.length == e.target.maxLength) {
                    e.target.nextElementSibling?.focus();
                }
            }
            ,
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
