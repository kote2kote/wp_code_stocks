<?php
/*
	Template Name: page-json-read
*/
get_header('starter'); ?>
<div class="Starter">
  <div class="inner min-h-screen">
    <main>
      <div class="inner px-8">
        <h3 class="com_tail with-margin">PHPとrestAPIを使ったテスト</h3>
        <div class="">
          <h4 class="com_tail with-margin">PHP</h4>
          <div class="vue_test01">
            <p>http://localhost:10058/test/json/</p>
            <ul>
              <li v-for="n in jsonData" :key="n.id">
                {{ n.name }}
                <template v-if="n.children.length !== 0">
                  <ul class="ml-4">
                    <li v-for="nn in n.children" :key="nn.id">
                      {{ nn.name }}
                      <template v-if="nn.children.length !== 0">
                        <ul class="ml-4">
                          <li v-for="nnn in nn.children" :key="nnn.id">
                            {{ nnn.name }}
                          </li>
                        </ul>
                      </template>
                    </li>
                  </ul>
                </template>
              </li>
            </ul>
          </div>
          <h4 class="com_tail with-margin">restAPI</h4>
          <div class="vue_test02">
            <p>http://localhost:10058/wp-json/wp/v2/categories?_embed&per_page=100&exclude=1</p>
            <ul>
              <li v-for="n in jsonData" :key="n.id">
                {{ n.name }}
                <template v-if="n.children.length !== 0">
                  <ul class="ml-4">
                    <li v-for="nn in n.children" :key="nn.id">
                      {{ nn.name }}
                      <template v-if="nn.children.length !== 0">
                        <ul class="ml-4">
                          <li v-for="nnn in nn.children" :key="nnn.id">
                            {{ nnn.name }}
                          </li>
                        </ul>
                      </template>
                    </li>
                  </ul>
                </template>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- /.main_inner -->
    </main>
  </div>
</div>
<?php get_footer('starter'); ?>