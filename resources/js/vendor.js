import _ from 'lodash'
import axios from 'axios'

window._ = _
window.axios = axios

const token = document.head.querySelector('meta[name="csrf-token"]')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
}
