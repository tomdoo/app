<template>
  <div>
    <span v-if="displayButton" class="btn btn-default" @click="subscribe" :disabled="isButtonDisabled">
      Activer les notifications
    </span>
  </div>
</template>

<script>
  export default {
    props: ['userId', 'pushSubscriptionEndpoints'],
    data () {
      return {
        displayButton: false,
        isButtonDisabled: false
      }
    },
    mounted() {
      var scope = this
      this.showButton(Notification.permission !== 'granted')

      if (this.pushSubscriptionEndpoints.length > 0) {
        navigator.serviceWorker.ready.then(function(registration) {
          registration.pushManager.getSubscription().then(function(subscription) {
            if (JSON.parse(scope.pushSubscriptionEndpoints).indexOf(subscription.endpoint) === -1) {
              scope.showButton(true)
            }
          })
        })
      }
    },
    methods: {
      showButton: function(value) {
        this.displayButton = value
      },

      disableButton: function(value) {
        this.isButtonDisabled = value
      },
      
      subscribe: function() {
        var scope = this
        this.disableButton(true)
        navigator.serviceWorker.ready.then(function(registration) {
          const subscribeOptions = {
            userVisibleOnly: true,
            applicationServerKey: scope.urlBase64ToUint8Array('BNp7AjH7Eh/pVxMJ9u+c3bLWKsrl7Hp9JyXUuMP479siq1qF+/AYCe0IJdO9s3ktfBYEmzROFvHtayt+CslwquA=')
          }
          return registration.pushManager.subscribe(subscribeOptions)
        }).then(function(pushSubscription) {
          scope.sendSubscriptionToBackend(pushSubscription).then(function() {
            scope.showButton(false)
          })
          return pushSubscription;
        })
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
