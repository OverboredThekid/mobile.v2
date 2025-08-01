import axios from 'axios';
import L from 'leaflet';
window.axios = axios;
window.L = L;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.getNativeMapsLink = function({ lat, lng, label = 'Destination' }) {
    const isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);
    const isAndroid = /Android/i.test(navigator.userAgent);
    const coords = `${lat},${lng}`;

    if (isIOS) {
        return `maps://?q=${encodeURIComponent(label)}&ll=${coords}`;
    } else if (isAndroid) {
        return `geo:${coords}?q=${encodeURIComponent(label)} (${coords})`;
    } else {
        return `https://www.google.com/maps/search/?api=1&query=${coords}`;
    }
};
