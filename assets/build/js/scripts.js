// ==================================================
// debug tool
// ==================================================
let isDebugMode = false;
const domDebug = document.querySelector('.js_debug');
function openDebug(e) {
  console.log(e);
  let isOK = false;
  if (e.keyCode === 65) {
    // z
    isDebugMode = !isDebugMode;
    if (isDebugMode) {
      domDebug.classList.remove('hidden');
    } else {
      domDebug.classList.add('hidden');
    }
  }
}
window.addEventListener('keyup', openDebug);

// ==================================================
// setting
// ==================================================
const locationURL = window.location.origin;
let isProd = false;

// 開発環境か本番環境か
if (locationURL.indexOf('localhost') === -1) {
  isProd = true; // 本番環境
}

// 管理画面にログインしていない場合に表示しないカテゴリid
// const excludeCategory = isProd ? '4+9+43+52+53' : '26+29+28+13+54'; // 左:本番、右:開発
const excludeCategory = isProd ? '' : ''; // 左:本番、右:開発

// ==================================================
// main script
// ==================================================

const jsonRead = Vue.createApp({
  data() {
    return {
      restCatURL: '',
      restCatData: [],
      postData: [],
      embedURL: { id: '', user: '', url: '', postId: '', locationURL: locationURL },
      isNote: false,
    };
  },
  mounted() {
    if (this.$refs.loginChecker) {
      // 管理画面にログインしている場合
      this.restCatURL = `${locationURL}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1`;
    } else {
      // 管理画面にログインしていない場合
      this.restCatURL = `${locationURL}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1+${excludeCategory}`;
    }
    console.log(this.restCatURL);
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
        const url = `${locationURL}/wp-json/wp/v2/posts?_embed&per_page=100&page=1&categories=${id}`;
        const res = await fetch(new URL(url));
        const data = await res.json();
        if (data.length > 0) {
          this.postData = []; // 初期化
          this.postData = data;
          console.log(data);
        }
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
    async readPage(url, tags, postId) {
      console.log(postId);
      if (url) {
        if (url.indexOf('codepen') !== -1) {
          this.embedURL = { id: '', user: '', url: '', postId: '', locationURL: '' };
          this.isNote = false;
          this.embedURL.id = url.match(/pen\/(.*)/)[1];
          this.embedURL.user = url.match(/io\/(.*)\/pen/)[1];
          this.embedURL.url = url;
          this.embedURL.postId = postId;
          this.embedURL.locationURL = locationURL;
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
          this.embedURL.locationURL = locationURL;
        }
      }
    },
  },
}).mount('.vue_app');



// ==================================================
// test_json-read.js
// ==================================================

// -- PHP用 -------------- //
const testjsonRead = Vue.createApp({
  data() {
    return {
      jsonURL: 'http://localhost:10058/test/json/',
      jsonData: [],
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    async init() {
      try {
        const res = await fetch(new URL(this.jsonURL));
        const data = await res.json();
        this.jsonData = data;
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
  },
}).mount('.vue_test01');

// -- restAPI用 -------------- //
const testjsonRead2 = Vue.createApp({
  data() {
    return {
      jsonURL: 'http://localhost:10058/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1',
      jsonData: [],
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    async init() {
      try {
        const res = await fetch(new URL(this.jsonURL));
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
        console.log(tmp_arr);
        this.jsonData = tmp_arr;
        // console.log(this.jsonData);
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
  },
}).mount('.vue_test02');
