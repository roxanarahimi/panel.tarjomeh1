<template>
   <div class="my-3 px-3">
       <nav class="px-0 d-flex justify-content-between" v-if="pages>1">
           <div class="mt-2">
               <span @click="prevPage()" :class="{'text-muted': (page <= 1 ),  'fw-bold pointer': page > 1}">Previuos Page </span>
               <br class="d-sm-none">|
               <span v-if="pages>0" :class="{'text-primary': page === 1 }" :id="'page_'+1 " @click="goToPage(1)" class="pointer fs-6 fw-bold page_number mx-3">{{ 1 }}</span>
               <span v-if="pages>1" :class="{'text-primary': page === 2 }" :id="'page_'+2 " @click="goToPage(2)" class="pointer fs-6 fw-bold page_number mx-3">{{ 2 }}</span>
               <span v-if="pages>2" :class="{'text-primary': page === 3 }" :id="'page_'+3 " @click="goToPage(3)" class="pointer fs-6 fw-bold page_number mx-3">{{ 3 }}</span>
               <span v-if="pages>3" :class="{'text-primary': page === 4 }" :id="'page_'+4 " @click="goToPage(4)" class="pointer fs-6 fw-bold page_number mx-3">{{ 4 }}</span>
               <span v-if="pages>4" :class="{'text-primary': page === 5 }" :id="'page_'+5 " @click="goToPage(5)" class="pointer fs-6 fw-bold page_number mx-3">{{ 5 }}</span>
               <span v-if="pages>5" :class="{'text-primary': page === 6 }" :id="'page_'+6 " @click="goToPage(6)" class="pointer fs-6 fw-bold page_number mx-3">{{ 6 }}</span>

               <span v-if="pages>6">   ...</span>

               <span v-if="page>6 && page < pages" :class="{'text-primary': page > 6 &&  page < pages}" :id="'page_'+page
       " @click.prevent="goToPage(page)" class="pointer fs-6 fw-bold page_number mx-3">{{ page }}</span>
               <span v-if="page>6 && page < pages"> ... </span>

               <!-- this is because of this error that i received for more than 500 pages: 'page must be less than or equal to 500'-->


               <span v-if="pages>499"
                     :class="{'text-primary': page === pages}"
                     :id="'page_'+pages "
                     @click="goToPage(pages)"
                     class="pointer fs-6 fw-bold page_number mx-3"> {{ pages }} </span>
               |
               <br class="d-sm-none">
               <span @click.prevent="nextPage()"  :class="{'text-muted': page >= pages, 'fw-bold pointer': page < pages}">Next Page</span>

           </div>
           <div class="d-flex justify-content-between">
<!--               <p class="text-black-50 d-inline mt-3 pt-sm-2  ">Showing results {{ page * 20 - 19 }} - {{ page * 20 }}</p>-->
               <form v-if="pages>6" class=" d-inline">
                   <label class="d-inline mb-2 me-1" for="pageNum" >go to page </label>
                   <input id="pageNum" required class="form-control d-inline m-1" type="number" min="1" :max="pages" style="width: 80px">
                   <input type="submit" class="btn btn-sm btn-primary pt-1 pb-2 mx-1 d-inline" @click.prevent="goToPageNum" value="go" />
                   <p id="hint" class="error" style="color: indianred"></p>

               </form>
           </div>
       </nav>
       <b v-if="pages === 0" class="">no data</b>

   </div>
</template>

<script>
import {onUpdated, ref} from "vue";

export default {
    props: ['page', 'pages', 'total', 'labels', 'load'],
    name: "Pagination",
    setup(props) {
        const page = ref(1);
        const total = ref(1);


        const goToPage = (i) => {
            if (0 < i <= total.value) {
                page.value = i;
                props.load(page.value);
            }
        };
        const prevPage = () => {
            if (page.value > 1) {
                page.value -= 1;
                props.load(page.value);


            }
        };
        const nextPage = () => {
            // console.log('props',props.pages);
            if (page.value < props.pages) {
                page.value += 1;
                props.load(page.value);


            }
        };
        const goToPageNum = ()=>{
            let i = parseInt(document.querySelector('#pageNum').value);
            if (i>0 && i<props.pages+1){
                document.querySelector('#hint').innerText = '';
                goToPage(i);
            }else{
                document.querySelector('#pageNum').style.border = '2px solid indianred'
                document.querySelector('#hint').innerText = 'page number must be between 1 & '+props.pages;
            }
        }

        return {
            page, total, goToPage, prevPage, nextPage,goToPageNum
        }
    }
}
</script>

<style scoped>
.pointer{
    cursor: pointer !important;
}
</style>
