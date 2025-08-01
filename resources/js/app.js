import './bootstrap';

// Global function for native maps integration
window.getNativeMapsLink = function({ lat, lng, label }) {
    const encodedLabel = encodeURIComponent(label || 'Location');
    
    // Detect platform/device type
    const userAgent = navigator.userAgent || navigator.vendor || window.opera;
    const isIOS = /iPad|iPhone|iPod/.test(userAgent) && !window.MSStream;
    const isAndroid = /android/i.test(userAgent);
    
    if (isIOS) {
        // iOS - use Apple Maps
        return `maps://maps.apple.com/?q=${encodedLabel}&ll=${lat},${lng}&z=15`;
    } else if (isAndroid) {
        // Android - use Google Maps
        return `geo:${lat},${lng}?q=${lat},${lng}(${encodedLabel})&z=15`;
    } else {
        // Web/Desktop - use Google Maps
        return `https://maps.google.com/maps?q=${lat},${lng}&z=15`;
    }
};
