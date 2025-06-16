import { resolve } from 'path';

export default {
  root: './assets',
  build: {
    outDir: '../dist',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        style: resolve(__dirname, 'assets/style.scss'),
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
};
