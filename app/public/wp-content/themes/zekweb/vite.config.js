import { resolve } from 'path';

export default {
  root: './assets',
  build: {
    outDir: '../dist',
    emptyOutDir: true,
    minify: false,
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
        additionalData: '',
      },
    },
  },
};
