var swRegistration = null;
if ('serviceWorker' in navigator && 'PushManager' in window) {
    navigator.serviceWorker.register('/sw.js')
        .then(function(swReg) {
            swRegistration = swReg;
            console.log('registered');
        })
        .catch(function(error) {
            console.error('Service Worker Error', error);
        });
} else {
    console.warn('Push messaging is not supported');
}

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import $ from 'jquery';

Vue.component('menu-component', require('./components/MenuComponent.vue'));
Vue.component('push-component', require('./components/PushComponent.vue'));
Vue.component('graph-component', require('./components/GraphComponent.vue'));

const app = new Vue({
    el: '#app'
});

// Material
import {MDCRipple} from '@material/ripple';
import {MDCTextField} from '@material/textfield';
import {MDCTextFieldIcon} from '@material/textfield/icon';
import {MDCTextFieldHelperText} from '@material/textfield/helper-text';

$('.mdc-button').each(function(i, el) {
    let buttonRipple = new MDCRipple(el);
});
$('.mdc-text-field').each(function(i, el) {
    let textField = new MDCTextField(el);
});
$('.mdc-text-field-icon').each(function(i, el) {
    let icon = new MDCTextFieldIcon(el);
});
$('.mdc-text-field-helper-text').each(function(i, el) {
    let helperText = new MDCTextFieldHelperText(el);
});
