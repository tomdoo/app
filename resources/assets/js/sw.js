let cacheName = 'upsession-0.1';
let cachedUrls = [
    '/',
];

self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(cacheName)
        .then(function(cache) {
            return cache.addAll(cachedUrls);
        })
    );
});
self.addEventListener('fetch', function (event) {
    //
});
