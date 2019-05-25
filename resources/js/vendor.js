import _ from 'lodash'
import axios from 'axios'
import hljs from 'highlight.js/lib/highlight'
import bash from 'highlight.js/lib/languages/bash'
// import 'highlight.js/styles/solarized-dark.css'
import 'highlight.js/styles/mono-blue.css'
// import 'highlight.js/styles/atom-one-dark.css'
// import 'highlight.js/styles/tomorrow-night-blue.css'
// import 'highlight.js/styles/dracula.css'
// import 'highlight.js/styles/nord.css'

hljs.registerLanguage('bash', bash)
hljs.initHighlightingOnLoad()

window._ = _
window.axios = axios

const token = document.head.querySelector('meta[name="csrf-token"]')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
}
