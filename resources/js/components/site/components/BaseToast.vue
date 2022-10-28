<template>
    <transition name = "toast">
        <div class = "toast-cover">
            <div class = "toast-body alert"
                 :class = "{ 'alert-success': type === 'success', 'alert-dander': type === 'danger','alert-info': type === 'info', }">
                <h3 id="title" v-if = "title"></h3>
                <p  id="text" v-if = "text"></p>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: ["type", "title", "text"],
        data(){
            return{

            }
        },
        mounted() {
            document.querySelector('.toast-cover').classList?.remove('d-none')
            if (this.title) {
                document.getElementById('title').innerHTML = this.title;
            }            if (this.text) {
                document.getElementById('text').innerHTML = this.text;
            }
            document.querySelector('#nav').addEventListener('click', function myf(){
                document.querySelector('.toast-cover')?.classList.add('d-none')
            });
        },
        unmounted() {
            function myf(){
                document.querySelector('.toast-cover').classList.add('d-none')
            }
            document.querySelector('#nav').removeEventListener('click', myf);
            document.querySelector('.toast-cover')?.classList?.remove('d-none')


        }
    };
</script>

<style scoped>
    h3,
    p {
        margin: 5px 0px;
    }

    h3 {
        font-size: 16px;
    }

    p {
        font-size: 14px;
    }

    .toast-cover {
        position: fixed;
        width: 120%;
        height: 120vh;
        top: 62px;
        right: 0;
        z-index: 1000;
    }

    .toast-body {
        width: 250px !important;
        min-height: 20px !important;
        border-radius: 5px;
        padding: 0 20px;
        position: relative;
        top: 70px;
        right: 40% !important;
        z-index: 100;
        opacity: 0.8;
    }

    /* enter classes*/
    /* .toast-enter-from, .toast-leave-to {
      opacity: 0;
      transform: translateY(-20px);
    }
    .toasr-enter-to, .toast-leave-from {
      opacity: 1;
      transform: translateY(0px);
    }
    .toast-enter-active, .toast-leave-active {
      transition: all 1s ease;
    } */

    .toast-enter-active {
        animation: wobble 1s ease;
    }

    .toast-leave-active {
        animation: wobbleLeave 0.5s ease;
    }

    @keyframes wobble {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        50% {
            opacity: 1;
            transform: translateY(0px);
        }
        60% {
            transform: translateX(8px);
        }
        70% {
            transform: translateX(-8px);
        }
        80% {
            transform: translateX(4px);
        }
        90% {
            transform: translateX(-4px);
        }
        100% {
            transform: translateX(0);
        }
    }

    @keyframes wobbleLeave {
        0% {
            opacity: 1;
            transform: translateY(0);
        }
        100% {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
</style>
