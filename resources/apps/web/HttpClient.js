import axios from "axios";
// create an axios instance
const httpClient = axios.create({
    baseURL: "/api/v1", // url = base url + request url
    // withCredentials: true, // send cookies when cross-domain requests
    timeout: 0, // request timeout
    auth: {
        username: "admin",
        password: "admin"
    }
});

// request interceptor
httpClient.interceptors.request.use(
    async config => {
        // console.log(config);
        // do something before request is sent
        let token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            //config.headers["Authorization"] = "Bearer " + token;
            config.headers['X-CSRF-TOKEN'] = token.content;
        }
        return config;
    },
    error => {
        // do something with request error
        // console.log("Request Error:", error); // for debug
        return Promise.reject(error);
    },
);

// response interceptor
httpClient.interceptors.response.use(
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
        const res = response.data;
        //console.log(res);

        // if the custom code is not 20000, it is judged as an error.
        if (res.code) {
            if (res.code === 401) {
                window.dispatchEvent(new Event('unauthenticated'));
            }
            //return Promise.reject(new Error(res.message || "Error"));
            return Promise.reject(res);
        } else {
            return res;
        }
    },
    error => {
        //console.log("Response Error:", error);
        if (error.response){
            if (error.response.status === 401){
                window.dispatchEvent(new Event('unauthenticated'));
            }
        }
        return Promise.reject(error);
    },
);

export default httpClient;