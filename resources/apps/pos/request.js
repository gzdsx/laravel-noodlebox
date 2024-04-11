import axios from "axios";
// create an axios instance
const request = axios.create({
    baseURL: "https://noodlebox.gzdsx.cn/api/v1", // url = base url + request url
    // withCredentials: true, // send cookies when cross-domain requests
    timeout: 0, // request timeout
});

// const isProduction = true;
// if (isProduction){
//     request.defaults.baseURL = "https://noodlebox.gzdsx.cn/api/v1";
//     request.defaults.auth = {
//         username: 'ck_38716e54c6ed97b942e2e1f05bb244b42e5b785e',
//         password: 'cs_a04880e1d397d759e5c80a1851f752548048955d'
//     }
// }else {
//     request.defaults.baseURL = "https://woocommerce-282844-4118963.cloudwaysapps.com/wp-json/wc/v3";
//     request.defaults.auth = {
//         username: 'ck_c824ce0320288f2d3fe974d7eb8140bccd945079',
//         password: 'cs_f73f8cd1a62a8c600be9a0f5cd2b0466cc1a1d9e'
//     }
// }

// request interceptor
request.interceptors.request.use(
    async config => {
        config.headers["Authorization"] = "Bearer " + localStorage.getItem('accessToken');
        return config;
    },
    error => {
        // do something with request error
        // console.log("Request Error:", error); // for debug
        return Promise.reject(error);
    },
);

// response interceptor
request.interceptors.response.use(
    /**
     * If you want to get http information such as headers or status
     * Please return  response => response
     */

    /**
     * Determine the request status by custom code
     * Here is just an example
     * You can also judge the status by HTTP Status Code
     */
    response => {
        //const res = response.data;
        //console.log(res);

        return response.data;
    },
    error => {
        return Promise.reject(error);
    },
);

export default request;