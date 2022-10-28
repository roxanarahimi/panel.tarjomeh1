<template>
    <div class = "row justify-content-center text-left">
        <div class = "col-8 row mt-5 pt-5 justify-content-center">
            <div class = "col-12 col-md-8 col-xl-6">
                <div class = "card">
                    <div class = "card-body">
                        <p class = "h5 card-title text-center">بروز رسانی کلمه عبور</p>
                        <form @submit.prevent = "submit">
                            <div class = "mb-3">
                                <label for = "email" class = "form-label">لطفا ایمیل خود را وارد کنید</label>
                                <input type = "email" class = "form-control" id = "email" aria-describedby = "emailHelp">
                                <div id="emailHelp" class="form-text"></div>
                            </div>
                            <button type = "submit" class = "btn btn-primary">ارسال</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</template>قخع

<script>

</script>
<style scoped>
    input {
        direction: ltr !important;
        text-align: left !important;
    }
</style>
