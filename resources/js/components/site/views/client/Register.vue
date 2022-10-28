<template>
    <div class = "row justify-content-center text-left">
        <div class = "col-md-10 col-lg-8 row  pt-5 justify-content-center">
            <div class = "col-12 col-md-10 col-xl-6">
                <div class = "card mb-5">
                    <div class = "card-body">
                        <p class = "h5 card-title text-center">ثبت نام کنید</p>
                        <p id = "registerMsg" class = "text-center h5 text-success d-none fw-bolder mt-2">
                            ثبت نام با موفقیت انجام شد. لطفا
                            <router-link class="text-primary text-decoration-underline"  to="/login">وارد شوید</router-link>
                        </p>

                        <form  autocomplete="off">
                           <div class="row">
                               <div class = "col-lg-6 mb-3">
                                   <label for = "name" class = "form-label">نام</label>
                                   <input id = "name" type = "text" :class = "{hasError: errors.name}" class = "form-control" name = "name" aria-describedby = "nameHelp" required>
                                   <div id = "nameHelp" class = "form-text error"></div>
                                   <p class = "form-text error m-0" v-for = "e in errors.name">{{ e }}</p>
                               </div>
                               <div class = "col-lg-6 mb-3">
                                   <label for = "mobile" class = "form-label">شماره همراه</label>
                                   <input id = "mobile" placeholder="09 _ _ _ _ _ _ _ _ _ _ _" type = "text" :class = "{hasError: errors.mobile}" class = "form-control" name = "mobile" aria-describedby = "mobileHelp" required>
                                   <div id = "mobileHelp" class = "form-text error"></div>
                                   <p class = "form-text error m-0" v-for = "e in errors.mobile">{{ e }}</p>
                               </div>
                               <div class = "col-lg-6 mb-3">
                                   <label for = "email" class = "form-label">ایمیل</label>
                                   <input  autocomplete="off" id = "email" type = "email" :class = "{hasError: errors.email}" class = "form-control" name = "email" aria-describedby = "emailHelp" required>
                                   <div id = "emailHelp" class = "form-text error"></div>
                                   <p class = "form-text error m-0" v-for = "e in errors.email">{{ e }}</p>
                               </div>
                               <div class = "col-lg-6 mb-3">
                                   <label for = "password" class = "form-label">کلمه عبور</label>
                                   <input type = "password" :class = "{hasError: errors.password}" class = "form-control" name = "password" id = "password" aria-describedby = "passwordHelp" required>
                                   <div id = "passwordHelp" class = "form-text error"></div>
                                   <p class = "form-text error m-0" v-for = "e in errors.password">{{ e }}</p>
                               </div>
                           </div>
                            <button type = "submit" @click.prevent = "submit" class = "btn btn-primary">ثبت نام</button>
                            <small class="d-block mt-4 mb-1">حساب کاربری دارید؟ <router-link to="/login">اینجا</router-link> وارد شوید</small>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                errors: [],
            }
        },
        mounted() {
            document.querySelector('title').innerHTML = 'ثبت نام | one';
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
                document.getElementById('registerMsg').classList.add('d-none');
                let emptyFieldsCount = 0;
                let req = document.querySelectorAll('[required]');
                req.forEach((element) => {
                    if (element.value == "") {
                        element.classList.add('hasError');
                        element.nextSibling.innerHTML = "فیلد اجباری";
                        emptyFieldsCount++;
                    } else {
                        element.classList.remove('hasError');
                        element.nextSibling.innerHTML = "";
                    }
                });
                if (emptyFieldsCount == 0) {
                    this.errors = [];
                    axios.post('api/user/register', {
                        name: document.querySelector('#name').value,
                        email: document.querySelector('#email').value,
                        password: document.querySelector('#password').value,
                    })
                        .then((response) => {
                            console.log(response)
                            if (response.status == 201 || response.status == 200) {
                                setTimeout(() => {
                                    // this.$router.push({name: 'Login'});
                                    document.querySelector('#name').value = '';
                                    document.querySelector('#email').value = '';
                                    document.querySelector('#password').value = '';
                                    document.getElementById('registerMsg').classList.remove('d-none');
                                }, 200);
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                            // console.log(error.response);

                            if (error.response.status == 422) {
                                let errorList = Array(error.response.data);
                                console.log(error.response.data);
                                for (var i = 0; i < errorList.length; i++) {
                                    console.log('i', errorList[i]);
                                    this.errors = errorList[i];
                                }
                            } else {
                                console.log(error);
                            }
                            console.log('errs:', this.errors);
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

    #name {
        direction: rtl !important;
        text-align: right !important;
    }

</style>
