// ==================================================
// jsonRead
// ==================================================

const jsonRead = {
  data() {
    return {
      jsonURL: 'http://localhost:10053/test/page-json/',
      // jsonURL: 'https://taxi-job.net/wp-json/wp/v2/categories',
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
};
Vue.createApp(jsonRead).mount('.js_json-read');

const jsonRead2 = {
  data() {
    return {
      jsonURL: 'http://localhost:10053/test/page-json/',
      // jsonURL: 'https://taxi-job.net/wp-json/wp/v2/categories',
      jsonData: [],
      jsonData2: [],
      isSelected: false,
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
        // console.log(data);
        /*
        タグidから名前選出
        */
        this.jsonData = data;
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
    onChange(val) {
      console.log(val.target.value);

      for (const n of this.jsonData) {
        if (n.id === Number(val.target.value)) {
          this.jsonData2 = n.municipalities;
        }
      }
      this.isSelected = true;
    },
  },
};
Vue.createApp(jsonRead2).mount('.js_json-form');

const jsonRead3 = {
  data() {
    return {
      jsonURL: 'http://localhost:10053/test/page-json2/',
      // jsonURL: 'https://taxi-job.net/wp-json/wp/v2/categories',
      jsonData: {},
      jsonData2: [],
      isSelected: false,
      isSelected2: false,
      prefectureData: [
        { id: 64, name: '東京都', search: '東京' },
        { id: 65, name: '神奈川県', search: '神奈川' },
        { id: 63, name: '埼玉県', search: '埼玉' },
        { id: 62, name: '千葉県', search: '千葉' },
      ],
      municipalitiesData: [],
      municipalitiesData2: [],
      selected1: null,
      selected2: null,
      selected3: null,
      selected4: null,
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
        this.jsonData = { ...data };
      } catch (e) {
        const { status, statusText } = error.response;
        console.log(`Error! HTTP Status: ${status} ${statusText}`);
      }
    },
    getPrefectureData(id) {
      for (const n of this.prefectureData) {
        if (id === n.id) {
          return n;
        }
      }
    },
    onChange(val) {
      console.log(val.target.value);
      this.municipalitiesData = [];

      for (const n of this.prefectureData) {
        if (n.id === Number(val.target.value)) {
          for (const nn of this.jsonData.municipalities) {
            if (nn.name.indexOf(n.search) != -1) {
              let tmp = {};
              let tmpName = nn.name;
              tmpName = tmpName.replace(/\s+/g, '');
              tmpName = tmpName.replace(`タクシー求人${n.search}`, '');
              tmp.name = tmpName;
              tmp.id = nn.id;

              this.municipalitiesData.push(tmp);
            }
          }
        }
      }
      this.isSelected = true;
    },
    onChange2(val) {
      // console.log(Number(val.target.value));
      for (const n of this.municipalitiesData) {
        if (n.id === Number(val.target.value)) {
          console.log(n.name);
        }
      }
    },
    onChange3(val) {
      console.log(val.target.value);
      this.municipalitiesData2 = [];
      // --------------------------------------------------
      // 都道府県IDから沿線データを渡す
      // --------------------------------------------------
      // 都道府県IDからWPカテゴリの説明の文字列数字の配列を
      // 配列化し数値化する

      // サブミット数値から都道府県IDを照合
      for (const n of this.prefectureData) {
        if (n.id === Number(val.target.value)) {
          // 都道府県判明

          // json側(page-json2.php)のデータからカテゴリの説明を取得
          for (const nn of this.jsonData.prefecture) {
            if (nn.id === n.id) {
              let arr = nn.desc.split(','); // カンマ区切りの文字列を配列化
              // ["245", "234", "236", "237", "246"]
              arr = arr.map(Number); // 文字列数字の配列を数値化
              // [245, 234, 236, 237, 246]

              // 配列のidとタグを照らし合わせてmunicipalitiesData2にわたす
              for (const nnn of arr) {
                // console.log(nnn)
                for (const nnnn of this.jsonData.municipalities) {
                  if (nnn === nnnn.id) {
                    console.log('見つけた！', nnnn.id);
                    let tmp = {};
                    tmp.id = nnnn.id;
                    tmp.name = nnnn.name;
                    this.municipalitiesData2.push(tmp);
                  }
                }
              }
            }
            //       if (nn.name.indexOf(n.search) != -1) {
            //         let tmp = {};
            //         let tmpName = nn.name;
            //         tmpName = tmpName.replace(/\s+/g, '');
            //         tmpName = tmpName.replace(`タクシー求人${n.search}`, '');
            //         tmp.name = tmpName;
            //         tmp.id = nn.id;

            //         this.municipalitiesData.push(tmp);
            //       }
          }
        }
      }
      this.isSelected2 = true;
    },
    onChange4(val) {
      // console.log(Number(val.target.value));
      for (const n of this.municipalitiesData2) {
        if (n.id === Number(val.target.value)) {
          console.log(n.name);
        }
      }
    },
    onSubmit() {
      console.log(this.selected1, this.selected2);
    },
    onSubmit2() {
      console.log(this.selected3, this.selected4);
    },
  },
};
Vue.createApp(jsonRead3).mount('.js_json-form2');

// const jsonRead = {
//   data() {
//     return {
//       jsonData: [],
//       // isLoad: false,
//       test: 'てすとだよん',
//       test2: '',
//     };
//   },
// };
// Vue.createApp(jsonRead).mount('.js_json-read');

// (async () => {
//   try {
//     // this.isLoad = true;
//     const url = 'http://localhost:10053/test/page-json/';
//     const res = await fetch(new URL(url)); // fetchを待ってから代入
//     const data = await res.json(); // resを待ってから代入
//     jsonRead.jsonData = data;
//     console.log(jsonRead.jsonData);
//     // jsonRead.data().test2 = jsonRead.data().test;
//   } catch (e) {
//     const { status, statusText } = error.response;
//     console.log(`Error! HTTP Status: ${status} ${statusText}`);
//   }
// })();

// 'use strict';

// fetch('http://localhost:10053/test/page-json/')
//   .then((response) => {
//     return response.json();
//   })
//   .then((res) => {
//     const jsonRead = {
//       data() {
//         return {
//           jsonData: res,
//           test: 'てすとだよん',
//         };
//       },
//     };
//     console.log(jsonRead.jsonData);
//     Vue.createApp(jsonRead).mount('.js_json-read');
//   })
//   .catch(function (error) {
//     console.log(error);
//   });

// const jsonRead = {
//   data() {
//     return {
//       test: 'Vue.js',
//     };
//   },
//   methods: {
//     init() {
//       console.log('test');
//       alert('test');
//     },
//   },
// };
// Vue.createApp(jsonRead).mount('.js_json-read');

// const jsonRead = {
//   data() {
//     return {
//       jsonData: [],
//       test: 'てすとだよん',
//       test2: '',
//     };
//   },
//   mounted() {
//     this.init();
//     // console.log('うっほー', this.jsonData);
//   },
//   methods: {
//     async init() {
//       try {
//         const url = 'http://localhost:10053/test/page-json/';
//         const res = await fetch(new URL(url)); // fetchを待ってから代入
//         const data = await res.json(); // resを待ってから代入
//         this.jsonData = data;
//       } catch (e) {
//         const { status, statusText } = error.response;
//         console.log(`Error! HTTP Status: ${status} ${statusText}`);
//       }
//     },
//     init2() {
//       try {
//         this.isLoad = true;
//         const url = 'http://localhost:10053/test/page-json/';
//         fetch(url)
//           .then((res) => res.json())
//           .then((data) => {
//             console.log(data);
//           });
//       } catch (e) {
//         const { status, statusText } = error.response;
//         console.log(`Error! HTTP Status: ${status} ${statusText}`);
//       }
//     },
//     init3() {
//       console.log('init3');
//     },
//   },
// };
// Vue.createApp(jsonRead).mount('.js_json-read');

// const url = 'http://localhost:10053/test/page-json/';
// fetch(url)
//   .then((res) => {
//     return res.json();
//   })
//   .then((data) => {
//     // console.log(data);
//     // jsonRead.jsonData = data;
//     // console.log(jsonRead.jsonData);]
//     const jsonRead = {
//       data() {
//         return {
//           jsonData: data,
//           test: 'てすとだよん',
//         };
//       },
//     };
//     Vue.createApp(jsonRead).mount('.js_json-read');
//   });
// async function callAxios() {
//   try {
//     const url = 'http://localhost:10053/test/page-json/';
//     const res = await fetch(new URL(url)); // fetchを待ってから代入
//     const data = await res.json(); // resを待ってから代入
//     // console.log(data);
//     jsonRead.jsonData = data;
//     console.log(jsonRead.jsonData);
//     // for (const i of data) {
//     //   log(`async/await/fetch => ${i.title.rendered}`);
//     // }
//   } catch (error) {
//     const { status, statusText } = error.response;
//     console.log(`Error! HTTP Status: ${status} ${statusText}`);
//   }
// }

// callAxios();
//   const Sec01 = Vue.createApp({
//   data() {
//     return {
//       message: "Hello " + new Date().toLocaleString()
//     };
//   },
//   mounted() {
//     //
//   },
//   methods: {
//     hello() {
//       console.log(this.message);
//     }
//   }
// });

// Sec01.component("hello", {
//   props: ["word"],
//   template: `<p>{{ word }}</p>`
// });

// Sec01.mount(".sec__01");
// <hello :word=message /> => <p>Hello</hello>
