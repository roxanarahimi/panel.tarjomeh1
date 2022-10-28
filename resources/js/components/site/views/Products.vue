<template>


    <div class = "container-fluid p-0 pt-3">
        <div class = "row">
            <div class = "col-4  col-lg-2 h-100 products_side">
                <div class = "card ps-3 ps-xl-5 pe-3 pt-5 pb-5 ms-2">
                    <div class = "form-check mx-1">
                        <input class = "form-check-input" @change = "getInfo" type = "checkbox" id = "stock"/>
                        <label class = "form-check-label" for = "stock">کالاهای موجود</label>
                    </div>
                    <div class = "form-check mx-1">
                        <input class = "form-check-input" type = "checkbox" @change = "getInfo" value = "" id = "off">
                        <label class = "form-check-label" for = "off">
                            تخفیف
                        </label>
                    </div>
                    <hr class = "text-muted">
                    <p class = "fw-bold mt-3">دسته بندی</p>
                    <div v-for = "item in categories" class = "form-check mx-1">
                        <input class = "form-check-input" type = "checkbox" @change = "getInfo" name = "cat_id" :value = "item.id" :id = "'cat_'+item.id">
                        <label class = "form-check-label" :for = "'cat_'+item.id">
                            {{ item.title }}
                        </label>
                    </div>


                </div>
            </div>

            <div class = "col-8  col-lg-10 " style = "min-height: 500px !important">

                <div class = "row px-3 px-md-5">

                    <!--                   -->
                    <!--                        position: absolute; right:55%; top:200px;z-index:100-->

                    <!--                    </div>-->

                    <div class = "col-lg-3 d-flex justify-content-center justify-content-lg-start px-1 mb-3 mb-lg-0 ">
                        <div class = "w-100">
                            <input type = "text" class = "form-control" id = "search" @input = "getInfo" placeholder = "جستوجوی محصول...">
                        </div>
                    </div>
                    <div class = "col-lg-9 d-flex-wrap d-lg-flex justify-content-between justify-content-lg-end  px-1 ">
                        <button class = "sort btn btn-sm btn-primary ms-1 mb-2 mb-lg-0" id = "new" @click = "sortBy('new')">
                            جدید ترین</button>
                        <button class = "sort btn btn-sm btn-outline-primary ms-1 mb-2 mb-lg-0" id = "sale" @click = "sortBy('sale')">
                            پرفروش ترین
                        </button>
                        <button class = "sort btn btn-sm btn-outline-primary ms-1 mb-2 mb-lg-0" id = "score" @click = "sortBy('score')">
                            محبوب ترین
                        </button>
                        <button class = "sort btn btn-sm btn-outline-primary ms-1 mb-2 mb-lg-0" id = "view" @click = "sortBy('view')">
                            پربازدید ترین
                        </button>
                        <button class = "sort btn btn-sm btn-outline-primary ms-1 mb-2 mb-lg-0" id = "cheap" @click = "sortBy('cheap')">
                            ارزان ترین
                        </button>
                        <button class = "sort btn btn-sm btn-outline-primary ms-1 mb-2 mb-lg-0" id = "expensive" @click = "sortBy('expensive')">
                            گران ترین
                        </button>
                    </div>


                    <div class = "col-12 p-0 m-0" v-if = "products.length">


                        <div class = "mx-auto row  py-5 pt-2 ">


                            <div v-for = "product in products" :key = "product.id" class = " col-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3 p-1">
                                <div class = " border border rounded ">
                                    <productCard :product = "product"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-12" v-else>
<!--                        <p id = "msg" class = "my-4">درحال بار گذاری... </p>-->
                        <p id = "msg" class = "my-4"></p>
                    </div>
                    <div class = "col-12" id = "loader">
                      <loader/>
                    </div>
                </div>


            </div>
        </div>


    </div>
</template>

<script>
    import ProductCard from "../components/ProductCard.vue";
    import Loader from "../components/Loader";
    import App from "./Site";

    export default {
        components: {
            ProductCard,
            App,
            Loader
        },
        name: "Products",
        data() {
            return {
                products: [],
                categories: [],
            };
        },
        mounted() {
            App.methods.checkUser();
            // if(localStorage.length){
            //     App.methods.updateUserInfo();
            //     document.getElementById('cart_count').innerHTML = JSON.parse(localStorage.getItem('user')).cart?.items?.length || 0;
            // }

            document.querySelector('title').innerHTML = 'محصولات | one';
            document.addEventListener('scroll', () => {
                let top = document.documentElement.scrollTop;
                if (document.querySelector('.products_side > .card') && top > 100) {
                    document.querySelector('.products_side > .card')?.setAttribute('style', 'top:10px');
                } else {
                    document.querySelector('.products_side > .card')?.removeAttribute('style');
                }
            });
            //this.load();
            this.getCategories();
            this.getInfo();


        },
        methods: {
            getInfo() {
                let cats = '';
                document.getElementsByName('cat_id').forEach((c) => {
                    if (c.checked === true) {
                        if (cats !== '') {
                            cats += ',';
                        }
                        cats += c.value;
                    }
                })

                this.products = [];
                let params = '?stock=' + document.getElementById('stock').checked + '&cat_ids=' + cats
                    + '&off=' + document.getElementById('off').checked
                    + '&sort=' + document.querySelector('.sort.btn-primary').getAttribute('id')
                    + '&search=' + document.getElementById('search').value
                ;

                console.log(params)
                document.getElementById('loader').classList.remove('d-none');
                fetch("/api/product" + params)
                    .then((res) => res.json())
                    .then(async (data) => {

                        await setTimeout(() => {
                            document.getElementById('loader')?.classList.add('d-none');
                        }, 500);
                        await setTimeout(() => {
                            this.products = data;
                            if(document.getElementById('msg')){
                                if (this.products.length === 0) {
                                    document.getElementById('msg').innerText = 'محصولی پیدا نشد';
                                } else {
                                    document.getElementById('msg').innerText = 'درحال بار گذاری...';
                                }
                            }

                        }, 600);

                    })
                    .catch((err) => console.log(err.message));

            },
            getCategories() {
                fetch("/api/category/product")
                    .then((res) => res.json())
                    .then((data) => {

                        this.categories = data;

                    })
                    .catch((err) => console.log(err.message));
            },
            async sortBy(property) {
                function a() {
                    let prev = document.querySelector(".btn-primary");
                    prev.classList.remove("btn-primary");
                    prev.classList.add("btn-outline-primary");


                    var element = document.getElementById(property);
                    element.classList.remove("btn-outline-primary");
                    element.classList.add("btn-primary");
                }

                await a();
                await this.getInfo();


            }
        },


    };
</script>

<style scoped>
    label, input[type=checkbox] {
        cursor: pointer;
    }

    .products_side .card {
        /*border: 1px solid lightgray;*/
        /*border-right: none;*/
        /*border-radius: 3px;*/
        /*position: -webkit-sticky !important; !* Safari *!*/
        /*position: sticky !important;*/
        /*top: 0 !important;*/

        transition: 1s ease;
        position: fixed;
        width: inherit;
    }
  </style>
