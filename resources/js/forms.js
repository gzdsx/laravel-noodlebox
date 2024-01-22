import Vue from "vue";
import UploadForm from "./components/forms/UploadForm";
import showToast from "../apps/lib/toast";
import request from "./request";

Vue.use(showToast);
Vue.prototype.$http = request;

new Vue({
    el: '#form-upload-container',
    render(createElement, hack) {
        return createElement(UploadForm);
    }
});