
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key',
//     cluster: 'mt1',
//     encrypted: true
// });

/**
 * service worker tasks
 */
var swRegistration = null;
if ('serviceWorker' in navigator && 'PushManager' in window) {
	navigator.serviceWorker.register('/sw.js')
	.then(function(swReg) {
		swRegistration = swReg;
	})
	.catch(function(error) {
		console.error('Service Worker Error', error);
	});
} else {
	console.warn('Push messaging is not supported');
	//pushButton.textContent = 'Push Not Supported';
}

function askPermission() {
	return new Promise(function(resolve, reject) {
		const permissionResult = Notification.requestPermission(function(result) {
			resolve(result);
		});
		if (permissionResult) {
			permissionResult.then(resolve, reject);
		}
	})
	.then(function(permissionResult) {
		if (permissionResult !== 'granted') {
			throw new Error('Impossible d\'obtenir la permission');
		} else {
			subscribeUserToPush();
		}
	})
}

function getSWRegistration() {
	var promise = new Promise(function(resolve, reject) {
		if (swRegistration != null) {
			resolve(swRegistration);
		} else {
			reject(Error('It brokes'));
		}
	});
	return promise;
}

function urlBase64ToUint8Array(base64String) {
	const padding = '='.repeat((4 - base64String.length % 4) % 4);
	const base64 = (base64String + padding)
		.replace(/\-/g, '+')
		.replace(/_/g, '/');
	const rawData = window.atob(base64);
	const outputArray = new Uint8Array(rawData.length);
	for (let i = 0; i < rawData.length; ++i) {
		outputArray[i] = rawData.charCodeAt(i);
	}
	return outputArray;
}

function subscribeUserToPush() {
	getSWRegistration()
	.then(function(registration) {
		console.log('registration', registration);
		const subscribeOptions = {
			userVisibleOnly: true,
			applicationServerKey: urlBase64ToUint8Array('BNp7AjH7Eh/pVxMJ9u+c3bLWKsrl7Hp9JyXUuMP479siq1qF+/AYCe0IJdO9s3ktfBYEmzROFvHtayt+CslwquA=')
		};
		return registration.pushManager.subscribe(subscribeOptions);
	})
	.then(function(pushSubscription) {
		console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
		sendSubscriptionToBackend(pushSubscription);
		return pushSubscription;
	});
}

function sendSubscriptionToBackend(subscription) {
	return fetch('/api/save-subscription/1', {
    	method: 'POST',
    	headers: {
      		'Content-Type': 'application/json'
    	},
    	body: JSON.stringify(subscription)
  	})
  	.then(function(response) {
  		if (!response.ok) {
  			throw new Error('Bad status code from server.');
  		}
  		return response.json();
  	})
  	.then(function(responseData) {
  		if (!(responseData && responseData.success)) {
  			throw new Error('Bad response from server.');
  		}
  	});
}

function enableNotifications(){
  //register service worker
  //check permission for notification/ask
  askPermission();
}

// enableNotifications();