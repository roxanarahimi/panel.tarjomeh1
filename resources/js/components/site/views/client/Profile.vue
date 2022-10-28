<template>
    <div class = "container-fluid p-5 pt-0">
        <div class = "row">
            <div class = "col-lg-3 mb-3">
                <div class = "card h-100">
                    <!-- <img  class="card-img-top" alt="..."> -->
                    <div class = "card-body text-center pt-5">
                        <!-- <i class="bi bi-person-circle"></i> -->
                        <!--                        <svg-->
                        <!--                            xmlns = "http://www.w3.org/2000/svg"-->
                        <!--                            width = "60"-->
                        <!--                            height = "60"-->
                        <!--                            fill = "currentColor"-->
                        <!--                            class = "bi bi-person-circle text-muted my-2"-->
                        <!--                            viewBox = "0 0 16 16">-->
                        <!--                            <path d = "M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>-->
                        <!--                            <path fill-rule = "evenodd" d = "M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>-->
                        <!--                        </svg>-->
                        <i style = "font-size:55px !important; line-height:50px" class = "bi bi-person-circle text-muted mt-5 mb-2"></i>
                        <p class = "h5 card-title fw-bold mt-2 mb-2">{{ user.name}}</p>
                        <p class = "text-muted d-block my-0">{{user.mobile}}</p>
                        <p class = "text-muted d-block mb-1">عضویت {{ user.created_at}}</p>
                        <!--                        <a href = "#" class = "btn btn-sm btn-primary mt-2">ویرایش</a>-->
                    </div>
                </div>
            </div>

            <div class = "col-lg-4 mb-3">
                <div class = "card h-100">
                    <form id = "info-form">

                        <div class = "card-body pb-0">
                            <div class = "card-title d-flex mb-0" style = "height: 30px !important">
                                <p class = "fw-bold mb-0" style = "height:18px; margin-top:5px">اطلاعات شخصی</p>

                                <span class = "btn p-0 ms-1 text-primary" id = "edit" @click = "showEditForm">
                                    <i class = "bi bi-pencil-fill"></i>
                                </span>

                                <span class = "btn p-0 text-primary" type = "submit" id = "save" @click.prevent = "hideEditForm">
                                    <i class = "bi bi-check" @click = "updateUser"></i>
                                </span>

                            </div>
                            <table class = "table" id = "info-table">
                                <tbody>
                                <tr>
                                    <th scope = "row">نام</th>
                                    <td class = "">{{ user.name}}</td>
                                    <td class = "">
                                        <input type = "text" id = "name" name = "name" class = "form-control form-control-sm" :value = "user.name">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope = "row">جنسیت</th>
                                    <td class = "">{{ user.gender }}</td>
                                    <td class = "">
                                        <select class = "form-select form-select-sm" name = "gender" id = "gender">
                                            <option :selected="user.gender == 'خانم'? 'selected': false"    value = "female">خانم</option>
                                            <option :selected="user.gender == 'آقا'? 'selected': false"  value = "male">آقا</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope = "row">موبایل</th>
                                    <td class = "">{{ user.mobile}}</td>
                                    <td class = "">
                                        <input type = "text" id = "mobile" name = "mobile" class = "form-control form-control-sm" :value = "user.mobile">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope = "row">ایمیل</th>
                                    <td class = "">{{ user.email}}</td>
                                    <td class = "">
                                        <input type = "email" id = "email" name = "email" class = "form-control form-control-sm" :value = "user.email">
                                    </td>
                                </tr>
                                <tr class = "">
                                    <th class = "" scope = "row">تاریخ تولد</th>
                                    <td class = " ">1370 / 10 / 26</td>
                                    <td class = "row  ">
                                        <div class = "col-5">
                                            <select class = "form-select form-select-sm" name = "year" id = "year">
                                                <option value = "">1370</option>
                                                <option value = "">1371</option>
                                                <option value = "">1372</option>
                                                <option value = "">1373</option>
                                            </select>
                                        </div>
                                        <div class = "col-4 ps-0">
                                            <select class = "form-select form-select-sm" name = "month" id = "month">
                                                <option value = "female">1</option>
                                                <option value = "female">2</option>
                                                <option value = "female">3</option>
                                                <option value = "female">5</option>
                                                <option value = "female">10</option>
                                            </select>
                                        </div>
                                        <div class = "col-3 ps-0">
                                            <select class = "form-select form-select-sm" name = "day" id = "day">
                                                <option value = "female">1</option>
                                                <option value = "female">10</option>
                                                <option value = "female">20</option>
                                                <option value = "female">26</option>
                                                <option value = "female">31</option>

                                            </select>
                                        </div>
                                        <!-- <div class="col-1 text-primary text-start p-0">

                                        </div> -->

                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </form>
                </div>
            </div>
            <div class = "col-lg-5 mb-3">
                <div class = "card h-100">
                    <div class = "card-body pb-0">
                        <div class = "card-title d-flex mb-0">
                            <p class = "fw-bold me-1 mb-0" style = "height:18px; margin-top:5px">آدرس ها</p>
                            <span class = "btn p-0 ms-1 text-primary " id = "newAddress" @click = "showNewAddressForm">
                              <i class = "bi bi-plus"></i>
                            </span>
                            <span class = "btn p-0 text-primary d-none" title = "ذخیره نشانی" type = "submit" id = "saveAddress" @click.prevent = "saveAddress">
                                <i class = "bi bi-check"></i>
                            </span>
                            <span class = "btn p-0 text-primary d-none mt-1" title = "انصراف" type = "submit" id = "egnoreAddress" @click.prevent = "egnoreNewAddressForm">
                                <i class = "bi bi-x-lg"></i>
                            </span>

                        </div>

                        <table class = "table mt-2 ">
                            <tbody>
                            <tr id = "new_add_form" class = "d-none">
                                <td colspan = "4">
                                    <form>
                                        <input type = "hidden" id = "user_id" :value = "user.id">
                                        <div class = "row p-2">
                                            <div class = "col-3 mb-2 px-1 ">
                                                <input type = "text" id = "new_add_title" class = "new_add_input form-control form-control-sm" value = "" placeholder = "عنوان" required>
                                            </div>
                                            <div class = "col-3 mb-2 px-1 ">
                                                <input type = "text" id = "new_add_state" class = "new_add_input form-control form-control-sm" value = "" placeholder = "استان" required>
                                            </div>
                                            <div class = "col-3 mb-2 px-1 ">
                                                <input type = "text" id = "new_add_city" class = "new_add_input form-control form-control-sm" value = "" placeholder = "شهر" required>
                                            </div>
                                            <div class = "col-3 mb-2 px-1 ">
                                                <input type = "text" id = "new_add_postal_code" class = "new_add_input form-control form-control-sm" value = "" placeholder = "کد پستی" required>
                                            </div>
                                            <div class = "col-12 mb-2 px-1">
                                                <input type = "text" id = "new_add_address" class = "new_add_input form-control form-control-sm" value = "" placeholder = "آدرس" required>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>

                            <tr v-for = "add in user.addresses" :key = "add.id">
                                <th scope = "row">{{ add.title }}</th>
                                <td>{{ add.state + ' '+ add.city + ' ' + add.address }}</td>
                                <td>{{ add.postal_code}}</td>
                                <td class = "text-end"> <span class = "btn p-0 text-primary" @click = "showEditAddressForm(add.id)">
                                    <i class = "bi bi-pencil-fill"></i>
                                </span>
                                </td>
                                <td colspan = "4" :id = "'edit_address_form_'+add.id" class = "d-none">
                                    <div class = "row" >
                                        <div class = "col-11 ps-1 row">
                                            <div class = "col-3 mb-2 px-1 ">
                                                <input type = "text" :id = "'title_'+add.id" :value="add.title" class = "form-control form-control-sm" placeholder = "عنوان">
                                            </div>
                                            <div class = "col-3 mb-2 px-1 ">
                                                <input type = "text" :id = "'state_'+add.id" :value="add.state" class = "form-control form-control-sm" placeholder = "استان">
                                            </div>
                                            <div class = "col-3 mb-2 px-1 ">
                                                <input type = "text" :id = "'city_'+add.id"  :value="add.city" class = "form-control form-control-sm" placeholder = "شهر">
                                            </div>
                                            <div class = "col-3 mb-2 px-1 ">
                                                <input type = "text" :id = "'postal_code_'+add.id" :value="add.postal_code" class = "form-control form-control-sm" placeholder = "کد پستی">
                                            </div>
                                            <div class = "col-12 mb-2 px-1">
                                                <input type = "text" :id = "'address_'+add.id" :value="add.address" class = "form-control form-control-sm"  placeholder = "آدرس">
                                            </div>
                                        </div>
                                        <div class = "col-1 p-0 text-end">
                                            <span class = "btn text-primary p-0" @click="hideEditAddressForm(add.id)">
                                                <i class = "bi bi-check"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!--                            <tr>-->
                            <!--                                <th class = "" scope = "row">دفتر</th>-->
                            <!--                                <td class = "">تهران خیابان ولیعصر</td>-->
                            <!--                                <td class = "">1234567890</td>-->
                            <!--                                <td class = " text-end">-->
                            <!--                      <span class = "btn p-0 text-primary " id = "edit" @click = "showEditForm">-->
                            <!--                        <i class = "bi bi-pencil-fill"></i>-->
                            <!--                      </span>-->
                            <!--                                </td>-->

                            <!--                            </tr>-->
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class = "col-12 offset-lg-3 col-lg-9 mb-3">
                <div class = "card">
                    <div class = "card-body pb-0">
                        <div class = "card-title d-flex fw-bold">
                            <p class = " me-2">سفارش ها</p>
                            <router-link v-if = "user" to = "/orders">
                                <i class = "bi bi-box-arrow-in-right"></i>
                            </router-link>
                        </div>

                        <table v-if = "user" class = "table" id = "order-table">
                            <tbody>
                            <tr v-for = "item in user.orders" :key = "item.id">
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
                                <td>1400-6-23</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import BaseToast from "../components/BaseToast.vue";

    import App from "../Site";

    export default {
        components: {},
        name: "Profile",
        props: [],
        data() {
            return {
                user: {},
                adds: [],
                id: JSON.parse(localStorage.getItem('user')).id,
            }
        },
        async mounted() {
            document.querySelector('title').innerHTML = 'پروفایل | one';
            await App.methods.checkUser();
            await App.methods.updateUserInfo();
            await console.log('updated', JSON.parse(localStorage.getItem('user')));

            // if (localStorage.length) {
            //     document.getElementById('cart_count').innerHTML = JSON.parse(localStorage.getItem('user'))?.cart?.items?.length || 0;
            // }
            await this.hideEditForm();
            this.user = await JSON.parse(localStorage.getItem('user'));
            await console.log(this.user.addresses)

            this.adds = this.user.adds
            // fetch("http://localhost:3000/products/" + this.id)
            //   .then((res) => res.json())
            //   .then((data) => (this.product = data))
            //   .catch((err) => console.log(err.message));
        },
        methods: {
            updateUser() {
                axios.post('api/user/' + this.id, {
                    name: document.getElementById('name').value,
                    mobile: document.getElementById('mobile').value,
                    email: document.getElementById('email').value,
                    gender: document.getElementById('gender').value,
                })
                    .then(async (response) => {
                        if (response.status === 200) {
                            await App.methods.updateUserInfo();
                            await setTimeout(()=>{
                                this.user =  JSON.parse(localStorage.getItem('user'));
                            },1000)
                        }
                    })
                    .catch((error) => {
                        console.error(error);
                    });


            },
            hideEditForm() {
                document.getElementById('edit').classList.remove('d-none');
                document.getElementById('save').classList.add('d-none');

                document.querySelectorAll("#info-table tr td:nth-child(3)")
                    .forEach((element) => {
                        element.classList.add('d-none')
                    });
                document.querySelectorAll("#info-table tr td:nth-child(2)")
                    .forEach((element) => {
                        element.classList.remove('d-none')
                    });

            },
            showEditForm() {
                document.getElementById('edit').classList.add('d-none');
                document.getElementById('save').classList.remove('d-none');

                document.querySelectorAll("#info-table tr td:nth-child(2)")
                    .forEach((element) => {
                        element.classList.add('d-none')
                    });
                document.querySelectorAll("#info-table tr td:nth-child(3)")
                    .forEach((element) => {
                        element.classList.remove('d-none')
                    });


            },
            showNewAddressForm() {
                document.getElementById('newAddress').classList.add('d-none');
                document.getElementById('saveAddress').classList.remove('d-none');
                document.getElementById('new_add_form').classList.remove('d-none');
                document.getElementById('egnoreAddress').classList.remove('d-none');

            },
            saveAddress() {
                this.errors = [];
                let emptyFieldsCount = 0;
                let req = document.querySelectorAll('.new_add_input');
                console.log(req);
                req.forEach((element) => {
                    if (element.value === "") {
                        element.classList.add('hasError');
                        // element.nextSibling.innerHTML = "فیلد اجباری";
                        emptyFieldsCount++;
                    } else {
                        element.classList.remove('hasError');
                        // element.nextSibling.innerHTML = "";
                    }
                });
                if (emptyFieldsCount === 0) {
                    axios.post('/api/address/user', {
                        user_id: document.getElementById('user_id').value,
                        title: document.getElementById('new_add_title').value,
                        state: document.getElementById('new_add_state').value,
                        city: document.getElementById('new_add_city').value,
                        address: document.getElementById('new_add_address').value,
                        postal_code: document.getElementById('new_add_postal_code').value,

                    })
                        .then((response) => {
                            if (response.status === 201) {
                                App.methods.updateUserInfo();
                                this.user.addresses = (JSON.parse(localStorage.getItem('user')).addresses);
                            }
                        })
                        .catch((error) => {

                            console.log(error)
                        });
                }
                document.getElementById('saveAddress').classList.add('d-none');
                document.getElementById('new_add_form').classList.add('d-none');
                document.getElementById('egnoreAddress').classList.add('d-none');
                document.getElementById('newAddress').classList.remove('d-none');

            },
            hideNewAddressForm() {

                document.getElementById('newAddress').classList.remove('d-none');
                document.getElementById('saveAddress').classList.add('d-none');
                document.getElementById('new_add_form').classList.add('d-none');
                document.getElementById('egnoreAddress').classList.add('d-none');

            },
            egnoreNewAddressForm() {
                document.getElementById('saveAddress').classList.add('d-none');
                document.getElementById('new_add_form').classList.add('d-none');
                document.getElementById('egnoreAddress').classList.add('d-none');
                document.getElementById('newAddress').classList.remove('d-none');


                let req = document.querySelectorAll('.new_add_input');
                console.log(req);
                req.forEach((element) => {
                    element.value = "";
                });
            },
            showEditAddressForm(id){
             //   document.getElementById('saveAddress').classList.add('d-none');

            },
            hideEditAddressForm(id){
            //    document.getElementById('saveAddress').classList.add('d-none');

            },
        }
        ,
    }
    ;
</script>

<style scoped>
    td {
        padding-top: 5px !important;
        padding-bottom: 9px !important;
    }

    td:nth-child(3) {
        padding-top: 5px !important;
        padding-bottom: 3px !important;
    }

    /* #info-table th{
    width: 25% !important;
    height: 35px !important;
    } */
    /* tr:last-child td, tr:last-child th{
    border: none !important;
    } */
    tr td, tr th {
        border: none !important;
    }

    /* #order-table td:nth-child(4){
    width: 50px !important;
    padding-left: 0px;
    padding-right: 0px;
    text-align: end;
    } */
    #order-table td:nth-child(3) {
        width: 100px !important;

        text-align: end;
    }

    #order-table th {
        width: 100px !important;
        padding-left: 0px;
        padding-right: 0px;
        /* text-align: end; */
    }

    .bi {
        font-size: 12px !important;
    }

    .bi-check, .bi-plus {
        font-size: 23px !important;
    }

    .bi-box-arrow-in-right {
        font-size: 20px !important;

    }
</style>
