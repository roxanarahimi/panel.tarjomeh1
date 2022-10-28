<template>
    <div class = "container-fluid pt-5">
        <div class = "row justify-content-center px-5">
            <div class = "col-md-5 justify-content-center mb-3 pb-2" v-if = "data">
                <transition name = "zoom" appear>
                    <div class = "card card h-100">
                        <div class = "card-body p-0">
                            <table class = "table mb-0" style = "vertical-align: middle">
                                <thead>
                                <tr class = "">
                                    <th>#</th>
                                    <th></th>
                                    <th>عنوان</th>
                                    <th>سایز</th>
                                    <th>تعداد</th>
                                    <th>رنگ</th>
                                    <th>قیمت</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for = "(item, index) in data.items"
                                    :key = "item.id"
                                    :data-index = "index"
                                >
                                    <th scope = "row">{{ index + 1 }}</th>
                                    <td
                                        style = "
                        vertical-align: bottom !important;
                        width: 40px;
                        filter: grayscale(100%);
                      "
                                        class = "text-end px-0"
                                    >
                                        <img class="img-fluid" :src = "item.product.image"/>
                                    </td>
                                    <td style = "vertical-align: middle">
                                        <small class = "m-0 d-block">{{ item.product.title }}</small>
                                        <small class = "text-small text-muted m-0 fw-light d-block">{{ item.product.subTitle }}</small>
                                        <!-- <small class="m-0  text-muted d-block">color</small> -->
                                    </td>
                                    <td><small class = "text-muted">{{ item.size.size}}</small></td>

                                    <td class = "text-start ps-2" style = "vertical-align: middle !important">
                                        <div class = "ms-4">{{ item.quantity }} </div>
                                    </td>
                                    <td><small class = "text-muted">{{ item.size.color_name}}</small></td>
                                    <td>
                                        <small class = "text-muted">{{ item.product.price* (1-item.product.off/100)*item.quantity }}</small>
                                    </td>
                                </tr>

                                <tr class = "pb-2 m-0 p-0">
                                    <td colspan = "5" class = "m-0 p-0"></td>
                                    <td class = "text-muted">هزینه ارسال:</td>
                                    <td class = "text-muted">15000</td>
                                </tr>
                                <tr class = "pb-2 m-0 p-0">
                                    <td colspan = "5" class = "m-0 p-0"></td>
                                    <td class = "fw-bold">مبلغ فاکتور:</td>
                                    <td class = "fw-bold">{{ data.amount }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </transition>
            </div>

            <div class = "col-md-3 justify-content-center mb-3 pb-2">
                <transition name = "zoom" appear>
                    <div class = "card h-100">
                        <div class = "card-body">
                            <p class = "fw-bold mb-1">نشانی:</p>
                            <small v-if="data.address" class = "text-muted">
                              {{data.address.state}}, {{ data.address.city}} - {{ data.address.address }} - {{ data.address.postal_code}}
                            </small>
                            <p class = "fw-bold mb-1">تلفن:</p>
                            <small v-if="data.user" class = "text-muted">
                                {{data.user.mobile}}
                            </small>

                            <p class = "fw-bold mb-1 mt-3">وضعیت:</p>
                            <small class = "text-muted">{{ data.status}}</small>

                            <p class = "fw-bold mb-1 mt-3">کد رهگیری پست:</p>
                            <small v-if="data.status !== 'سبد خرید'" class = "text-muted">
                                {{data.post_trak_id}}
                                <span class = "mx-2">
                  <svg
                      xmlns = "http://www.w3.org/2000/svg"
                      width = "14"
                      height = "14"
                      fill = "currentColor"
                      class = "bi bi-clipboard"
                      viewBox = "0 0 16 16"
                  >
                    <path
                        d = "M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"
                    />
                    <path
                        d = "M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"
                    />
                  </svg>
                </span>
                            </small>
                            <small class = "d-block text-muted mb-1 mt-3">
                                برای پیگیری وضعیت بسته کد رهگیری را کپی و در
                                <a class = "fw-bold" href = "https://tracking.post.ir/" target = "_blank">اینجا</a>
                                جستوجو کنید
                            </small>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    import BaseImage from "../../components/BaseImage.vue";
    import App from "../Site";

    export default {
        components: {BaseImage},
        data() {
            return {
                id: this.$route.params.id,
                total: 0,
                data: {},
            };
        },
        mounted() {
            // App.methods.checkUser();
            // App.methods.updateUserInfo();

            document.querySelector('title').innerHTML = 'فاکتور | one';

            App.methods.checkUser();

            // if(localStorage.length){
            //     document.getElementById('cart_count').innerHTML = JSON.parse(localStorage.getItem('user'))?.cart?.items?.length || 0;
            // }
            this.loadOrder();
        },
        methods:{
            loadOrder(){
                axios.get('/api/order/'+this.id)
                .then((response)=>{
                    console.log('res',response);

                    if (response.status ===200)
                    {
                        this.data = response.data;
                    }
                })
                .catch((error)=>{
                    console.log(error);
                })
            }
        }
    };
</script>

<style scoped>
    td,
    th {
        border: none !important;
    }
</style>
