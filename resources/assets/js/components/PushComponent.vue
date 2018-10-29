<template>
  <div>
    <aside id="push-component-dialog" class="mdc-dialog" aria-labelledby="push-component-dialog-label" aria-describedby="push-component-dialog-description">
      <div class="mdc-dialog__surface">
        <header class="mdc-dialog__header">
          <h2 id="push-component-dialog-label" class="mdc-dialog__header__title">Notifications</h2>
        </header>
        <section id="push-component-dialog-description" class="mdc-dialog__body">
          <p>Afin de recevoir les informations concernant vos clubs et événements, veuillez autoriser les notifications.</p>
        </section>
        <footer class="mdc-dialog__footer">
          <button type="button" class="mdc-button mdc-dialog__footer__button mdc-dialog__footer__button--cancel" :disabled="isButtonDisabled">Fermer</button>
          <button type="button" class="mdc-button mdc-dialog__footer__button mdc-dialog__footer__button--default" @click="subscribe" :disabled="isButtonDisabled">Autoriser les notifications</button>
        </footer>
      </div>
      <div class="mdc-dialog__backdrop"></div>
    </aside>

    <aside id="push-component-fail-dialog" class="mdc-dialog" aria-labelledby="push-component-fail-dialog-label" aria-describedby="push-component-fail-dialog-description">
      <div class="mdc-dialog__surface">
        <header class="mdc-dialog__header">
          <h2 id="push-component-fail-dialog-label" class="mdc-dialog__header__title">Notifications</h2>
        </header>
        <section id="push-component-fail-dialog-description" class="mdc-dialog__body">
          <p>Vous avez bloqué les notifications mais il est encore possible de les débloquer.</p>
        </section>
        <footer class="mdc-dialog__footer">
          <button type="button" class="mdc-button mdc-dialog__footer__button mdc-dialog__footer__button--cancel">Fermer</button>
          <button type="button" class="mdc-button mdc-dialog__footer__button mdc-dialog__footer__button--default" @click="unblock">Comment faire ?</button>
        </footer>
      </div>
      <div class="mdc-dialog__backdrop"></div>
    </aside>
  </div>
</template>

<script>
  import {MDCDialog} from '@material/dialog';
  export default {
    props: ['userId', 'pushSubscriptionEndpoints'],
    data () {
      return {
        isButtonDisabled: false
      }
    },
    mounted() {
      let scope = this;
      this.dialog = new MDCDialog(document.querySelector('#push-component-dialog'));
      this.failDialog = new MDCDialog(document.querySelector('#push-component-fail-dialog'));
      if (this.pushSubscriptionEndpoints.length > 0) {
        navigator.serviceWorker.ready.then(function(registration) {
          registration.pushManager.getSubscription().then(function(subscription) {
            if (subscription === null || subscription.endpoint === null || JSON.parse(scope.pushSubscriptionEndpoints).indexOf(subscription.endpoint) === -1) {
              scope.dialog.show()
            }
          })
        })
      }
    },
    methods: {
      disableButtons: function(value) {
        this.isButtonDisabled = value
      },

      subscribe: function() {
        let scope = this;
        this.disableButtons(true);
        navigator.serviceWorker.ready.then(function(registration) {
          const subscribeOptions = {
            userVisibleOnly: true,
            applicationServerKey: scope.urlBase64ToUint8Array('BNp7AjH7Eh/pVxMJ9u+c3bLWKsrl7Hp9JyXUuMP479siq1qF+/AYCe0IJdO9s3ktfBYEmzROFvHtayt+CslwquA=')
          };
          return registration.pushManager.subscribe(subscribeOptions)
        }).then(function(pushSubscription) {
          scope.sendSubscriptionToBackend(pushSubscription).then(function() {
            scope.dialog.close()
          });
          return pushSubscription;
        }).catch(function() {
          scope.dialog.close();
          scope.failDialog.show();
          return null;
        })
      },

      unblock: function() {
        console.log('go to faq');
      },

      sendSubscriptionToBackend: function(subscription) {
        return fetch('/api/save-subscription/' + this.userId, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(subscription)
        })
        .then(function(response) {
          if (!response.ok) {
            throw new Error('Bad status code from server.')
          }
          return response.json()
        })
        .then(function(responseData) {
          if (!(responseData && responseData.success)) {
            throw new Error('Bad response from server.')
          }
        })
      },

      urlBase64ToUint8Array: function(base64String) {
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

    }
  }
</script>
