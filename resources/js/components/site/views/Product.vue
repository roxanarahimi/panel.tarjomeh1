<template>
    <div class = "container-fluid">
        <base-toast v-show = "showToast" title = "<i class='bi bi-check'></i> انجام شد" text = "به سبد خرید اضافه شد :)" type = "success"/>
        <div class = "row col-12 p-1 p-md-5 col-sm-8 col-md-8 col-lg-10 mx-auto" v-if = "product">
            <div class = "col-12 col-lg-7 col-xl-5  mb-3 mb-xl-0 pics">
                <images :images="product.images" class="col-xl-5 mb-3 h-100 index_image "/>
            </div>
            <div class = "col-12 col-lg-5 col-xl-4 offset-xl-3  buy" style = "display :grid">

                <div class = "col-12 card rounded p-3" style = "display:grid;align-self: start;">
                    <div style = "align-self: end">
                        <p class = " fw-bold my-3  ">سفارش محصول</p>

                        <div class = "d-flex w-100 py-1 ">
                            <!-- should be radio -->

                            <div v-for = "(color,index) in colors" :key = "index" class = "color-border">
                                <div @click = "selectColor(index)" class = "color-circle" :data-name = "color.color_name" :style = "'background-color:'+ color.color_code+';'"/>
                            </div>
                        </div>
                        <p id = "selected_color" class = "mb-3 mt-1"></p>

                        <select id = "size_id" class = "form-select form-select-sm m-0">
                            <!--                            <option value = ""></option>-->
                            <option @select = "showDimensions(size.dimensions)" class = "option " v-for = "(size, i) in sizes" :key = "i" :value = "size.id" :data-dimensions = "size.dimensions">
                                {{size.size}} {{size.dimensions}}

                            </option>
                        </select>
                        <p id = "dimensions" class = "my-3"></p>


                        <p class = "card-text text-muted fw-bold d-inline me-2" id = "offPrice" v-if = "product.stock">
                            {{ product.price - (product.price * parseInt(product.off)/100)}}
                            تومان
                        </p>
                        <p class = "card-text text-muted d-inline text-decoration-line-through" v-if = "product.off && product.stock">
                            {{ product.price }}
                            <span class = "badge bg-danger mx-1" v-if = "product.off">{{ product.off }}%</span>
                        </p>
                        <button class = "btn btn-primary w-100 btn-sm mt-2 " style = " width: calc(100% - 20px);"
                                v-if = "product.stock" @click = "addToCard">
                            افرودن به سبد خرید
                        </button>
                        <p class = "d-inline-block fw-bold mt-3" v-if = "!product.stock">تمام شد</p>

                    </div>
                </div>
                <div style = "align-self: end">
                    <h3 style = " margin:5px 0px 0px 10px; color:#0d6efd ">
                        {{ product.title }}
                    </h3>
                    <p style = " margin:5px 0px 0px 10px ">{{ product.subTitle }}</p>
                </div>

            </div>

            <div class = "col-12 mt-4">
                <ul class = "nav nav-tabs" id = "myTab" role = "tablist">
                    <li class = "nav-item" role = "presentation">
                        <button class = "nav-link active" id = "home-tab" data-bs-toggle = "tab" data-bs-target = "#home" type = "button" role = "tab" aria-controls = "home" aria-selected = "true">
                            توضیحات
                        </button>
                    </li>
                    <li class = "nav-item" role = "presentation">
                        <button class = "nav-link" id = "profile-tab" data-bs-toggle = "tab" data-bs-target = "#profile" type = "button" role = "tab" aria-controls = "profile" aria-selected = "false">
                            مشخصات
                        </button>
                    </li>
                </ul>
                <div class = "tab-content" id = "myTabContent">
                    <div class = "tab-pane fade show active border py-4 px-4" id = "home" role = "tabpanel" aria-labelledby = "home-tab">
                        {{ product.text }}
                    </div>
                    <div class = "tab-pane fade border p-4" id = "profile" role = "tabpanel" aria-labelledby = "profile-tab">

                        <table class = "table">

                            <tbody>
                            <tr v-for = "item in features">
                                <th scope = "row">{{ item.label}}</th>
                                <td>{{ item.value}}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                <!--                <p style = "text-align: justify !important">-->
                <!--                    {{ product.text }}-->
                <!--                </p>-->
            </div>
        </div>
    </div>
</template>

<script>
    import BaseToast from "../components/BaseToast.vue";
    import BaseImage from "../components/BaseImage.vue";
    import App from "./Site";
    import Images from "../../components/Images";

    export default {
        components: {Images, BaseToast, BaseImage},
        name: "Product",

        // props: ["id"],
        data() {
            return {
                id: this.$route.params.id,
                product: null,
                features: [],
                showToast: false,
                colors: [],
                sizes: [],
                user: {},
            };
        },
        mounted() {
            App.methods.checkUser();
            // if(localStorage.length){
            //     document.getElementById('cart_count').innerHTML = JSON.parse(localStorage.getItem('user'))?.cart?.items?.length || 0;
            // }


            if (localStorage.user && JSON.parse(localStorage.user).scope === 'user') {
                this.user = JSON.parse(localStorage.user);
            }

            axios.get("/api/product/" + this.id)
                .then((res) => {
                    this.product = res.data.product;
                    // this.colors = res.data.colors;
                    let q = res.data.colors;
                    let i = 0;
                    for (i; i <= 30; i++) {
                        if (q[i]) {
                            this.colors.push(JSON.parse(q[i]));
                        }
                    }
                    document.querySelector('title').innerHTML = 'one | ' + this.product.title;
                    if (this.product.features) {
                        for (let i = 0; i < JSON.parse(this.product.features).length; i++) {
                            this.features.push(JSON.parse(this.product.features)[i]);
                        }
                    }
                    if (this.product.colors) {
                        for (let i = 0; i < JSON.parse(this.product.features).length; i++) {
                            this.features.push(JSON.parse(this.product.features)[i]);
                        }
                    }
                })
                .then(() => {
                    this.selectColor(0);
                })
                .catch((err) => {
                    console.log(err)
                });
        },
        methods: {
            addToCard() {
                if (!this.user) {
                    alert('لطفا برای سفارش محصول ابتدا از منوی ورود وارد اکانت خود شوید.')
                } else {


                    axios.post("/api/order", {
                        user_id: JSON.parse(localStorage.user).id,
                        product_id: this.product.id,
                        product_size_id: document.getElementById('size_id').value,
                        quantity: 1,
                        price: this.product.price,
                        off: this.product.off
                    })
                        .then((response) => {
                            if (response.status === 200 || response.status === 201) {
                                localStorage.setItem('expire', response.data.expire);
                                localStorage.setItem('ppp', response.data.items.length);
                                // if(localStorage.length){
                                //
                                //     document.getElementById('cart_count').innerHTML = response.data.items.length;
                                // }

                            }
                        })
                        .then(() => {
                            this.showToast = true;
                            setTimeout(() => (this.showToast = false), 3000);
                            // App.methods.updateUserInfo();
                            // document.getElementById('cart_count').innerHTML = JSON.parse(localStorage.getItem('user')).cart?.items?.length || 0;

                        })
                        .then(()=>{
                            App.methods.checkUser();

                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            },
            selectColor(index) {
                if (document.querySelector('.selected_color')) {
                    document.querySelector('.selected_color').classList.remove('selected_color');
                }
                if (document.querySelectorAll('.color-circle') && document.querySelectorAll('.color-circle')[index]) {
                    document.querySelectorAll('.color-circle')[index].classList.add('selected_color');

                }
                if (document.querySelector('.selected_color')) {
                    document.querySelector('#selected_color').innerText = document.querySelector('.selected_color').getAttribute('data-name');
                }
                if (document.querySelector('.selected_color')) {

                    let color = document.querySelector('.selected_color').getAttribute('data-name');

                    axios.get("/api/sizes/product/" + this.id + '/' + color)
                        .then(async (res) => {
                            this.sizes = [];
                            let j = 0;
                            for (j; j < res.data.length; j++) {
                                this.sizes.push((res.data)[j]);
                            }
                      document.querySelector('#dimensions').innerText = '';
                        })
                        .catch((err) => {
                            console.log(err);
                        });
                }
            },
            showDimensions(txt) {
                alert(txt);
                document.getElementById('dimensions').innerText = txt;
            }

        },
    };
</script>

<style scoped>
    .color-border {
        border: 3px solid cadetblue;
        border-radius: 50%;
        margin: 1px;
        cursor: pointer;
        background-color: lightgray !important;

    }

    .color-circle {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        margin: 2px;
    }

    .selected_color {
        width: 22px !important;
        height: 22px !important;
        margin: 0 !important;

    }

    .p-wrapper {
        width: 70%;
        margin: 0px auto !important;
        display: flexbox;
        justify-content: space-evenly !important;
        background-color: transparent;
        border-radius: 5px;
        padding: 20px 70px;
    }

    .tab-pane {
        border-top: none !important;
        min-height: 200px;
        text-align: justify;
        border-radius: 5px;
    }

    th, td, tr {
        border: none !important;
    }

    th {
        width: 100px;
    }
</style>
