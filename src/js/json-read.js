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
      embedURL: {
        id: '',
        user: '',
        url: 'https://start.me/p/DPQNjG/top',
        postId: '',
        locationURL: locationURL,
        link: '',
      },
      isNote: false,
      searchWord: '',
      isOpenManageArray: [],
    };
  },
  mounted() {
    // loginChecker
    // if (this.$refs.loginChecker) {
    //   // 管理画面にログインしている場合
    //   this.restCatURL = `${locationURL}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1`;
    // } else {
    //   // 管理画面にログインしていない場合
    //   this.restCatURL = `${locationURL}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1`;
    // }
    this.restCatURL = `${locationURL}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1`;
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
          // console.log(n.id);
          let tmp_arr2 = {};
          tmp_arr2.id = n.id;
          tmp_arr2.isOpen = false;
          this.isOpenManageArray.push(tmp_arr2);

          if (n.parent === 0) {
            n.children = [];
            // tmp_arr2.id = n.id;
            // tmp_arr2.isOpen = false;
            // console.log(tmp_arr2);
            // this.isOpenManageArray.push(tmp_arr2);
            // console.log(this.isOpenManageArray);
            // n.isOpen = false;
            for (const nn of data) {
              if (n.id === nn.parent) {
                nn.children = [];
                // nn.isOpen = false;
                // tmp_arr3.id = nn.id;
                // tmp_arr3.isOpen = false;
                // console.log(tmp_arr3);
                // this.isOpenManageArray.push(tmp_arr3);
                // console.log(this.isOpenManageArray);
                n.children.push(nn);
                for (const nnn of data) {
                  if (nn.id === nnn.parent) {
                    nnn.children = [];
                    // nnn.isOpen = false;
                    // tmp_arr4.id = nnn.id;
                    // tmp_arr4.isOpen = false;
                    // this.isOpenManageArray.push(tmp_arr4);
                    // console.log(this.isOpenManageArray);
                    nn.children.push(nnn);
                    for (const nnnn of data) {
                      if (nnn.id === nnnn.parent) {
                        nnn.children.push(nnnn);
                      }
                    }
                  }
                }
              }
            }
            tmp_arr.push(n);
          }
        }
        this.restCatData = tmp_arr;
        // console.log(this.restCatData);
        // console.log(this.isOpenManageArray);
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
    checkIsOpen(id) {
      for (const n of this.isOpenManageArray) {
        if (n.id === id) {
          // n.isOpen = !n.isOpen;
          return n.isOpen;
        }
      }
    },
    async readPosts(id) {
      // const res = await fetch(new URL(this.restCatURL));
      //   const data = await res.json();
      for (const n of this.isOpenManageArray) {
        if (n.id === id) {
          n.isOpen = !n.isOpen;
        }
      }
      try {
        const url = `${locationURL}/wp-json/wp/v2/posts?_embed&per_page=100&page=1&categories=${id}`;
        const res = await fetch(new URL(url));
        const data = await res.json();
        if (data.length > 0) {
          this.postData = []; // 初期化
          this.postData = data;
          // console.log(url);
          // console.log(data);
        }
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
    readAdmin(url) {
      this.embedURL = { id: '', user: '', url: '', postId: '', locationURL: '', link: '' };
      this.embedURL.url = url;
    },
    readPage(obj) {
      console.log(obj.acf.cf_URL !== undefined);
      this.embedURL = { id: '', user: '', url: '', postId: '', locationURL: '', link: '' };
      this.embedURL.postId = obj.id;
      if (obj.acf.cf_URL && obj.acf.cf_URL !== undefined) {
        if (obj.acf.cf_URL.indexOf('codepen') !== -1) {
          this.isNote = false;
          this.embedURL.id = obj.acf.cf_URL.match(/pen\/(.*)/)[1];
          this.embedURL.user = obj.acf.cf_URL.match(/io\/(.*)\/pen/)[1];
          this.embedURL.url = obj.acf.cf_URL;

          this.embedURL.locationURL = locationURL;
          if (obj.tags !== false) {
            for (const n of obj.tags) {
              if (n.slug === 'note') {
                this.isNote = true;
              }
            }
          }
        } else {
          this.embedURL.url = obj.acf.cf_URL;
          this.embedURL.locationURL = locationURL;
        }
      } else {
        console.log(obj.link);
        this.embedURL.link = obj.link;
      }
      // if (url) {
      //   if (url.indexOf('codepen') !== -1) {
      //     this.embedURL = { id: '', user: '', url: '', postId: '', locationURL: '' };
      //     this.isNote = false;
      //     this.embedURL.id = url.match(/pen\/(.*)/)[1];
      //     this.embedURL.user = url.match(/io\/(.*)\/pen/)[1];
      //     this.embedURL.url = url;
      //     this.embedURL.postId = postId;
      //     this.embedURL.locationURL = locationURL;
      //     if (tags !== false) {
      //       for (const n of tags) {
      //         if (n.slug === 'note') {
      //           this.isNote = true;
      //         }
      //       }
      //     }
      //   } else {
      //     this.embedURL = { id: '', user: '', url: '', postId: '', locationURL: '' };
      //     this.embedURL.url = url;
      //     this.embedURL.postId = postId;
      //     this.embedURL.locationURL = locationURL;
      //   }
      // }
      console.log(this.embedURL);
    },
    onReset() {
      this.embedURL = {
        id: '',
        user: '',
        url: 'https://start.me/p/DPQNjG/top',
        postId: '',
        locationURL: '',
        link: '',
      };
      this.postData = [];
    },
    async onSearchSubmit() {
      console.log('submit!');
      try {
        const url = `${locationURL}/wp-json/wp/v2/posts?_embed&per_page=100&page=1&search=${this.searchWord}`;
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
  },
}).mount('.vue_app');
