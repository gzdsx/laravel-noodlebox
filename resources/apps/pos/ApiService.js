const WooCommerceRestApi = require("@woocommerce/woocommerce-rest-api").default;

const api = new WooCommerceRestApi({
    url: "https://woocommerce-282844-4118963.cloudwaysapps.com",
    consumerKey: "ck_990ebb1306f4a1be210df8f3481779d6febe1231",
    consumerSecret: "cs_3b4f218957a57a2482fb15b08017329546fe3a75",
    version: "wc/v3",
    axiosConfig: {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        }
    }
});

export default api;