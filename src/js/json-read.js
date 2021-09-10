// ==================================================
// jsonRead
// ==================================================

// const jsonRead = {
//   data() {
//     return {
//       jsonURL: 'http://localhost:10058/test/json/',
//       // jsonURL: 'https://taxi-job.net/wp-json/wp/v2/categories',
//       jsonData: [],
//     };
//   },
//   mounted() {
//     this.init();
//   },
//   methods: {
//     async init() {
//       try {
//         const res = await fetch(new URL(this.jsonURL));
//         const data = await res.json();
//         this.jsonData = data;
//       } catch (e) {
//         const { status, statusText } = error.response;
//         console.log(`Error! HTTP Status: ${status} ${statusText}`);
//       }
//     },
//   },
// };
// Vue.createApp(jsonRead).mount('.js_json-read');

const jsonRead = Vue.createApp({
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
