<template>
    <div class = "row" style = "min-height:100px !important">
        <div class = "col-md-6 row justify-content-center pb-2">
            <div class = "col-10 col-md-12  px-5 p-md-0 ps-md-5" v-if = "cart.items">
                <transition name = "zoom" appear>
                    <div class = "card">
                        <div class = "card-body p-0">
                            <table class = "table mb-0" style = "vertical-align: middle;">
                                <thead>
                                <tr class = "">
                                    <th>#</th>
                                    <th></th>
                                    <th>عنوان</th>
                                    <th>تعداد</th>
                                    <th>رنگ</th>
                                    <th>تخفیف</th>
                                    <th>قیمت</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for = "(item, index) in cart.items" :key = "item.id" :data-index = "index">
                                    <th scope = "row">{{ index + 1 }}</th>
                                    <td style = "vertical-align: bottom  !important; width: 40px;filter: grayscale(100%);"  class = "text-end px-0">
                                        <img :url = "item.product.images[0]"/>
                                    </td>
                                    <td style = "vertical-align: middle;">
                                        <small class = "m-0 d-block">{{ item.product.title }}</small>
                                        <small class = "text-small text-muted m-0 fw-light d-block">{{
                                            item.product.subTitle
                                            }}</small>
                                        <!-- <small class="m-0  text-muted d-block">color</small> -->
                                    </td>
                                    <td class = "text-start ps-2" style = "vertical-align: middle  !important;">
                                        <div class = "ms-4">

                                            {{ item.quantity }}
                                        </div>
                                    </td>
                                    <td><small class = "text-muted">{{ item.size.color_name}}</small></td>
                                    <td>
                                        <small class = "text-muted">{{ item.product.price * item.product.off/100 *item.quantity }}</small>
                                    </td>
                                    <td>
                                        <small class = "text-muted">{{ item.product.price * (1 - item.product.off/100)*item.quantity }}</small>
                                    </td>
                                </tr>

                                <tr class = "pb-2 m-0 p-0 ">
                                    <td colspan = "5" class = "m-0 p-0 "></td>
                                    <td class = "text-muted">هزینه ارسال:</td>
                                    <td class = "text-muted">15000</td>
                                </tr>
                                <tr class = "pb-2 m-0 p-0 ">
                                    <td colspan = "5" class = "m-0 p-0 "></td>
                                    <td class = "fw-bold">پرداخت شما:</td>
                                    <td class = "fw-bold" >{{ cart.amount }}</td>
                                </tr>
                                </tbody>


                            </table>
                        </div>
                    </div>
                </transition>
            </div>
        </div>

        <div class = "col-md-6 row justify-content-center pb-2">
            <div class = "col-10 col-md-12  px-5 p-md-0 ps-md-5">
                <transition name = "zoom" appear>
                    <form class = "" v-if="cart && cart.user" style = "min-height:100px !important">
                        <p class = "fw-bold">ارسال شود به: </p>

                        <div v-for="(item,index) in cart.user.addresses" :key="item.id"  class = "form-check">
                            <input class = "form-check-input" type = "radio" name = "user_address_id" :value="item.id"
                                                         checked :id = "'ch_'+ index">
                              <!--     :checked="item.id === cart.user_address_id ? 'checked': false" -->

                            <label class = "form-check-label" style="cursor: pointer" :for = "'ch_'+ index">
                                {{ item.title}}  <small class = "ps-3 text-muted">
                                {{ item.state+', '+item.city +' - '+ item.address +'-   کد پستی: '+ item.postal_code  }}
                            </small>
                            </label>

                        </div>

                        <!--                        <div class = "form-check">-->
                        <!--                            <input class = "form-check-input" type = "radio" name = "flexRadioDefault" id = "flexRadioDefault2">-->
                        <!--                            <label class = "form-check-label" for = "flexRadioDefault2">-->

                        <!--                            </label>-->
                        <!--                        </div>-->
                        <p class = "fw-bold mt-4"> ثبت نشانی جدید:</p>
                        <div class = "row">
                            <div class = " col-3">
                                <label for = "title" class = "form-label">عنوان</label>
                                <input type = "text" :class = "{hasError: errors.title}" class = "form-control" id = "title" required>
                                <div class = "form-text error"></div>

                            </div>
                            <div class = " col-3">
                                <label for = "state" class = "form-label">استان</label>
                                <input type = "text" :class = "{hasError: errors.state}" class = "form-control" id = "state" required>
                                <div class = "form-text error"></div>
                            </div>
                            <div class = " col-3">
                                <label for = "city" class = "form-label">شهر</label>
                                <input type = "text" :class = "{hasError: errors.city}" class = "form-control" id = "city" required>
                                <div class = "form-text error"></div>
                            </div>
                            <div class = " col-3">
                                <label for = "postal_code" class = "form-label">کد پستی</label>
                                <input type = "text" :class = "{hasError: errors.postal_code}" class = "form-control" id = "postal_code" required>
                                <div class = "form-text error"></div>
                            </div>

                            <div class = "my-2 col-12">
                                <label for = "address" class = "form-label">نشانی</label>
                                <textarea class = "form-control" id = "address" rows = "2" required></textarea>
                                <div class = "form-text error"></div>
                            </div>
                        </div>


                        <div class = "col-12 text-end">
                            <button type = "submit" id = "submit" @click.prevent = "saveAddress" class = "btn btn-primary mb-3">
                                ثبت
                            </button>
                        </div>
                    </form>
                </transition>
            </div>
        </div>

        <div class = "col-12  row pe-4 px-md-5 m-0 justify-content-center">
            <div class = " border-top col-10 col-md-12">
                <button class = "btn btn-primary m-0 my-3" @click.prevent="saveAndPay" id = "confirm_pay">تایید و پرداخت آنلاین</button>
            </div>
        </div>
    </div>
</template>

<script>
    import {computed} from "@vue/runtime-core";
    import BaseButton from "../components/BaseButton.vue";
    import BaseImage from "../components/BaseImage.vue";
    import App from "./Site";

    export default {
        components: {BaseButton, BaseImage},
        data() {
            return {
                total: 0,
                user: {},
                errors: [],
                cart:{},
                id: this.$route.params.id,

            };
        },
        mounted() {
            App.methods.checkUser();
            // if(localStorage.length && localStorage.getItem('user')){
                // document.getElementById('cart_count').innerHTML = JSON.parse(localStorage.getItem('user'))?.cart?.items?.length || 0;
                // this.user = JSON.parse(localStorage.getItem('user'));
            // }

            document.querySelector('title').innerHTML = 'تایید نهایی | one';
            this.loadCart();

        },
        methods: {
            saveAddress() {
                this.errors = [];
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
                    axios.post('/api/address/user', {
                        user_id: this.user.id,
                        title: document.getElementById('title').value,
                        state: document.getElementById('state').value,
                        city: document.getElementById('city').value,
                        address: document.getElementById('address').value,
                        postal_code: document.getElementById('postal_code').value,

                    })
                        .then((response) => {
                            if (response.status === 201) {
                                App.methods.updateUserInfo();
                                this.user.addresses.push(response.data);
                                document.querySelectorAll('input').forEach((input)=> {
                                    input.value = '';
                                });
                                document.querySelector('textarea').value = '';
                            }
                        })
                        .catch((error) => {

                            console.log(error)
                        });
                }


            },

            loadCart() {
                axios.get('/api/cart/'+JSON.parse(localStorage.getItem('user')).id)
                    .then((response) => {
                        this.cart = response.data;
                        // this.count = this.cart?.items?.length;
                        console.log(this.cart)

                    })
                    .then(()=>{
                        App.methods.checkUser();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            saveAndPay(){
                // alert(this.cart.id);
                axios.post('api/pay/order/'+this.cart.id,{
                    user_address_id : document.querySelector( 'input[name="user_address_id"]:checked').value,
                })
                .then((response)=>{
                    console.log('res',response);
                    if (response.status === 200 && response.data.url){
                        //boro be pay online o bargard

                        window.location = response.data.url;
                    }

                })
                .catch((error)=>{
                    console.log(error)
                })
            }
        }


    }

</script>

<style scoped>
    td, th {
        border: none !important;
    }

</style>
