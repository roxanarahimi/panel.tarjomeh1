<template>
    <div>
        <div class = "container-fluid p-5">
            <div class = "row justify-content-center">
                <div class = "col-md-8">
                    <div class = "card" v-if = "orders" style = "min-height: 200px">
                        <div class = "card-body pb-0">
                            <div class = "card-title d-flex fw-bold">
                                <p class = " me-2">سفارش های شما</p>

                            </div>

                            <table class = "table" id = "order-table">
                                <tbody>
                                <tr v-for = "item in orders" :key = "item.id">
                                    <th class = "align-bottom pb-1" scope = "row">
                                        <router-link :to = "'/order/'+item.id">{{ item.code || 'در انتظار تایید'}}
                                        </router-link>
                                    </th>
                                    <td class = "pt-0" style = "vertical-align: top !important">
                                        <p class = "m-0 mb-1">{{ item.status }} </p>
                                        <div class = "progress " style = "height: 5px">
                                            <div
                                                :class = "'progress-bar order_status rounded ' + item.color"
                                                role = "progressbar"
                                                :style = "'width: '+ item.percent+'%'"
                                                :aria-valuenow = "item.percent"
                                                aria-valuemin = "0"
                                                aria-valuemax = "100"
                                            ></div>
                                        </div>
                                    </td>
                                    <td>{{ item.created_at}}</td>
                                    <td>
                                        <!--                                    <span v-show = "item.status ===  'سبد خرید' || item.status === 'در حال پردازش'"-->
                                        <!--                                          class = "btn p-0 ms-1 text-primary" id = "edit" @click = "editOrder(item.id)">-->
                                        <!--                                        <i class = "bi bi-pencil-fill"></i>-->
                                        <!--                                    </span>-->
                                        <span v-show = "item.status === 'در حال پردازش' "
                                              class = "btn p-0 ms-1 text-danger" id = "cancel" data-bs-toggle = "modal"
                                              data-bs-target = "#exampleModal" @click = "showCancelModal(item.id)">
                                        <i class = "bi bi-x-lg"></i>
                                    </span>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Modal -->
        <div class = "modal fade" id = "exampleModal" tabindex = "-1" aria-labelledby = "exampleModalLabel" aria-hidden = "true">
            <div class = "modal-dialog md">
                <div class = "modal-content">
                    <div class = "modal-header border-0">
                        <!--                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>-->
                        <button type = "button" class = "btn-close" data-bs-dismiss = "modal" aria-label = "Close"></button>
                    </div>
                    <div class = "modal-body">
                        <p class="fw-bold"> آیا سفارش کنسل شود؟</p>
                        <p>لطفا دلیل لغو این سفارش را با ما درمیان بگذارید تا کیفیت خدماتمان بیشتر شود</p>
                        <textarea id="description" class = "form-control text-start"></textarea>

                    </div>
                    <div class = "modal-footer border-0">
                        <input type = "hidden" id = "cancelId">
                        <button type = "button" class = "btn btn-dark" data-bs-dismiss = "modal" @click = "cancelOrder">
                            بله
                        </button>
                        <button type = "button" class = "btn btn-secondary" data-bs-dismiss = "modal">نه !</button>

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
                user_id: JSON.parse(localStorage.getItem('user')).id,
                orders: [],


            }
        },

        mounted() {

            document.querySelector('title').innerHTML = 'سفارشات | one';
            App.methods.checkUser();
            this.loadOrders();


        },
        methods: {

            loadOrders() {

                axios.get('/api/userOrders/' + this.user_id)
                    .then((response) => {

                        console.log(response);
                        if (response.status === 200) {
                            this.orders = response.data;
                        }

                    })
                    .catch((error) => {
                        console.log(error);
                    });

            },
            showCancelModal(id) {
                document.getElementById('cancelId').value = id;
            },
            cancelOrder() {
                axios.post('/api/cancel/order',{
                    id:  document.getElementById('cancelId').value,
                    description:  document.getElementById('description').value,
                })
                    .then((response) => {
                        if (response.status === 200) {
                            // alert('200');
                            App.methods.updateUserInfo();
                            this.loadOrders();
                            console.log('updated', this.orders);
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            },
        }
    }
</script>

<style scoped>
    /* tr:last-child td, tr:last-child th{
    border: none !important;
    } */
    tr td, tr th {
        border: none !important;
    }

    td:nth-child(4) {
        width: 50px !important;
        padding-left: 0px;
        padding-right: 0px;
        text-align: end;
    }

    td:nth-child(3) {
        width: 100px !important;

        text-align: end;
    }

    th {
        width: 100px !important;
        padding-left: 0px;
        padding-right: 0px;
        /* text-align: end; */
    }
</style>
