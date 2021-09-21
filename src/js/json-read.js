// ==================================================
// setting
// ==================================================
const locationURL = window.location.origin;
const defaultURL = 'https://start.me/p/DPQNjG/top';
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
      catId: null,
      embedURL: {
        id: '',
        user: '',
        url: defaultURL, // ログイン時の初期ページ
        postId: '',
        locationURL: locationURL,
        link: '',
      },
      isNote: false,
      searchWord: '',
      isOpenManageArray: [],
      readPostInterval: null,
      isMouseOver: false,
      isSidebarLeft: true,
    };
  },
  mounted() {
    // loginChecker(refが表示されていればログイン)
    // if (this.$refs.loginChecker) {
    //   // 管理画面にログインしている場合
    //   this.restCatURL = `${locationURL}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1`;
    // } else {
    //   // 管理画面にログインしていない場合
    //   this.restCatURL = `${locationURL}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1`;
    // }
    this.restCatURL = `${locationURL}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1`;
    // console.log(this.restCatURL);
    this.init();
  },
  methods: {
    // --------------------------------------------------
    // カテゴリリストを取得
    // --------------------------------------------------
    async init(mover = true) {
      // console.log('init');
      try {
        const res = await fetch(new URL(this.restCatURL));
        const data = await res.json();
        let tmp_arr = [];

        for (const n of data) {
          if (mover) {
            // サイドバーのマウスオーバーで開閉されないように
            let tmp_arr2 = {};
            tmp_arr2.id = n.id;
            tmp_arr2.isOpen = false;
            this.isOpenManageArray.push(tmp_arr2);
          }

          if (n.parent === 0) {
            n.children = [];
            for (const nn of data) {
              if (n.id === nn.parent) {
                nn.children = [];
                n.children.push(nn);
                for (const nnn of data) {
                  if (nn.id === nnn.parent) {
                    nnn.children = [];
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
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
    // --------------------------------------------------
    // 投稿ポストを取得
    // --------------------------------------------------
    async readPosts(id, mover = true) {
      if (mover) {
        // サイドバーのマウスオーバーで開閉されないように
        this.catId = id;
        for (const n of this.isOpenManageArray) {
          if (n.id === id) {
            n.isOpen = !n.isOpen;
          }
        }
      }

      try {
        const url = `${locationURL}/wp-json/wp/v2/posts?_embed&per_page=100&page=1&categories=${id}`;
        const res = await fetch(new URL(url));
        const data = await res.json();
        if (data.length > 0) {
          this.postData = []; // 初期化
          this.postData = data;
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
      // console.log(obj.acf.cf_URL !== undefined);
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
      // console.log(this.embedURL);
    },
    // --------------------------------------------------
    // メニュー開閉
    // --------------------------------------------------
    checkIsOpen(id) {
      for (const n of this.isOpenManageArray) {
        if (n.id === id) {
          return n.isOpen;
        }
      }
    },
    // --------------------------------------------------
    // トップに戻るボタン的な(リセット)
    // --------------------------------------------------
    onReset() {
      this.embedURL = {
        id: '',
        user: '',
        url: defaultURL,
        postId: '',
        locationURL: '',
        link: '',
      };
      this.postData = [];
    },
    // --------------------------------------------------
    // 検索クエリ処理
    // --------------------------------------------------
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
    // --------------------------------------------------
    // 擬似vuex(状態管理): サイドバーにマウスオーバしたらサイドメニューを更新
    // --------------------------------------------------
    catMouseOver() {
      if (!this.isMouseOver) {
        this.init(false);
        if (this.catId) {
          // console.log(this.catId);
          this.readPosts(this.catId, false);
          // this.checkIsOpen(this.catId);
        }
        this.isMouseOver = true;
      }
    },
    catMouseLeave() {
      // console.log('leave');
      this.isMouseOver = false;
    },
    switchSidebar() {
      this.isSidebarLeft = !this.isSidebarLeft;
    },
    test() {
      // console.log('test');
    },
  },
}).mount('.vue_app');
