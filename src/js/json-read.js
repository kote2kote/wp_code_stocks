// ==================================================
// json-read.js
// ==================================================

// -- restAPI用 -------------- //
const jsonRead = Vue.createApp({
  data() {
    return {
      restCatURL: '',
      restCatData: [],
      postData: [],
      embedURL: { id: '', user: '', url: '', postId: '', locationURL: window.location.origin },
      isNote: false,
    };
  },
  mounted() {
    if (this.$refs.loginChecker) {
      console.log('login now');
      this.restCatURL = `${window.location.origin}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1`;
    } else {
      console.log('logout now');
      this.restCatURL = `${window.location.origin}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1+26+29+28+13`;
    }
    this.init();
  },
  methods: {
    async init() {
      try {
        const res = await fetch(new URL(this.restCatURL));
        const data = await res.json();
        let tmp_arr = [];
        for (const n of data) {
          if (n.parent === 0) {
            n.children = [];
            for (const nn of data) {
              if (n.id === nn.parent) {
                nn.children = [];
                n.children.push(nn);
                for (const nnn of data) {
                  if (nn.id === nnn.parent) {
                    nn.children.push(nnn);
                  }
                }
              }
            }
            tmp_arr.push(n);
          }
        }
        // console.log(tmp_arr);
        this.restCatData = tmp_arr;
        // console.log(this.restCatData);
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
    async readPosts(id) {
      try {
        const url = `${this.embedURL.locationURL}/wp-json/wp/v2/posts?_embed&per_page=100&page=1&categories=${id}`;
        const res = await fetch(new URL(url));
        const data = await res.json();
        if (data.length > 0) {
          this.postData = []; // 初期化
          this.postData = data;
          // console.log(data[0].acf.cf_codepenURL);
        }
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
    async readCodepen(url, tags, postId) {
      console.log(postId);
      if (url) {
        if (url.indexOf('codepen') !== -1) {
          this.embedURL = { id: '', user: '', url: '', postId: '', locationURL: '' };
          this.isNote = false;
          this.embedURL.id = url.match(/pen\/(.*)/)[1];
          this.embedURL.user = url.match(/io\/(.*)\/pen/)[1];
          this.embedURL.url = url;
          this.embedURL.postId = postId;
          this.embedURL.locationURL = window.location.origin;
          if (tags !== false) {
            for (const n of tags) {
              if (n.slug === 'note') {
                this.isNote = true;
              }
            }
          }
        } else {
          this.embedURL = { id: '', user: '', url: '', postId: '', locationURL: '' };
          this.embedURL.url = url;
          this.embedURL.postId = postId;
          this.embedURL.locationURL = window.location.origin;
        }

        // this.iframeURL = url;
        // console.log(url.match(/io\/(.*)\/pen/)[1]);
        // console.log(url.match(/pen\/(.*)/)[1]);
      }
    },
  },
}).mount('.vue_app');
