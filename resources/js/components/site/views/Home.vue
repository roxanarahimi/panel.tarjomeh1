<template>
    <div class = "home p-0 m-0">
        <slider/>
        <base-parallax/>

        <div   v-if = "products.length" class = "bg-light p-0 m-0  w-100" style="height: 678px !important">
            <div class = "mx-auto row  p-5 pt-2 p-md-5 p-md-5 m-0">
                <p class = "h3 text-center mb-3">محصولات جدید</p>
                <div v-for = "product in products" :key = "product.id" class = " col-12 col-md-6 col-lg-3 col-xl-3  p-1 m-0 ">
                    <productCard :product = "product"/>
                </div>
                <div class = "text-center py-2">
                    <router-link class = "btn btn-primary text-light" to = "/products">بیشتر</router-link>
                </div>
            </div>

        </div>
        <div style="height: 600px !important" v-else class = "col-12 pt-5 " id = "loader">
            <loader/>
        </div>
    </div>
</template>
<script>
    // @ is an alias to /src
    import ProductCard from "../components/ProductCard.vue";
    import BaseParallax from "../components/BaseParallax.vue";
    import Slider from "../components/Slider";
    // import App from "./Site";
    import Loader from "../components/Loader";

    export default {
        name: "Home",
        data() {
            return {
                products: [],
            };
        },
        mounted() {
            // if(localStorage.user !== undefined){
            //     // App.methods.updateUserInfo();
            //     document.getElementById('cart_count').innerHTML = JSON.parse(localStorage.getItem('user')).cart?.items?.length || 0;
            // }

            if (JSON.parse(localStorage.getItem('user'))=== null){
                console.log(localStorage);
                localStorage.removeItem('user');
                localStorage.removeItem('expire');
                localStorage.removeItem('access_token');

                document.getElementById('profile').classList.add('d-none');
                document.getElementById('logout').classList.add('d-none');
                document.getElementById('cart').classList.add('d-none');
                document.getElementById('login').classList.remove('d-none');
                document.getElementById('register').classList.remove('d-none');
            }else{
                console.log(localStorage);

                document.getElementById('profile').classList.remove('d-none');
                document.getElementById('logout').classList.remove('d-none');
                document.getElementById('cart').classList.remove('d-none');
                document.getElementById('login').classList.add('d-none');
                document.getElementById('register').classList.add('d-none');
            }
            console.log(localStorage)


            document.querySelector('title').innerHTML = 'فروشگاه آنلاین | one';

            fetch("/api/latest/product")
                .then((res) => res.json())
                // .then((data) => (this.products = data))
                .then(async (data) => {

                    await setTimeout(() => {
                        document.getElementById('loader').classList.add('d-none');
                    }, 500);
                    await setTimeout(() => {
                        this.products = data;
                        if (this.products.length === 0) {
                            // document.getElementById('msg')?.innerText = 'محصولی پیدا نشد';
                        } else {
                            // document.getElementById('msg')?.innerText = 'درحال بار گذاری...';
                        }
                    }, 600);

                })
                .catch((err) => console.log(err.message));
        },

        components: {
            ProductCard, BaseParallax, Slider, Loader
        },
    };
</script>
<style>
    /*.p-wrapper {*/
    /*    !* width: 100%; *!*/
    /*    margin: 0px auto !important;*/
    /*    display: flexbox;*/
    /*    justify-content: space-evenly !important;*/
    /*    background-color: whitesmoke;*/
    /*    border-radius: 5px;*/
    /*    padding: 20px 70px;*/
    /*}*/
</style>
