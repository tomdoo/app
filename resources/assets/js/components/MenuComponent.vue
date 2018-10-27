<template>
  <nav id="menu-primary">
    <div class="mdc-layout-grid">
      <div class="mdc-layout-grid__inner">
        <div v-if="subElements" class="element sub-menu center mdc-layout-grid__cell--span-1-phone mdc-layout-grid__cell--span-2-tablet mdc-layout-grid__cell--span-3-desktop">
          <i class="material-icons md-36" v-on:click="displayMenu">menu</i>
        </div>
        <div
          v-for="(element, key) in elements"
          :key="key"
          v-on:click="route(element.route)"
          class="element center mdc-layout-grid__cell--span-1-phone mdc-layout-grid__cell--span-2-tablet mdc-layout-grid__cell--span-3-desktop"
        >
          <i class="material-icons md-36">{{element.icon}}</i>
        </div>
      </div>
    </div>

    <aside id="sub-menu-dialog" class="mdc-dialog" role="alertdialog" aria-labelledby="sub-menu-dialog-label" aria-describedby="sub-menu-dialog-description">
      <div class="mdc-dialog__surface">
        <header class="mdc-dialog__header">
          <h2 id="sub-menu-dialog-label" class="mdc-dialog__header__title">Menu</h2>
        </header>
        <section id="sub-menu-dialog-description" class="mdc-dialog__body">
          <ul class="mdc-list" aria-orientation="vertical">
            <li
              v-for="(element, key) in subElements"
              :key="key"
              v-on:click="route(element.route)"
              class="sub-element mdc-list-item mdc-ripple-upgraded"
            >
              <span class="mdc-list-item__graphic material-icons" aria-hidden="true">{{element.icon}}</span>{{element.name}}
            </li>
          </ul>
        </section>
        <footer class="mdc-dialog__footer">
          <button type="button" class="mdc-button mdc-dialog__footer__button mdc-dialog__footer__button--cancel">Fermer</button>
        </footer>
      </div>
      <div class="mdc-dialog__backdrop"></div>
    </aside>
  </nav>
</template>

<script>
  import {MDCDialog} from '@material/dialog';
  export default {
    props: ['elements', 'subElements'],
    data () {
      return {
      }
    },
    mounted() {
      var scope = this
      this.dialog = new MDCDialog(document.querySelector('#sub-menu-dialog'))
    },
    methods: {
      displayMenu: function() {
        this.dialog.show()
      },
      route: function(route) {
        this.dialog.close()
        window.location.href = route
      }
    }
  }
</script>
