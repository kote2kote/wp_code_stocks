<section class="Hero">
<div class="inner relative w-screen h-screen">
      <!-- area-smNav -->
      <div
        class="area-smNav-outer bg-white hidden maxpc:block fixed top-0 w-full z-10"
      >
        <div class="area-smNav flex justify-between ">
          <img
            class="el-logo"
            src="https://via.placeholder.com/80x40/27709b/ffffff?text=80x40"
            alt="テスト"
          />
          <div
            @click="isOpen = !isOpen"
            class="w-12 h-12 flex justify-center items-center cursor-pointer"
          >
            <span v-if="isOpen">▲</span>
            <span v-else>▼</span>
          </div>
        </div>
        <nav
          class="area-openNav bg-white w-full c-transition overflow-hidden"
          :class="[isOpen ? 'i-h-on' : 'i-h-off ']"
        >
          <ul class="ul-first">
            <li>
              <div class="outer">
                <a href="#" class="inline-block cm flex items-center">
                  <img
                    class="inline-block"
                    src="https://via.placeholder.com/120x30/27709b/ffffff?text=120x30"
                    alt="テスト"
                  />
                  <span class="text-sm inline-block pl-2">ああああaaaa</span></a
                >

                <div
                  @click="isSubOpen = !isSubOpen"
                  class="w-12 h-12 flex justify-center items-center cursor-pointer cm"
                >
                  <span v-if="isSubOpen">▲</span>
                  <span v-else>▼</span>
                </div>
              </div>
              <!-- <ul class="ul-second bg-white w-full c-transition overflow-hidden"
              :class="[isSubOpen ? 'h-full' : 'i-h-0']">
                <li>aaa</li>
                <li>bbb</li>
              </ul> -->
            </li>
          </ul>
        </nav>
      </div>

      <!-- area-bg -->
      <div class="area-bg absolute w-full h-full">
        <img
          class="w-full h-full object-cover"
          src="https://via.placeholder.com/1920x1024/27709b/ffffff?text=1920x1080"
          alt="テスト"
        />
      </div>

      <!-- area-arrow-left ---------------------------->
      <div class="area-arrow-left absolute inline-block pl-12 left-0">
        <img
          class=""
          src="https://via.placeholder.com/60x60/ffffff/27709b?text=60x60"
          alt="テスト"
        />
      </div>

      <!-- area-arrow-right ---------------------------->
      <div class="area-arrow-right absolute  inline-block pr-12 right-0">
        <img
          class=""
          src="https://via.placeholder.com/60x60/ffffff/27709b?text=60x60"
          alt="テスト"
        />
      </div>

      <!-- area-activeSlider-btnCircle ---------------------------->
      <div class="area-activeSlider-btnCircle absolute inline-block">
        <ul class="flex">
          <li>
            <img
              class=""
              src="https://via.placeholder.com/20x20/ffffff/27709b?text=20x20"
              alt="テスト"
            />
          </li>
          <li>
            <img
              class=""
              src="https://via.placeholder.com/20x20/ffffff/27709b?text=20x20"
              alt="テスト"
            />
          </li>
          <li>
            <img
              class=""
              src="https://via.placeholder.com/20x20/ffffff/27709b?text=20x20"
              alt="テスト"
            />
          </li>
          <li>
            <img
              class=""
              src="https://via.placeholder.com/20x20/ffffff/27709b?text=20x20"
              alt="テスト"
            />
          </li>
        </ul>
      </div>

      <div
        class="area-nav is-pc absolute w-full bg-gray-500 py-20 maxmd:hidden"
      ></div>
      <div
        class="area-scroll is-pc absolute w-full text-center bottom-0 pb-2 maxmd:hidden"
      >
        <img
          class="inline-block"
          src="https://via.placeholder.com/60x40/ffffff/27709b?text=60x40"
          alt="テスト"
        />
      </div>
    </div>
</section>