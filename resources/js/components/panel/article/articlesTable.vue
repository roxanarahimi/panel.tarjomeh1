<template>
    <div v-if = "allData" class = "card">
        <div class = "card-body">
            <table class = "table">
                <thead>
                <tr>
                    <th scope = "col"></th>
                    <th class = "d-none d-md-table-cell" style = "width: 100px" scope = "col">image</th>
                    <th scope = "col">title</th>
                    <th scope = "col">category</th>
<!--                    <th class = "d-none d-xl-table-cell" scope = "col">متن</th>-->
                    <th class = "d-none d-xl-table-cell" scope = "col">view</th>
                    <th class = "d-none d-xl-table-cell" scope = "col">like</th>
                    <th class = "d-none d-xl-table-cell" scope = "col">dislike</th>
                    <th class = "d-none d-md-table-cell" scope = "col">created</th>
                    <th scope = "col" class = "active_cell">status</th>
                    <th scope = "col"></th>
                </tr>
                </thead>
                <tbody>

                <tr :id = "'row_'+data.id" v-for = "(data, index) in allData" :key = "data.id" :data-index = "index">
                    <td>{{ index + 1 }}</td>
                    <td class = "d-none d-md-table-cell" style = "width: 100px">
                        <img v-if = "data.image" :src = "data.image" width = "80" alt = "">
                    </td>
                    <td>
                        <router-link :to = "'/panel/article/'+data.id">{{ data.title }}</router-link>
                    </td>

                    <td :title = "!data.category.active? 'enactive category': ''" :class = "{'text-decoration-line-through text-muted ': !data.category.active}">
                        {{ data.category.title }}
                    </td>
<!--                    <td class = "d-none d-xl-table-cell text_cell">{{ // data.text }}</td>-->
                    <td class = "d-none d-xl-table-cell text_cell">{{ data.views }}</td>
                    <td class = "d-none d-xl-table-cell text_cell">{{ data.likes }}</td>
                    <td class = "d-none d-xl-table-cell text_cell">{{ data.dislikes }}</td>
                    <td class = "d-none d-md-table-cell date_cell">{{ data.created_at }}</td>
                    <td class="active_cell">
                        <span @click="activeToggle(model,data.id)" v-if="data.active" class="badge bg-success text-light"><i class="bi bi-eye-fill"></i></span>
                        <span @click="activeToggle(model,data.id)" v-else class="badge bg-danger text-light"><i class="bi bi-eye-slash-fill"></i></span>
                    </td>
                    <td>
                        <span role = "button" data-bs-toggle = "dropdown" aria-expanded = "false"><i class = "bi bi-three-dots-vertical"></i></span>
                        <ul class = "dropdown-menu" aria-labelledby = "navbarScrollingDropdown">
                            <!--                                            <li>-->
                            <!--                                                <a class = "dropdown-item" style = "text-align: right !important" href = "#">مشاهده</a>-->
                            <!--                                            </li>-->
                            <!--                                             <li>-->
                            <!--                                                <a class = "dropdown-item" style = "text-align: right !important" href = "#">ویرایش</a>-->
                            <!--                                            </li>-->
                            <li>
                                <router-link :to = "'/panel/article/'+data.id" class = "dropdown-item" style = "text-align: right !important">
                                    view
                                </router-link>
                                <router-link :to = "'/panel/edit/article/'+data.id" class = "dropdown-item" style = "text-align: right !important">
                                    edit
                                </router-link>
                                <a class = "dropdown-item" @click = "showDeleteModal(data.id)" style = "text-align: right !important" data-bs-toggle = "modal" data-bs-target = "#exampleModal">delete</a>
                            </li>
                            <!--                                <li><hr class="dropdown-divider"></li>-->
                            <!--                                <li><a class="dropdown-item" href="#">Something else here</a></li>-->
                        </ul>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

import AllDataContainer from "../AllDataContainer";
// import AllDataInner from "../AllData";

export default {
    props: ['allData', 'page','model','loadData'],
    name: "articlesTable",
    async setup(props){
       const showDeleteModal = async (id) => {
            await AllDataContainer.setup().showDeleteModal(id);
        }
        const deleteInfo = async (model,id) => {
            await AllDataContainer.setup().deleteInfo(model,id);
            props.loadData(props.page);
        };
        const activeToggle = async (model,id) => {
            await AllDataContainer.setup().activeToggle(model,id);
            props.loadData(props.page);

        };

        return {showDeleteModal, deleteInfo, activeToggle}
    }
}
</script>

<style scoped>

</style>
