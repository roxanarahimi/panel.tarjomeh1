<template>
    <transition name="route" mode="out-in" appear>
        <section v-if="data" class="" style="text-align: justify">
            <div class="d-inline-block">
                <p class="mb-2 fw-bold d-block">جزییات رزومه</p>
                <!--                <p class = "mb-2 fw-bold d-block">{{data.name}}</p>-->
                <div class="row mt-3">

                    <div class="col-xl-8 mb-3  ">
                        <div class="card  h-100 ">
                            <div class="card-body px-5 py-4">


                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h2>{{ data.name }}</h2>
                                        <h4>{{ data.position }}</h4>
                                    </div>
                                    <div class="col-2">

                                        <div class="en">
                                            <small class="text-muted"> {{ data.mobile }} </small><br>
                                            <small class="text-muted"> {{ data.email }} </small><br>
                                        </div>

                                        <div class="">
                                            <small class="float-start text-muted">فرزند {{ data.father }} </small>
                                            <small class="float-end text-muted"> کد ملی {{
                                                    data.national_code
                                                }} </small><br>
                                        </div>
                                        <div>
                                            <small class="float-start text-muted"> {{ data.military }} </small>
                                            <small class="float-start text-muted"> {{ data.marriage }} </small>
                                            <small class="float-end text-muted"> {{ data.children }} فرزند </small><br>
                                        </div>

                                        <div>
                                            <small class=" text-muted"> {{ data.address }} </small><br>

                                        </div>
                                        <h4 class="py-4">مهارت ها</h4>
                                        <div v-for="item in skill">
                                            <h5>{{ item.skill }}</h5>
                                            * * * * *
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-10 px-5">


                                    <h5>درباره من</h5>
                                    <p>---------------------------------
                                        ------------------------------------------
                                        ------------------------------------
                                        ---------------------------------------------------------------------------
                                        -----------------------------------------------------------------------------------------
                                        ----------------------------------------------------------------------------------------------
                                        --------------------------------------------------------------------------------------------
                                        ---------------------------------------------------------
                                        -------
                                        --------------------------------------------------</p>

                                    <h5>تحصیلات: {{ data.education }}</h5>



                                    <br>
                                    <p class="fw-bold">سوابق کار</p>
                                    <div >
                                        <table class="w-100">
                                            <thead>
                                            <th>شرکت</th>
                                            <th>عنوان شغلی</th>
                                            <th class="en">تاریخ شروع</th>
                                            <th class="en">تاریخ پایان</th>
                                            </thead>
                                            <tbody>
                                            <tr v-for="item in history" :key="item.company">
                                                <td class="fw-bold">{{ item.company }}</td>
                                                <td class="">{{ item.job_title }}</td>
                                                <td class="en">{{ item.start }}</td>
                                                <td class="en">{{ item.end }}</td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>


                                </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <form>
                                    <p class="fw-bold mb-3">تغییر وضعیت</p>
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 mb-3">
                                            <label for="status" class="form-label">وضعیت</label>
                                            <select class="form-select" id="status" aria-describedby="statusHelp"
                                                    aria-label="status" required>
                                                <option value=""></option>
                                                <option :selected="data.status === 'در انتظار' ? 'selected': false" value="در انتظار">در انتظار</option>
                                                <option :selected="data.status === 'بایگانی' ? 'selected': false" value="بایگانی">بایگانی</option>
                                                <option :selected="data.status === 'تایید برای مصاحبه' ? 'selected': false" value="تایید برای مصاحبه">تایید برای مصاحبه</option>
                                                <option :selected="data.status === 'قبول شده' ? 'selected': false" value="قبول شده">قبول شده</option>
                                                <option :selected="data.status === 'رد شده' ? 'selected': false" value="رد شده">رد شده</option>
                                            </select>
                                            <div id="statusHelp" class="form-text error"></div>

                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button class="btn btn-primary" @click.prevent="updateInfo" type="submit">
                                                ویرایش
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
        <div v-else><p class="fw-bold">این سفارش موجود نیست</p></div>

    </transition>


</template>

<script>
import App from '../App';

export default {
    data: function () {
        return {
            data: {},
            id: this.$route.params.id,
            skill: [],
            history: [],

        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        async loadData() {

            await axios.get('/api/panel/resume/' + this.id)
                .then((response) => {
                    this.data = response.data;
                    if (this.data.skill) {
                        this.skill = JSON.parse(this.data.skill);
                    }
                    if (this.data.history) {
                        this.history = JSON.parse(this.data.history);
                    }
                })
                .catch();

        },
        async updateInfo() {

            this.progress = 0;

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
                await axios.post('/api/panel/resume/' + this.id, {
                        status: document.getElementById('status').value,
                        payment: document.getElementById('payment').value,
                        post_track_id: document.getElementById('post_track_id').value,
                    }
                    , {
                        onUploadProgress: e => {
                            if (e.lengthComputable) {
                                this.progress = (e.loaded / e.total) * 100;
                                console.log(e.loaded, e.total);
                            }
                        }
                    })
                    .then((response) => {
                        console.log('order', response.data)
                        if (response.status === 200) {
                            console.log(response);
                            this.loadData();
                            console.log(response);
                            if (response.status === 200) {
                                setTimeout(() => {
                                    window.location = '/panel/orders'
                                })
                            }
                        }
                    })
                    .catch((error) => {
                        console.log('order', error);
                        if (error.status === 422) {

                            let errorList = Array(error.data);
                            for (var i = 0; i < errorList.length; i++) {
                                this.errors = errorList[i];
                            }
                            console.log(this.errors.toString());
                        } else if (error.status === 500) {
                            if (error.response.data.message.includes("SQLSTATE")) {
                                console.error('خطای پایگاه داده');

                                async function showAlertSql() {
                                    setTimeout(() => {
                                        alert(error.response.data.message);
                                    }, 200);
                                }

                                showAlertSql();
                            } else {
                                async function showAlert500() {
                                    setTimeout(() => {
                                        alert(error.message + ' '
                                            + error.response.data.message);
                                    }, 200);
                                }

                                showAlert500();
                            }
                        } else {

                            async function showAlert() {
                                setTimeout(() => {
                                    alert(error.message);
                                }, 200);
                            }

                            showAlert();
                        }


                    })


            }
        }
    }
}
</script>
<style scoped>

table {
    overflow-x: scroll !important;
    min-width: 380px !important;
}

th, td {
    padding: 10px;
}

#content p {
    text-align: justify !important;
    line-height: 30px !important;
    padding-left: 10px;

}

p {
    display: inline-block;
    margin-left: 10px;
    margin-right: 10px;
}

.index_image .label {
    display: block;
    font-size: 20px;
    margin: -50px 20px 50px 20px;
}

#content figure img {
    max-width: 100%;
}

/*.index_image span{*/
/*    display: inline-block;*/
/*    right:20px;*/
/*    bottom: 20px;*/
/*}*/
.edit-pen {
    font-size: 12px;
    margin: 0 6px !important;
}
</style>
