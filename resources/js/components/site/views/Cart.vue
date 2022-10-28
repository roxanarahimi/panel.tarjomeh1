<template>
    <div class = "container-fluid">
        <div class = "row  p-0 m-0">
            <div class = "col-12 col-md-6 col-lg-6  mx-auto  p-0 m-0">
                <transition name = "switch" mode = "out-in">
                    <div v-if = "count"
                         class = "card  py-0"
                         style = " position:relative !important; border-bottom: 0px !important;border-bottom-right-radius: 0; border-bottom-left-radius: 0;">

                        <table class = "table table-hover table-borderless mb-0 " style = "vertical-align: middle;">
                            <!-- <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col"></th>
                                <th scope="col">name</th>
                                <th scope="col">quantity</th>
                                <th scope="col">color</th>
                                <th scope="col">price</th>
                                <th scope="col"></th>
                              </tr>
                            </thead> -->
                            <transition-group tag = "tbody" name = "zoom" appear>
                                <tr v-for = "(item, index) in cart.items" :key = "item.id" :data-index = "index">
                                    <th scope = "row" class = "ps-4">{{ index + 1 }}</th>
                                    <td style = "vertical-align: bottom  !important; width: 80px;"
                                        class = "text-end"
                                    >
                                        <img class = "img-fluid" height = "80" :url = "item.product.images[0]"/>
                                    </td>
                                    <td style = "vertical-align: middle;">
                                        <small class = "m-0 d-block">{{ item.product.title }}</small>
                                        <small class = "text-small text-muted m-0 fw-light d-block">{{
                                            item.product.subTitle
                                            }}</small>
                                        <!-- <small class="m-0  text-muted d-block">color</small> -->
                                    </td>
                                    <td class = "ps-0" style = "vertical-align: middle  !important;">
                                        <div class = "d-flex justify-content-start m-0">

                                            <button
                                                class = "btn btn-outline-dark btn-sm p-0 my-1  q-btn"
                                                @click = "enscreaseQuantity(item.id, item.quantity)"
                                            >+
                                            </button>
                                            <input
                                                :id = "'item_'+item.id"
                                                class = "m-1 quantity fw-light"
                                                type = "number"
                                                min = "1"
                                                :value = "item.quantity"
                                            />
                                            <button
                                                class = "btn btn-outline-dark btn-sm p-0 my-1 q-btn"
                                                @click = "decreaseQuantity(item.id, item.quantity)"
                                            >
                                                -
                                            </button>

                                        </div>
                                    </td>
                                    <td><small class = "text-muted">{{item.size.size}} - {{
                                        item.size.color_name}}</small></td>
                                    <td>
                                        <small class = "text-muted">{{ item.price * (1-item.off/100)*item.quantity
                                            }}</small>
                                    </td>
                                    <td class = "text-end">
                                        <button class = "btn btn-sm btn-outline-dark q-btn  p-0 me-3" @click = "removeRow(item.id)">
                                            <i class = "bi bi-x"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr class = "pb-2 m-0 p-0 ">
                                    <td colspan = "2" class = "m-0 p-0 "></td>
                                    <td>هزینه ارسال:</td>
                                    <td>15000</td>
                                    <td>پرداخت شما:</td>
                                    <td id = "amount">{{ cart.amount }}</td>
                                    <td></td>
                                </tr>
                                <tr class = "pb-2 m-0 p-0">
                                    <td colspan = "7" class = "m-0 p-0">
                                        <div class = "d-flex justify-content-between border-bottom">
                                            <router-link to = "/confirmOrder" class = "btn btn-primary m-2">
                                                تائید سفارش
                                            </router-link>
                                            <router-link to = "/products" class = "btn btn-info text-light m-2">
                                                خرید بیشتر
                                            </router-link>
                                        </div>
                                    </td>
                                </tr>
                            </transition-group>
                        </table>
                    </div>
                    <div v-else>
                        <div  class = "col-12">
<!--                            <p id = "msg" class = "my-4">درحال بار گذاری... </p>-->
                            <p v-if = "count !== 0" id = "msg1" class = "my-4">درحال بار گذاری... </p>
                            <p v-else id = "msg2" class = "my-4">سبد شما خالی است </p>
                        </div>
<!--                        <div class = "col-12" id = "loader">-->
<!--                            <loader/>-->
<!--                        </div>-->
                    </div>

                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    import {computed} from "@vue/runtime-core";
    import BaseButton from "../components/BaseButton.vue";
    import BaseImage from "../components/BaseImage.vue";
    import App from "../views/Site.vue";
    import Loader from "../components/Loader";

    export default {
        components: {BaseButton, BaseImage, Loader},
        data() {
            return {
                count: 0,
                total: 0,
                user: {},
            };
        },
        mounted() {
            // App.methods.updateUserInfo();
            //
            // if (localStorage.length) {
            //     document.getElementById('cart_count').innerHTML = JSON.parse(localStorage.getItem('user')).cart?.items?.length || 0;
            // }
            document.querySelector('title').innerHTML = 'سبد خرید | one';
            if (localStorage.user && JSON.parse(localStorage.user).scope === 'user') {
                this.user = JSON.parse(localStorage.user);
            }
            this.loadCart();

            App.methods.checkUser();
        },
        methods: {

            loadCart() {
                this.cart = [];
                axios.get('/api/cart/' + this.user.id)
                    .then((response) => {

                        this.cart = response.data;
                        this.count = this.cart.items.length;

                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            removeRow(id) {

                this.cart.items = this.cart.items.filter((i) => i.id !== id);
                this.count--;
                axios.post('/api/item/remove', {order_item_id: id})
                    .then((response) => {
                        if (response.status === 200) {
                            this.cart = response.data;
                            if (localStorage.length) {
                                document.getElementById('cart_count').innerHTML = JSON.parse(localStorage.getItem('user'))?.cart?.items?.length || 0;
                            }
                        }
                    })
                    .then(() => {
                        if(document.getElementById('amount')) {
                            document.getElementById('amount').innerText = this.cart.amount;
                        }
                    })
                    .then(() => {
                        App.methods.updateUserInfo();
                    })
                    .catch((error) => {
                        console.error(error);
                        console.error(error.data)
                        console.error(error.message)
                    });

            },
            enscreaseQuantity(id) {
                let q = this.cart?.items?.find((i) => i.id === id);
                q.quantity += 1;
                document.getElementById('item_' + id).value = q.quantity;

                this.updateQuantity(id, q.quantity);
                this.loadCart();
            },
            decreaseQuantity(id, quantity) {
                if (quantity > 1) {
                    let z = this.cart?.items?.find((j) => j.id === id);
                    z.quantity -= 1;
                    document.getElementById('item_' + id).value = z.quantity;

                    this.updateQuantity(id, z.quantity);
                    this.loadCart();

                }
            },
            updateQuantity(item_id, quantity) {
                axios.post('/api/item/quantity/update', {item_id: item_id, quantity: quantity})
                    .then((response) => {
                        if (response.status === 200) {
                            this.cart = response.data;
                            if(document.getElementById('amount')) {
                                document.getElementById('amount').innerText = this.cart.amount;
                            }
                        }

                    })
                    .then(() => {
                        App.methods.updateUserInfo();
                    })
                    .catch((error) => {
                        console.error(error);
                        console.error(error.data)
                        console.error(error.message)
                        // console.log(error.data.message)

                    });

            },


        },

    };
</script>
<style scoped>
    input[type="number"] {
        background-color: transparent;
        border-radius: 3px;
        border: 0px solid lightgray;
        background: white;
        height: 20px;
        width: 23px;
        font-size: 12px;
        text-align: center !important;
        margin-top: 2px;
    }

    .q-btn {
        width: 20px !important;
        height: 20px !important;
        line-height: 10px !important;
    }
</style>
