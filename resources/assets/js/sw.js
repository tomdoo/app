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


self.addEventListener('push', function (event) {
	if (event.data) {
		var data = event.data.json()
		self.registration.showNotification(data.title, {
			body: data.body,
			icon: data.icon
		});
		console.log('This push event has data: ', event.data.text());
	} else {
		console.log('This push event has no data.');
	}
});