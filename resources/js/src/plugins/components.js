import Vue from 'vue'

import InputComponent from '@Components/__partials/InputComponent.vue'
import InputPasswordComponent from '@Components/__partials/InputPasswordComponent.vue'
import SidebarComponent from '@Components/__partials/SidebarComponent.vue'
import CardComponent from '@Components/__partials/CardComponent.vue'
import TableComponent from '@Components/__partials/TableComponent.vue'
import UpdateOrCreateComponent from '@Components/__partials/UpdateOrCreateComponent.vue'
import FormComponent from '@Components/__partials/FormComponent.vue'
import AlertComponent from '@Components/__partials/AlertComponent.vue'
import DialogComponent from '@Components/__partials/DialogComponent.vue'
import RadioButtonComponent from '@Components/__partials/RadioButtonComponent.vue'
import AutoCompleteComponent from '@Components/__partials/AutoCompleteComponent.vue'
import SwitchComponent from '@Components/__partials/SwitchComponent.vue'
import TableTabuSearchResult from '@Components/__partials/TableTabuSearchResult.vue'

Vue.component('input-component', InputComponent)
Vue.component('input-password', InputPasswordComponent)
Vue.component('sidebar', SidebarComponent)
Vue.component('card-component', CardComponent)
Vue.component('table-component', TableComponent)
Vue.component('update-or-create-component', UpdateOrCreateComponent)
Vue.component('form-component', FormComponent)
Vue.component('alert-component', AlertComponent)
Vue.component('dialog-component', DialogComponent)
Vue.component('radio-button-component', RadioButtonComponent)
Vue.component('auto-complete-component', AutoCompleteComponent)
Vue.component('switch-component', SwitchComponent)
Vue.component('table-tabu-search', TableTabuSearchResult)

// Global Function Handlers

const customHelpers = {
  install(Vue) {
    Vue.prototype.payloadParser = (fields) => {
      var payload = {}

      fields.forEach((element) => {
        payload[element.name] = element.text
      })

      return payload
    }

    Vue.prototype.payloadResetter = (fields) => {
      return fields.forEach((element) => {
        return (element.text = null)
      })
    }
  },
}

Vue.use(customHelpers)
