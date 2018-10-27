let cacheName = 'upteam-0.1';
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
  if (event.request.method === 'GET') {
    event.respondWith(
      caches.match(event.request)
        .then((cached) => {
          var networked = fetch(event.request)
            .then((response) => {
              let cacheCopy = response.clone()
              caches.open(cacheName)
                .then(cache => cache.put(event.request, cacheCopy))
              return response
            })
            .catch(() => caches.match('/'));
          return cached || networked
        })
    )
  }
  return null
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