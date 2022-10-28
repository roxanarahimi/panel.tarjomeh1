<template>


    <div v-if="allData.length" class="card">
        <div class="card-body">
           <div class="row mb-3">
               <div class="col-6 col-lg-4">
                   <select class="form-select" id="select_language_name" @change="loadData">
                       <option value="">language name</option>
                       <option value="4">Open</option>
                       <option value="5">Open</option>
                       <option value="6">Open</option>
                   </select>
               </div>
               <div class="col-6 col-lg-4">
                   <select class="form-select" id="select_translate_to" @change="loadData">
                       <option value="">translate to</option>
                       <option value="1">Open</option>
                       <option value="2">Open</option>
                   </select>
               </div>
           </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">language name</th>
                    <th scope="col">translate to</th>
                    <th scope="col">translate</th>
                    <th scope="col">created</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr :id="'row_'+data.id" v-for="(data, index) in allData" :key="data.id" :data-index="index">
                    <td class="">{{ index + 1 }}</td>
                    <td class="">{{ data.language.name}}</td>
                    <td class="">{{ data.toLanguage.name}}</td>
                    <td class="">{{ data.translate }}</td>
                    <td class="">{{ data.created_at }}</td>

                    <td :id="'form_'+data.id" class="d-none px-3 py-3 edit" colspan="5">
                        <form action="" class="">
                            <div class="row">
                                <div class="col-xl-1 py-2">
                                    <label :for="'title_'+data.id">name</label>
                                </div>
                                <div class="col-xl-3 col-xxl-4 mb-2">
                                    <input type="text" class="form-control border-0 " required
                                           :id="'title_'+data.id" :value="data.name">
                                </div>
                                <div class="col-xl-3 col-xxl-4 mb-2">

                                    <input type="text" class="form-control border-0 " required
                                           :id="'abbr_'+data.id" :value="data.abbr">
                                </div>
                                <div class="col-xl-3 col-xxl-3  ">
                                    <button type="submit" class="btn btn-dark ms-auto mb-2"
                                            @click.prevent="updateInfo(data.id)" id="update">
                                        ویرایش
                                    </button>
                                    <button class="btn btn-secondary ms-1 mb-2"
                                            @click.prevent="hideUpdateForm(data.id)" id="cancelUpdate">
                                        انصراف
                                    </button>
                                </div>

                            </div>
                        </form>
                    </td>

                    <td class="">
                        <span role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </span>
                        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                            <li>
                                <a class="dropdown-item"
                                   @click="showUpdateForm(data.id)" href="#">edit</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                   @click="showDeleteModal(data.id)" data-bs-toggle="modal"
                                   data-bs-target="#exampleModal">delete</a>
                            </li>
                        </ul>
                    </td>

                </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>

<script>
import App from './App';
import {onMounted, ref} from "vue";

export default {
    props: ['model', 'allData', 'page', 'pages', 'load'],
    name: "categoriesTable",
    setup(props) {
        const errors = ref([]);

        const loadData = async (p) => {
            props.load(p);
        }
        const showDeleteModal = (id) => {
            document.getElementById('deleteId').value = id;
        };
        const deleteInfo = async () => {
            // await App.methods.checkToken();
            await axios.get('/api/panel/delete/language/' + document.getElementById('deleteId').value)
                .then((response) => {
                    console.log(response.data)
                })
                .catch((error) => {
                    console.log(error);
                });
            // await App.methods.loadData();
        };
        const activeToggle = async (id) => {
            // await App.methods.checkToken();
            await axios.get('/api/panel/active/' + props.model + '/' + id)
                .then((response) => {
                    console.log(response.data)
                })
                .catch((error) => {
                    console.error(error);
                });
            await loadData();

        };

        const showUpdateForm = async (id) => {
            await document.querySelectorAll('#row_' + id + ' > td').forEach((element) => {
                element.classList.add('d-none');
            });
            await document.getElementById('form_' + id).classList.remove('d-none');
        };
        const hideUpdateForm = async (id) => {
            await loadData(props.page);
            await document.querySelectorAll('#row_' + id + ' > td').forEach((element) => {
                element.classList.remove('d-none');
            });
            await document.getElementById('form_' + id).classList.add('d-none');
        };
        const updateInfo = async (id) => {
            // await App.methods.checkToken();
            await axios.post('/api/panel/' + props.model + '/' + id,
                {
                    name: document.getElementById('title_' + id).value,
                    abbr: document.getElementById('abbr_' + id).value,
                })
                .then((response) => {
                    console.log(response.data);
                    loadData();
                })
                .catch((error) => {
                    if (error.status === 422) {
                        let errorList = Array(error.response.data);
                        for (var i = 0; i < errorList.length; i++) {
                            for (var j = 0; j < Array(errorList[i]).length; j++) {
                                let err = Object.values(Array(errorList[i])[j]);
                                err.forEach((element) => {
                                    element.forEach((m) => {
                                        // errors.value.push(m)
                                        alert(m)
                                    })
                                });
                            }
                        }
                    } else if (error.status === 500) {
                        if (error.response.data.message.includes("SQLSTATE")) {
                            console.error('خطای پایگاه داده');
                        }
                        alert('در ذخیره اطلاعات مشکلی بوجود امده.');

                    } else {
                        console.error(error);
                    }
                });
            await hideUpdateForm(id);
        };

        return {
            loadData, updateInfo, showUpdateForm, hideUpdateForm, activeToggle,
            showDeleteModal, deleteInfo,
        }

    },


}

</script>
<style>
.edit {
    background: #d7d7d7 !important;
}
</style>
a
