<template>
    <div class = "row justify-content-center text-left">
        <div class = "col-md-10 col-lg-8 row  pt-5 justify-content-center">
            <div class = "col-12 col-md-10 col-xl-6">
                <div class = "card mb-5">
                    <div class = "card-body">
                        <p class = "h5 card-title text-center">وارد شوید</p>
                        <form autocomplete = "off">
                            <div class = "mb-3">
                                <label for = "username" class = "form-label">ایمیل</label>
                                <input id = "username" type = "email" :class = "{hasError: errors.email}" class = "form-control" name = "email" aria-describedby = "emailHelp" required>
                                <div id = "emailHelp" class = "form-text error"></div>
                                <p class = "form-text error m-0" v-for = "e in errors.email">{{ e }}</p>
                            </div>
                            <div class = "mb-3">
                                <label for = "password" class = "form-label">کلمه عبور</label>
                                <input type = "password" :class = "{hasError: errors.password}" class = "form-control" name = "password" id = "password" aria-describedby = "passwordHelp" required>
                                <div id = "passwordHelp" class = "form-text error"></div>
                                <p class = "form-text error m-0" v-for = "e in errors.password">{{ e }}</p>
                            </div>
                            <button type = "submit" @click.prevent = "submit" class = "btn btn-primary">ورود</button>
                            <router-link to="/otp/login"><small class="mx-3">ورود با شماره همراه</small></router-link>
                            <small class = "d-block mt-4 mb-1">حساب کاربری ندارید؟
                                <router-link to = "/register">اینجا</router-link>
                                ثبت نام کنید</small>

                            <!--                            <small class = "px-2 text-center fw-bolder mt-2">-->
                            <!--                                <router-link class="text-primary text-decoration-underline"  to="/reset/password/email">فراموشی رمز</router-link>-->
                            <!--                            </small>-->
                            <!--                            <small class = "px-2 text-center fw-bolder mt-2">-->
                            <!--                            حساب کاربری ندارید؟-->
                            <!--                            <router-link class="text-primary text-decoration-underline"  to="/register">ثبت نام کنید</router-link>-->
                            <!--                        </small>-->
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    import App from "./../Site";

    export default {
        data() {
            return {
                errors: [],
            }
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
            submit() {
                localStorage.clear();
                let emptyFieldsCount = 0;
                let req = document.querySelectorAll('[required]');
                req.forEach((element) => {
                    if (element.value === "") {
                        element.classList.add('hasError');
                        element.nextSibling.innerHTML = "فیلد اجباری";
                        emptyFieldsCount++;
                    } else {
                        element.classList.remove('hasError');
                        element.nextSibling.innerHTML = "";
                    }
                });
                if (emptyFieldsCount === 0) {
                    this.errors = [];
                    axios.post('/api/user/login', {
                        username: document.querySelector('#username').value,
                        password: document.querySelector('#password').value,
                    })
                        .then((response) => {
                            if (response.status === 200 && response.data.user?.scope === 'user') {
                                //enter
                                async function jobs() {
                                    await localStorage.removeItem('admin');
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
                                App.methods.checkUser();
                                setTimeout(() => {
                                     window.location = '/';
                                }, 200);

                            }else if(response.data.user?.scope === 'admin'){
                                document.getElementById('emailHelp').innerText = 'کاربر مجاز نیست. لطفا با ایمیل دیگری ثبت نام کنید.';
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                            if (error.status === 422) {
                                let errorList = Array(error.response.data);
                                console.log(error.response.data);
                                for (var i = 0; i < errorList.length; i++) {
                                    console.log('i', errorList[i]);
                                    this.errors = errorList[i];
                                }
                            } else {
                                console.log(error);
                            }
                           // console.log('errs:', this.errors);
                        })
                }

            }
        }
    }
</script>
<style scoped>
    input {
        direction: ltr !important;
        text-align: left !important;
    }
</style>
