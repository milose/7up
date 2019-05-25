import Vue from 'vue'

window.Vue = Vue

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key =>
  Vue.component(
    key
      .split('/')
      .pop()
      .split('.')[0],
    files(key).default
  )
)

new Vue({
  el: '#app',

  data: {
    tabs: [0, 1, 2],
    tabVisibilty: []
  },

  created () {
    for (const tab of this.tabs) {
      this.tabVisibilty.push(tab === 0)
    }
  },

  methods: {
    selectTab (tab) {
      this.tabVisibilty = this.tabVisibilty.map((visible, id) => id === tab)
    },

    getTabClass (tab) {
      return this.tabVisibilty[tab] ? 'tabActive' : 'tabInactive'
    },

    getContainerClass (tab) {
      return this.tabVisibilty[tab] ? 'block' : 'hidden'
    }
  }
})
