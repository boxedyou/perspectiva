Fancybox.bind(`[data-fancybox="certificates-gallery"]`, {
    Thumbs: {
        type: "classic",
    },
});

Fancybox.bind('[data-fancybox="production-gallery"]', {
    Thumbs: { autoStart: true },
    Toolbar: {
        display: [
            "close",
            "zoom",
            "fullscreen",
            "thumbs"
        ]
    }
});

Fancybox.bind('[data-fancybox="hero-production-video"]', {
});

Fancybox.bind('[data-fancybox^="news-gallery"]', {
    Thumbs: { type: 'classic' },

});






