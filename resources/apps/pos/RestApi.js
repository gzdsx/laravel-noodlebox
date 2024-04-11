import axios from "axios";
// create an axios instance
const RestApi = axios.create({
    baseURL: "/wp-json/wp/v2", // url = base url + request url
    // withCredentials: true, // send cookies when cross-domain requests
    timeout: 0, // request timeout
});

// request interceptor
RestApi.interceptors.request.use(
    async config => {
        // console.log(config);
        // do something before request is sent
        let nonce = document.head.querySelector('meta[name="wp-nonce"]');
        if (nonce) {
            config.headers['X-WP-Nonce'] = nonce.content;
        }
        // config.auth = {
        //     username: 'ck_6ac7db7e3742dfe867477486167e9337fe7a4639',
        //     password: 'cs_8a3063cb4e1ba23dfb860cdf2af2067b49758ae6'
        // }
        return config;
    },
    error => {
        // do something with request error
        // console.log("Request Error:", error); // for debug
        return Promise.reject(error);
    },
);

// response interceptor
RestApi.interceptors.response.use(
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

export default RestApi;