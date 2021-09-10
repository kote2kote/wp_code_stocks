<section class="AboutScene">
<div class="inner overflow-hidden relative">
      <!-- area-bg ---------------------------->
      <div class="area-bg rellax" data-rellax-speed="10"></div>

      <!-- area-tabs ---------------------------->
      <div
        class="area-tabs absolute top-0 w-full h-full p-12 flex justify-center"
      >
        <div class="inner w-full h-full bg-gray-200 flex flex-col">
          <div class="area-tabs-tab">
            <ul class="flex h-full">
              <li
                :class="{ 'is-active': flagAboutTab }"
                class="el-tabs-about w-6/12 cursor-pointer relative h-full"
                @click="changeTabs(true)"
              >
                <img
                  class="el-btn-on inline-block absolute"
                  src="https://via.placeholder.com/540x80/000000/ffffff?text=AboutOn"
                  alt=""
                />
                <img
                  class="el-btn-off inline-block absolute"
                  src="https://via.placeholder.com/540x80/dddddd/000000?text=AboutOff"
                  alt=""
                />
              </li>
              <li
                :class="{ 'is-active': flagSceneTab }"
                class="el-tabs-scene w-6/12 cursor-pointer relative h-full"
                @click="changeTabs(false)"
              >
                <img
                  class="el-btn-on inline-block absolute"
                  src="https://via.placeholder.com/540x80/000000/ffffff?text=SceneOn"
                  alt=""
                />
                <img
                  class="el-btn-off inline-block absolute"
                  src="https://via.placeholder.com/540x80/dddddd/000000?text=SceneOff"
                  alt=""
                />
              </li>
            </ul>
          </div>
          <!-- area-tabs-content -->
          <div class="area-tabs-content h-full">
            <div class="inner h-full relative">
              <div
                :class="{ 'is-active': flagAboutTabContent }"
                class="area-tabs-main-about absolute bg-gray-400 flex justify-center items-center w-full h-full"
              >
                About
              </div>
              <div
                :class="{ 'is-active': flagSceneTabContent }"
                class="area-tabs-main-scene absolute bg-gray-300  flex justify-center items-center w-full h-full"
              >
                Scene
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.area-tabs-->
    </div>
    <!-- /.inner -->
</section>