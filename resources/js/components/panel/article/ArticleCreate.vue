<template>
    <transition name="route" mode="out-in" appear>
        <section>
            <h3 class="mb-5">ثبت مطلب جدید</h3>

            <div class="row mt-3">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form id="editForm" @click = "e => enableClick">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">image</label><br/>
                                        <image-cropper name="" caption="" :hasCaption="hasCaption" :isRequired="imgRequired" :aspect="aspect"/>
                                        <div id="imageHelp" class="form-text error"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="title" class="form-label">title</label>
                                        <input type="text" :class="{hasError: errors.title}" class="form-control"
                                               id="title" aria-describedby="titleHelp" required>
                                        <div id="titleHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.title">{{ e }}</p>

                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="category" class="form-label">category</label>
                                        <select class="form-select" id="category" aria-describedby="categoryHelp"
                                                aria-label="category" required>
                                            <option value=""></option>
                                            <option v-for="category in categories" :key="category.id"
                                                    :value="category.id">
                                                {{ category.title }}
                                            </option>
                                        </select>
                                        <div id="categoryHelp" class="form-text error"></div>

                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" >text</label>
<!--                                       <div id="editor"></div>-->

                                        <editor mode = "new" />
<!--                                        <textarea @input="watchTextAreas" :class="{hasError: errors.text}"-->
<!--                                                  aria-describedby="textHelp" class="form-control text-start"-->
<!--                                                  id="editor"></textarea>-->
                                        <div id="textHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.text">{{ e }}</p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div>
                                            <label class="form-label mb-1 align-middle">tags</label>
                                            <span @click="addTag" class="px-3 d-inline-block align-middle"><i
                                                class="bi bi-plus-circle-fill p-0 mt-2 m-0" style="font-size: 15px"></i></span>
                                        </div>

                                        <div v-for="(tag, index) in tags" :key="index" class="row tagElement">
                                            <div class="col-5 col-md-3 mb-3">
                                                <input type="text" name="tagLabel" class="form-control"
                                                       @input="updateTags" :value="tag.label" placeholder="tag"
                                                       required>
                                                <div class="form-text error"></div>
                                            </div>
                                            <div class="col-5 col-md-3 mb-3">
                                                <input type="text" name="tagUri" class="form-control en uri" dir="ltr"
                                                       @input="updateTags" :value="tag.uri" placeholder="uri" required>
                                                <div class="form-text error"></div>
                                            </div>
                                            <div class="col-auto mb-3 pt-2">
                                                <span @click="removeTag(index)"><i class="bi bi-x-circle-fill m-0 "
                                                                                   style="font-size: 15px"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <button class="btn btn-primary" @click.prevent="createInfo" type="submit">
                                            <!--                                        <button class = "btn btn-primary" type = "submit">-->
                                            save
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

             </section>
    </transition>

</template>

<script>
import ImageCropper from '../../components/ImageCropper';
import App from '../App';
import Editor from "../../components/Editor";

export default {
    components: {Editor, ImageCropper},
    data: function () {
        return {
            id: '',
            blog: [],
            categories: [],
            errors: [],
            imgRequired: true,
            hasCaption: false,
            aspect: 16 / 9,
            tags: [{"label": "", "uri": ""}],
        }
    },
    mounted() {
        this.loadCategories();
    },
    methods: {

        loadCategories() {
             axios.get('/api/panel/category/article?page=1&perPage=100000')
                .then((response) => {
                this.categories = response.data.data;
            }).catch();
        },
        async createInfo() {
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
                let tags = [];
                for (let i = 0; i < document.getElementsByName('tagLabel').length; i++) {
                    tags.push('{"label": "' + document.getElementsByName('tagLabel')[i].value + '", "uri": "' + document.getElementsByName('tagUri')[i].value + '"}');
                }
                if (document.getElementsByName('tagLabel').length === 0) {
                    tags = '[]';
                } else {
                    tags = '[' + tags.toString() + ']';
                }
                await axios.post('/api/panel/article', {
                    image: document.getElementById('Image__code').value,
                    title: document.getElementById('title').value,
                    article_category_id: document.getElementById('category').value,
                    text:  document.getElementById('content_text_area').value,
                    tags: tags,
                })
                    .then((response) => {
                        console.log(response.data)
                        if (response.status === 201 || response.status === 200) {
                            setTimeout(() => {
                                this.$router.push({path: '/panel/articles'});
                            }, 1000);

                        }
                    })
                    .catch((error) => {
                        if (error.status === 422) {
                            let errorList = Array(error.response.data);
                            for (var i = 0; i < errorList.length; i++) {
                                this.errors = errorList[i];
                            }
                            console.log(this.errors.toString());
                        } else if (error.status === 500) {
                            if (error.response.data.message.includes("SQLSTATE")) {
                                console.error('خطای پایگاه داده');

                                async function showAlertSql() {
                                    setTimeout(() => {
                                        alert(error.data.message);
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
        },
        watchTextAreas() {
            let txt = document.querySelector("#text");
            txt.setAttribute("style", "height:" + (txt.scrollHeight + 20) + "px;overflow-y:hidden;");
            txt.addEventListener("input", changeHeight, false);

            function changeHeight() {
                this.style.height = "auto";
                this.style.height = (this.scrollHeight) + "px";
            }
        },
        addTag() {

            this.tags.push('{"label": "", "uri": ""}');
        },
        removeTag(index) {

            this.tags.splice(index, 1)
        },
        async updateTags() {
            this.tags = [];
            for (let i = 0; i < document.getElementsByName('tagLabel').length; i++) {
                await this.tags.push({
                    "label": document.getElementsByName('tagLabel')[i].value.toString(),
                    "uri": document.getElementsByName('tagUri')[i].value.toString()
                });
            }
        },


    }
}
</script>
<style>
span i {
    cursor: pointer;
}
</style>
