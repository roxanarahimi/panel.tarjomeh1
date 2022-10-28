<template>
    <div class = "row justify-content-center text-left">
        <div class = "col-8 row mt-5 pt-5 justify-content-center">
            <div class = "col-12 col-md-8 col-xl-6">
                <div class = "card">
                    <div class = "card-body">
                        <p class = "h5 card-title text-center">بروز رسانی کلمه عبور</p>
                        <form @submit.prevent = "submit">
<!--                            <div class = "mb-3">-->
<!--                                <label for = "exampleInputEmail1" class = "form-label">ایمیل</label>-->
<!--                                <input type = "email" class = "form-control" id = "register_email" aria-describedby = "emailHelp">-->
<!--                                &lt;!&ndash;                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>&ndash;&gt;-->
<!--                            </div>-->
                            <div class = "mb-3">
                                <label for = "exampleInputPassword1" class = "form-label">کلمه عبور جدید</label>
                                <input type = "password" class = "form-control" id = "register_password">
                            </div>
                            <div class = "mb-3">
                                <label for = "exampleInputPassword1" class = "form-label">تکرار کلمه عبور جدید</label>
                                <input type = "password" class = "form-control" id = "register_password_repeat">
                            </div>
                            <button type = "submit" class = "btn btn-primary">ثبت نام</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
import App from "../Site";

export default {

    mounted() {
        App.methods.checkUser();

    }
}
</script>
<style scoped>
    input {
        direction: ltr !important;
        text-align: left !important;
    }
</style>
