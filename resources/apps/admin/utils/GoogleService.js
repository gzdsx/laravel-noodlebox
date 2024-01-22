import axios from "axios";

const geocode = (address) => {
    return axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
        params: {
            language: 'en',
            key: window.googleApiKey,
            address
        }
    });
}

const regeocode = (latlng) => {
    return axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
        params: {
            latlng,
            language: 'en',
            key: window.googleApiKey,
        }
    });
}

export default {
    geocode,
    regeocode
}