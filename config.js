module.exports = {
  config: {
    tailwindjs: './tailwind.config.js',
    port: 6816,
  },
  paths: {
    root: './',
    src: {
      base: './src',
      css: './src/scss',
      js: './src/js',
      img: './src/images',
      icons: './src/icons',
    },
    // cssの場所はWP用になってるので適宜変更
    dist: {
      base: './assets/dist',
      css: './',
      js: './assets/dist/js',
      img: './assets/dist/images',
      icons: './assets/dist/icons',
    },
    build: {
      base: './assets/build',
      css: './',
      js: './assets/build/js',
      img: './assets/build/images',
      icons: './assets/build/icons',
    },
  },
  icons: [
    [16, 16],
    [32, 32],
    [48, 48],
    [57, 57],
    [76, 76],
    [120, 120],
    [128, 128],
    [152, 152],
    [167, 167],
    [180, 180],
    [192, 192],
    [512, 512],
  ],
};
