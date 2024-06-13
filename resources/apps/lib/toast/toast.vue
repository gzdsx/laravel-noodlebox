<template>
    <div class="vue-toast" v-if="showWrap" :class="showContent ?'fadein':'fadeout'">{{text}}</div>
</template>

<style scoped>
    .vue-toast{
        position: fixed;
        left: 50%;
        top:50%;
        background: #000;
        padding: 20px 30px;
        border-radius: 5px;
        transform: translate(-50%,-50%);
        color:#ffffff;
        font-size: 18px;
        z-index: 99999;
        box-shadow: 0 3px 5px rgba(0,0,0,0.2);
        text-align: center;
    }
    .fadein {
        animation: animate_in 0.35s;
    }
    .fadeout {
        animation: animate_out 0.25s;
        opacity: 0;
    }
    @keyframes animate_in {
        0% {
            opacity: 0;
        }
        100%{
            opacity: 1;
        }
    }
    @keyframes animate_out {
        0% {
            opacity: 1;
        }
        100%{
            opacity: 0;
        }
    }

    @media (max-width: 768px) {
        .vue-toast{
            font-size: 16px;
        }
    }
</style>
