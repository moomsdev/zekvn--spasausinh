=== ZekWeb ===
Contributors: the WordPress team
Requires at least: WordPress 4.1
Tested up to: WordPress 5.0-trunk
Version: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: blog, two-columns, left-sidebar, accessibility-ready, custom-background, custom-colors, custom-header, custom-logo, custom-menu, editor-style, featured-images, microformats, post-formats, rtl-language-support, sticky-post, threaded-comments, translation-ready

== Description ==
Our 2015 default theme is clean, blog-focused, and designed for clarity. Twenty Fifteen's simple, straightforward typography is readable on a wide variety of screen sizes, and suitable for multiple languages. We designed it using a mobile-first approach, meaning your content takes center-stage, regardless of whether your visitors arrive by smartphone, tablet, laptop, or desktop computer.

* Mobile-first, Responsive Layout
* Custom Colors
* Custom Header
* Social Links
* Menu Description
* Post Formats
* The GPL v2.0 or later license. :) Use it to make something cool.

For more information about Twenty Fifteen please go to https://codex.wordpress.org/Twenty_Fifteen.

==============================
HƯỚNG DẪN SỬ DỤNG THEME ZEKWEB
==============================

1. YÊU CẦU HỆ THỐNG
-------------------
- Node.js >= 16.x
- npm >= 8.x
- Đã cài đặt Wordpress và theme này vào đúng thư mục

2. CÀI ĐẶT CÁC PACKAGE CẦN THIẾT
---------------------------------
Mở terminal tại thư mục theme (thư mục chứa file package.json) và chạy:

    npm install

Lệnh này sẽ cài đặt các package cần thiết như vite, sass,...

3. CẤU TRÚC THƯ MỤC ASSET
-------------------------
assets/
├── js/         (Chứa các file JavaScript)
├── layout/     (Chứa các file SCSS/SASS cho layout)
├── img/        (Chứa hình ảnh tĩnh)
├── ...         (Các thư mục khác tuỳ chỉnh theo dự án)

4. CẤU HÌNH VITE
----------------
- File cấu hình Vite thường là vite.config.js (bạn cần tạo nếu chưa có)
- Ví dụ cấu hình đơn giản:

    import { defineConfig } from 'vite';
    import path from 'path';
    export default defineConfig({
      root: '.',
      base: './',
      build: {
        outDir: 'dist', // Thư mục xuất ra sau khi build
        emptyOutDir: true,
        rollupOptions: {
          input: {
            main: path.resolve(__dirname, 'assets/js/main.js'),
            style: path.resolve(__dirname, 'assets/layout/main.scss'),
          },
        },
      },
      css: {
        preprocessorOptions: {
          scss: {
            additionalData: ''
          },
        },
      },
    });

- Có thể tuỳ chỉnh lại đường dẫn tuỳ theo cấu trúc dự án của bạn.

5. BUILD VÀ PHÁT TRIỂN
----------------------
- Build production (tạo thư mục dist):

    npm run build

- Phát triển (xem thay đổi realtime):

    npm run dev

- Sau khi build, các file JS/CSS sẽ được xuất ra thư mục dist hoặc public (tuỳ cấu hình), bạn cần đảm bảo WordPress load đúng các file này.

6. LƯU Ý
--------
- Khi thay đổi code SCSS/JS, nên chạy lại lệnh build để cập nhật file mới.
- Có thể cần chỉnh lại enqueue script trong functions.php để load đúng file đã build.
- Nếu gặp lỗi liên quan đến quyền hoặc thiếu package, hãy kiểm tra lại Node.js và npm đã cài đặt đúng chưa.

Mọi thắc mắc hoặc cần hỗ trợ thêm, vui lòng liên hệ admin hoặc người phát triển theme.

== Copyright ==

Twenty Fifteen WordPress Theme, Copyright 2014-2018 WordPress.org & Automattic.com
Twenty Fifteen is distributed under the terms of the GNU GPL

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

Twenty Fifteen Theme bundles the following third-party resources:

HTML5 Shiv v3.7.0, Copyright 2014 Alexander Farkas
Licenses: MIT/GPL2
Source: https://github.com/aFarkas/html5shiv

Genericons icon font, Copyright 2013-2017 Automattic.com
License: GNU GPL, Version 2 (or later)
Source: http://www.genericons.com

== Changelog ==

= 2.0 =
* Released: May 17, 2018

https://codex.wordpress.org/Twenty_Fifteen_Theme_Changelog#Version_2.0

= 1.9 =
* Released: November 14, 2017

https://codex.wordpress.org/Twenty_Fifteen_Theme_Changelog#Version_1.9

= 1.8 =
* Released: June 8, 2017

https://codex.wordpress.org/Twenty_Fifteen_Theme_Changelog#Version_1.8

= 1.7 =
* Released: December 6, 2016

https://codex.wordpress.org/Twenty_Fifteen_Theme_Changelog#Version_1.7

= 1.6 =
* Released: August 15, 2016

https://codex.wordpress.org/Twenty_Fifteen_Theme_Changelog#Version_1.6

= 1.5 =
* Released: April 12, 2016

https://codex.wordpress.org/Twenty_Fifteen_Theme_Changelog#Version_1.5

= 1.4 =
* Released: December 8, 2015

https://codex.wordpress.org/Twenty_Fifteen_Theme_Changelog#Version_1.4

= 1.3 =
* Released: August 18, 2015

https://codex.wordpress.org/Twenty_Fifteen_Theme_Changelog#Version_1.3

= 1.2 =
* Released: May 6, 2015

https://codex.wordpress.org/Twenty_Fifteen_Theme_Changelog#Version_1.2

= 1.1 =
* Released: April 23, 2015

https://codex.wordpress.org/Twenty_Fifteen_Theme_Changelog#Version_1.1

= 1.0 =
* Released: December 18, 2014

Initial release
