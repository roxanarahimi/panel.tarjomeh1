<template>
    <transition name="route" mode="out-in" appear>
        <section>

            <div class="d-flex mb-5">
                <h3 class="me-2">Languages</h3>
                <!--                <select id="model" @change="loadData" v-model="model" class="form-select" style="width: 200px">-->
                <!--                    <option value="product">محصولات</option>-->
                <!--                    <option value="article">مطالب</option>-->
                <!--                    <option value="course">دوره ها</option>-->
                <!--                </select>-->
            </div>
            <!--            <div class="row flex-row-reverse ">-->
            <div class="row ">
                <!--                <div class="col-xl-4 mb-4 mt-3 mt-xl-4 pt-xl-5">-->
                <!--            <suspense >-->
                <!--                <template #default>-->
                <div class="col-xl-8 mb-3">
                    <loader style="margin-top: -72px"/>
                    <languages-table class="mb-3" :model="model" :allData="allData" :page="page" :pages="pages"
                                     :load="loadData"/>
                    <pagination :page="page" :pages="pages" :total="total" :labels="labels" :load="loadData"/>

                </div>
                <div class="col-xl-4 mb-4">
                    <!--                    <div class="card mt-xl-1 ">-->
                    <div class="card">
                        <div class="card-body">
                            <p class="fw-bold">add new language</p>
                            <form>
                                <div class="row">
                                    <div class="col-5 mb-3">
                                        <label for="title" class="form-label">name</label>
                                        <input type="text" class="form-control mb-2" id="title" required="required">

                                        <div>
                                            <small v-for="error in errors.title"
                                                   class="form-text error py-0 my-0 d-block">{{ error }}</small>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="title" class="form-label">abbriviation</label>
                                        <input type="text" class="form-control" id="abbr" required="required">
                                        <div>
                                            <small v-for="error in errors.title"
                                                   class="form-text error py-0 my-0 d-block">{{ error }}</small>
                                        </div>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="title" class="form-label">&nbsp;</label>

                                        <btn-submit @click.prevent="createInfo">
                                            save
                                        </btn-submit>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>

                <!--                </template>-->

                <!--                <template #fallback><loader /></template>-->
                <!--            </suspense>-->
            </div>
        </section>
    </transition>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <!--                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>-->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Delete the language?
                    <small class="d-block fw-bold mt-2 text-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        By deleting this language all it's subsets will be deleted!!!</small>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" id="deleteId">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal" @click="deleteInfo">yes
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">no !</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import App from './App';
import {onMounted, ref} from "vue";
import Loader from "../components/Loader";
import BtnSubmit from "../components/BtnSubmit";
import Pagination from "../components/Pagination";
import languagesTable from "./languagesTable";

export default {
    components: {BtnSubmit, Loader, App, Pagination, languagesTable},
    setup() {
        const model = ref('language');
        const errors = ref([]);
        const allData = ref([]);
        const page = ref();
        const pages = ref();
        const total = ref();
        const labels = ref([]);
        const loadData = async (p) => {
            if (p === undefined) {
                page.value = 1;
            } else if (1 <= p && p <= pages.value) {
                page.value = p;
            }
            // await App.methods.checkToken();
            let perPage = document.querySelector('#perPage')?.value || 10;
            document.querySelector('#loader').classList.remove('d-none');
            await axios.get('/api/panel/' + model.value + '?page=' + page.value + '&perPage=' + perPage)
                .then((response) => {
                    allData.value = response.data.data;
                    pages.value = response.data.pages;
                    total.value = response.data.total;
                    labels.value = response.data.labels;


                    document.querySelector('#loader').classList.add('d-none');
                }).catch();
        }
        const createInfo = async () => {
            errors.value = [];
            // await App.methods.checkToken();
            await axios.post('/api/panel/' + model.value,
                {
                    name: document.getElementById('title').value,
                    abbr: document.getElementById('abbr').value,
                })
                .then((response) => {
                    loadData();
                    setTimeout(() => {
                        document.getElementById('title').value = "";
                        document.getElementById('abbr').value = "";
                    }, 200);

                })
                .catch((error) => {
                    if (error.status === 422) {
                        // let errorList = Array(error.response.data);
                        document.getElementById('title').classList.add('hasError');

                        let errorList = Array(error.response.data);
                        for (var i = 0; i < errorList.length; i++) {
                            this.errors = errorList[i];
                        }

                        // for (var i = 0; i < errorList.length; i++) {
                        //     for (var j = 0; j < Array(errorList[i]).length; j++) {
                        //         let err = Object.values(Array(errorList[i])[j]);
                        //         err.forEach((element) => {
                        //             element.forEach((m) => {
                        //                 errors.value.push(m)
                        //             })
                        //         });
                        //     }
                        // }
                        // console.log('errors',errors.value);
                    } else if (error.status === 500) {
                        if (error.response.data.message.includes("SQLSTATE")) {
                            console.error('خطای پایگاه داده');
                        }
                        alert('در ذخیره اطلاعات مشکلی بوجود امده.');

                    } else {
                        console.error(error);
                    }


                })
        };

        const deleteInfo = async () => {
            await languagesTable.setup().deleteInfo();
            await loadData();
        };
        const activeToggle = async (id) => {
            // await App.methods.checkToken();
            await axios.get('/api/panel/active/' + model.value + '/' + id)
                .then((response) => {
                    console.log(response.data)
                })
                .catch((error) => {
                    console.error(error);
                });
            await loadData(page.value);

        };
        onMounted(() => {
            loadData();
        })
        return {
            model, errors, allData, page, pages, total, labels,
            loadData, createInfo, activeToggle, deleteInfo
        }
    },

}

</script>
<style>

</style>

