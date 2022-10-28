<template>
  <footer class="p-5 pt-4 bg-dark text-light">
      <div class = "row">
          <div class = "col-7 col-md-3 mt-4">

           <p class = "h6 fw-bold mb-3">وان آنلاین شاپ</p>
              <p style="text-align: justify">
                  لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد
              </p>


              <!--              <p class = "h6 fw-bold mb-3">لینک ها</p>-->
<!--              <p>-->
<!--                  <router-link class = "d-block text-light" to = "/">راهنما</router-link>-->
<!--              </p>-->
<!--              <p>-->
<!--                  <router-link class = "d-block text-light" to = "/">تماس با ما</router-link>-->
<!--              </p>-->
<!--              <p>-->
<!--                  <router-link class = "d-block text-light" to = "/">درباره ما</router-link>-->
<!--              </p>-->
          </div>
          <div class = "col-4 offset-1   col-md-2 mt-4">
              <p class = "h6 fw-bold  mb-3">حساب کاربری</p>
              <p>
                  <router-link class = "d-block text-light" to = "/">پروفایل من</router-link>
              </p>
              <p>
                  <router-link class = "d-block text-light" to = "/">سفارش ها</router-link>
              </p>
              <p>
                  <router-link class = "d-block text-light" to = "/">خروج</router-link>
              </p>
          </div>
          <div class = "col-md-6 mt-4 mb-3">
              <p class = "h6 fw-bold mb-3">تماس با ما</p>
              <p class = "">نشانی: تهران شیان خیابان شهید فرشادی نبش کوچه خندان پلاک ۵ ساختمان آراتل طبقه دوم</p>
              <p class = "">ایمیل: webagent.ir@gmail.com</p>
              <p class = "">تلفن: <a class="text-light" href = "tel:09032313681" dir="ltr">0903 231 36 81</a></p>
              <div class="social-links mt-3 d-flex justify-content-end">
                  <a style="{font-size: 13px}" href="tel:09032313681"><i class="bi bi-telephone-fill"></i></a>
                  <a target="_blank"  href="https://linkedin.com/in/roxanarahimi"><i class="bi bi-linkedin"></i></a>
                  <a target="_blank"  href="https://api.whatsapp.com/send?phone=989032313681"><i class="bi bi-whatsapp"></i></a>
                  <a target="_blank"  href="https://t.me/webagent_ir"><i class="bi bi-telegram"></i></a>
                  <a target="_blank"  href="https://www.instagram.com/webagent.ir">
                  <i class="bi bi-instagram"></i></a>
              </div>
          </div>
          <hr>
         <small > &copy; رکسانا رحیمی 1400 </small>
      </div>
  </footer>
</template>

<script >
export default {

}
</script>

<style scoped>


    .social-links {
        direction: ltr;

        /*margin-top: 10px;*/
    }

    .social-links a{
        font-size: 15px;
        /*margin-right: 4px;*/
        /*margin-left: 5px;*/
        border-radius: 50%;
        display: inline-block;
        width: 30px !important;
        height: 30px !important;
        text-align: right;
        padding-top: 3px;
        cursor: pointer;
        color: whitesmoke;
        /*background: whitesmoke;*/

    }
    #email, #tel{
        cursor: pointer;
    }
</style>
