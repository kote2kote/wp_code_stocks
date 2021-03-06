// ==================================================
// setting
// ==================================================
const locationURL = window.location.origin;
// const defaultURL = `https://code-stocks.kote2.co/archives/802`;
const defaultURL = `https://start.me/p/DPQNjG/top`;
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
      // restCatURL: `${locationURL}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1`,
      restCatURL: `${locationURL}/wp-json/wp/v2/categories?_embed&per_page=100`,
      restCatData: [],
      // restPostURL: `${locationURL}/wp-json/wp/v2/posts?_embed&per_page=100&page=1&categories_exclude=1`,
      restPostURL: `${locationURL}/wp-json/wp/v2/posts?_embed&per_page=100&page=1`,
      restAllPostURL: `${locationURL}/wp-json/custom/v1/allposts`,
      allPostData: [],
      limitPostsNum: 100,
      postData: [],
      // restDefaultMenuURL: `${locationURL}/wp-json/wp/v2/posts?_embed&per_page=100&categories=61`, // 初回メニュー表示。お気に入りのカテゴリIDなど。
      // defaultMenuData: [],
      catId: null,
      embedURL: {
        id: '',
        user: '',
        url: defaultURL, // ログイン時の初期ページ
        postId: '',
        locationURL: '',
        link: '',
      },
      isNote: false,
      searchWord: '',
      isOpenManageArray: [],
      readPostInterval: null,
      isMouseOver: false,
      isSidebarLeft: true,
      isMobileToggle: false,
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
    // this.restCatURL = `${locationURL}/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1`;
    // console.log(this.restCatURL);
    this.init();
    // this.initMenu();
    this.getAllPosts();
  },
  methods: {
    changeMobile() {
      console.log('isMobile', this.isMobileToggle);
      this.isMobileToggle = !this.isMobileToggle;
    },
    async getAllPosts() {
      try {
        const res = await fetch(new URL(this.restAllPostURL));
        const data = await res.json();
        // console.log(data);
        this.allPostData = data;
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
    // --------------------------------------------------
    // カテゴリリストを取得
    // --------------------------------------------------
    async init(mover = true) {
      try {
        const res = await fetch(new URL(this.restCatURL));
        const data = await res.json();

        let tmp_arr = [];
        for (const n of data) {
          if (mover) {
            // サイドバーのマウスオーバーで開閉されないように
            let tmp_arr2 = {};
            tmp_arr2.id = n.id;
            tmp_arr2.isOpen = true; // タブを初期に閉じたい場合はfalse
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

      tmpPostData = []; // 初期化
      try {
        // const url = `${locationURL}/wp-json/wp/v2/posts?_embed&per_page=100&page=1&categories=${id}`;
        // const res = await fetch(new URL(url));
        // const data = await res.json();
        const res = await fetch(new URL(this.restAllPostURL));
        const data = await res.json();

        if (data.length > 0) {
          for (const n of data) {
            for (const nn of n.categories) {
              if (id === nn.term_id) {
                // console.log(nn.term_id, id);
                tmpPostData.push(n);
              }
            }
          }
          // console.log(tmpPostData);
          if (tmpPostData.length === 0) {
            return;
          } else {
            this.postData = tmpPostData;
            // console.log(this.postData);
          }
        }
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
    // --------------------------------------------------
    // URLのみiframeに渡す
    // --------------------------------------------------
    readURL(url) {
      this.embedURL = { id: '', user: '', url: '', postId: '', locationURL: '', link: '' };
      this.embedURL.url = url;
    },
    // --------------------------------------------------
    // acfかcodepen等のURLか判別して表示
    // --------------------------------------------------
    readPage(obj) {
      // console.log(obj);
      this.embedURL = { id: '', user: '', url: '', postId: '', locationURL: '', link: '' };
      this.embedURL.postId = obj.id;
      let acfURL = '';

      if (obj.rest) {
        acfURL = obj.acf.cf_URL[0]; // カスタムrestAPI(function.php)
      } else {
        acfURL = obj.acf.cf_URL; // 標準restAPI
      }

      if (acfURL) {
        if (acfURL.indexOf('codepen') !== -1) {
          // console.log('codepen');
          // this.isNote = false;
          this.embedURL.id = acfURL.match(/pen\/(.*)/)[1];
          this.embedURL.user = acfURL.match(/io\/(.*)\/pen/)[1];
          this.embedURL.url = acfURL;

          this.embedURL.locationURL = locationURL;
          // if (obj.tags !== false) {
          //   for (const n of obj.tags) {
          //     if (n.slug === 'note') {
          //       this.isNote = true;
          //     }
          //   }
          // }
        } else {
          // console.log('codepenじゃない');
          // if (obj.tags !== false) {
          //   for (const n of obj.tags) {
          //     if (n.slug === 'blank') {
          //       // window.location.href = acfURL;
          //       window.open(acfURL, '_blank');
          //       return;
          //     }
          //   }
          // }
          this.embedURL.url = acfURL;
          this.embedURL.locationURL = locationURL;
        }
      } else {
        this.embedURL.link = obj.link;
      }
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
      this.catId = null;
      this.postData = [];
      this.getAllPosts();
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
          // console.log(data);
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
      // console.log(this.isMouseOver, 'オーバー', this.catId);
      if (!this.isMouseOver) {
        this.init(false);
        if (this.catId) {
          // console.log(this.catId);
          this.readPosts(this.catId, false);
          // this.checkIsOpen(this.catId);
        } else {
          this.getAllPosts();
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
    returnDate(data) {
      const dt = new Date(data);
      return dt.toLocaleDateString();
    },
    test() {
      // console.log('test');
    },
  },
}).mount('.vue_app');
