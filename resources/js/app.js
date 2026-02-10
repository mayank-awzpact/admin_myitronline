import './bootstrap';

import { tns } from "tiny-slider/src/tiny-slider";

document.addEventListener("DOMContentLoaded", function() {
    var slider = tns({
        container: "#trending-slider",
        items: 1, // Show one item at a time
        autoplay: true, // Enable auto-slide
        autoplayTimeout: 3000, // Slide every 3 seconds
        autoplayButtonOutput: false,
        controls: true, // Enable prev/next buttons
        nav: false, // Hide dots navigation
        speed: 500, // Smooth transition
        mouseDrag: true,
        loop: true,
        controlsContainer: ".tns-controls"
    });
});
