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
