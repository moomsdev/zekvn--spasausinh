import { resolve } from 'path';

export default {
  root: './assets',
  base: '/wp-content/themes/zekweb/dist/',
  build: {
    outDir: '../dist',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        style: resolve(__dirname, 'assets/style.scss'),
        main: resolve(__dirname, 'assets/main.js'),
      },
      output: {
        assetFileNames: '[name][extname]',
      },
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: '', // chỗ này để import biến/mixin dùng toàn cục nếu có
      },
    },
  },
  server: {
    watch: {
      usePolling: true,
    },
    strictPort: true,
    hmr: true,
  },
  resolve: {
    alias: {
      '@': resolve(__dirname, 'assets'),
    },
  },
};
