## Code Stocks テーマについて

codepen を表示する事に特化した wordpress テーマです。

<p align="center"><img align="center" style="width:320px" src="https://files.kote2.co/tmp/cs/ss.png"/></p>

## 使い方

wordpress のテーマファイルとしてお使いください。wordpress のインストールについては公式サイトをご参考ください
https://ja.wordpress.org/

## 最低限必要なプラグイン

ACF to REST API
　 → カスタムフィールド内容を restAPI に入れる

Advanced Custom Fields
　 → カスタムフィールド管理

Intuitive Custom Post Order
　 → カテゴリや投稿を並べ替えられるようにする



## 初回インポートファイル

import-latest.xml
をお使いください。

## カスタマイズ等

### ユーザー情報表示箇所

・サイト名
・ユーザー説明
・ユーザーアバター
を使用しています。

### サイドバー

デフォルト左サイドバーです。**右サイドバーにしたい場合**はお手数ですがコード w 少しいじってください。

header.php
get_sidebar();をコメントアウト

footer.php
get_sidebar();をアンコメント

sidebar.php
↓ ソース内の以下コメントを参考にスタイルを調整してください

```
サブメニュー 左サイドバーの場合はout_rにorder-2を入れる。右サイドバーの場合は削除
メインサイドバー 左サイドバーの場合はout_rにorder-1を入れる。右サイドバーの場合は削除
```

## 管理画面にログインしていないと表示されないカテゴリ

プライベート用の codepen や web サイトを登録したいときはこちらをお使いください。

buils/js/scripts.js

```
管理画面にログインしていない場合に表示しないカテゴリid
const  excludeCategory = isProd ? '4+9+43+52' : '26+29+28+13'; // 左:本番、右:開発
```

こちらのカテゴリ ID を変更してください。

## プチテクニック

note タグ(スラッグも note)を使って codepen を指定すると js 表示になります。
js 欄をノート代わりに記述したい場合に便利です。

last update 210914
