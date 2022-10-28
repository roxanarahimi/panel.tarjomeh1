<template>
    <div class = "m-0 p-0" id = "outerr">
        <div class = "text-right" v-show = "showNav" id = "nav">
            <router-link class = "" to = "/"> خانه </router-link>
            <router-link class = "btn-ox" id = "products" to = "/products"> محصولات  </router-link>
            <router-link class = "btn-ox" id = "profile" to = "/profile"> پروفایل </router-link>
            <router-link class = "btn-ox " id = "login" to = "/login"> ورود</router-link>
            <router-link class = "btn-ox " id = "register" to = "/register"> ثبت نام </router-link>
            <router-link class = "btn-ox" id = "cart" to = "/cart">سبد خرید
                <span id = "cart_count" class = " position-absolute ms-3 start-10 translate-middle badge bg-primary"></span>
            </router-link>
            <a role = "button" class = "btn-ox d-none float-end" id = "logout" @click = "logoutUser"> خروج </a>

        </div>
        <!-- <transition name="route" mode="out-in">
          <router-view />
        </transition> -->
        <!-- <transition name="route" mode="out-in">
          <keep-alive>
           <router-view />
          </keep-alive>
        </transition> -->
        <router-view style = "min-height: 428px !important" v-slot = "{ Component }">
            <transition name = "route" mode = "out-in" appear>
                <component :is = "Component"></component>
            </transition>
        </router-view>
        <the-footer/>

    </div>
</template>

<script>
    import TheFooter from './TheFooter.vue';

    export default {
        components: {TheFooter},

        data() {
            return {
                showNav: true,
                user: {},
                cartItems: 0,
                // showLogin:JSON.parse(localStorage.getItem('user'))=== null,
                // showLogin: !localStorage.getItem('user'),
                // showProfile: !this.showLogin,
            };
        },
        watch: {
            "$route.name": {
                handler: function (name) {
                    this.showNav = !(name === "Error404");
                },
                deep: true,
                immediate: true,
            },
        },
        mounted() {
            // this.checkUser();
            this.updateUserInfo();
            // if(localStorage.length && JSON.parse(localStorage.getItem('user')).cart){
            //     if(JSON.parse(localStorage.getItem('user')).cart.items){
            //         document.getElementById('cart_count').innerHTML = JSON.parse(localStorage.getItem('user')).cart.items.length;
            //
            //     }
            //
            // }
        },
        methods: {

            updateUserInfo() {
                if (localStorage.getItem('user')) {
                    axios.get('/api/user/' + JSON.parse(localStorage.getItem('user')).id)
                        .then(async (response) => {

                            if (response.status === 200 && response.data.scope === 'user') {
                                await localStorage.setItem('user', JSON.stringify(response.data));
                                await console.log ('too',response.data)
                                this.user = response.data;

                            }
                        })
                        .then(() => {
                            // if(this.user?.cart?.items?.length) {
                            // document.getElementById('cart_count').classList.remove('d-none')
                            if (this.user?.cart?.items?.length === undefined || this.user?.cart?.items?.length === 0) {
                                document.getElementById('cart_count').innerHTML = '';
                            } else {
                                document.getElementById('cart_count').innerHTML = this.user?.cart?.items?.length;

                            }
                            // }  // }else{
                            //     document.getElementById('cart_count').classList.add('d-none')
                            // }
                            // if (this.user){
                            //     console.log(this.user);
                            //     console.log(this.user.cart);
                            //     console.log(this.user.cart.items);
                            //     console.log(this.user.cart.items?.length);
                            //     console.log(this.user.cart-items-count);
                            // }
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                }

            },


            checkUser() {
                this.updateUserInfo();
                if (!localStorage.user) {
                    document.getElementById('profile').classList.add('d-none');
                    document.getElementById('logout').classList.add('d-none');
                    document.getElementById('cart').classList.add('d-none');
                    document.getElementById('login').classList.remove('d-none');
                    document.getElementById('register').classList.remove('d-none');
                } else {
                    document.getElementById('profile').classList.remove('d-none');
                    document.getElementById('logout').classList.remove('d-none');
                    document.getElementById('cart').classList.remove('d-none');
                    document.getElementById('login').classList.add('d-none');
                    document.getElementById('register').classList.add('d-none');
                }
            },
            logoutUser() {
                if (JSON.parse(localStorage.getItem('user')) === null) {
                    localStorage.removeItem('user');
                    localStorage.removeItem('expire');
                    localStorage.removeItem('access_token');

                    document.getElementById('profile').classList.add('d-none');
                    document.getElementById('logout').classList.add('d-none');
                    document.getElementById('cart').classList.add('d-none');
                    document.getElementById('login').classList.remove('d-none');
                    document.getElementById('register').classList.remove('d-none');
                    window.location = '/'
                } else {
                    document.getElementById('logout').classList.add('d-none');

                    axios.get('/api/user/logout/' + JSON.parse(localStorage.getItem('user'))?.id)
                        .then((response) => {
                            if (response.status === 200) {
                                //exit
                                document.getElementById('profile').classList.add('d-none');
                                document.getElementById('logout').classList.add('d-none');
                                document.getElementById('cart').classList.add('d-none');
                                document.getElementById('login').classList.remove('d-none');
                                document.getElementById('register').classList.remove('d-none');
                                // localStorage.clear();
                                localStorage.removeItem('user');
                                localStorage.removeItem('expire');
                                localStorage.removeItem('access_token');

                                window.location = '/'

                            }
                        })
                        .catch((error) => {
                            console.log(error)
                            console.log(error.message)
                            console.log(error.status)
                        });
                }


            },

        }
        ,
        updated() {
            console.log(localStorage);


        }
    }
    ;
</script>

<style>
    .error {
        color: lightcoral;
    }

    .hasError {
        border: 1.2px solid lightcoral !important;
        box-shadow: none !important;
    }

    #nav > a {
        margin-right: 10px;
        margin-left: 10px;
    }
</style>
