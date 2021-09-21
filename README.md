## Code Stocks テーマについて

### 管理画面ログインで使用するテーマです

Code Stocks テーマは、プライベートでの使用を目的とし、自分専用のノートに利用できます。また Code Stocks という名前の通り、プログラミングのコードを集めるような作りに特化しているのも特徴です。
具体的には、Codepen や CodeSandbox などを iframe 表示する事により、同じ画面内でソースコードを参照できます。詳しくは<a href="https://sample-cs.kote2.co/" target="_blank">サンプルサイト</a>をご覧ください。

<p align="center"><img align="center" style="width:320px" src="https://files.kote2.co/tmp/cs/ss.png"/></p>

<a href="https://sample-cs.kote2.co/" target="_blank">sample page</a>.

## 使い方

wordpress のテーマファイルとしてお使いください。wordpress のインストールについては公式サイトをご参考ください
https://ja.wordpress.org/

## 最低限必要なプラグイン

ACF to REST API → カスタムフィールド内容を restAPI に入れる
Advanced Custom Fields → カスタムフィールド管理
Intuitive Custom Post Order → カテゴリや投稿を並べ替えられるようにする





## 初回インポートファイル

import-latest.xml
をお使いください。

## カスタマイズ等

当テーマは gulp を使用し scss コンパイルや tailwindcss など様々なビルド作業を行う事により作成されています。もし gulp の使用経験がある場合は、npm install から初めて頂いて問題ありません。**どんどんカスタマイズしちゃってください。**

### ユーザー情報表示箇所

・サイト名
・ユーザー説明
・ユーザーアバター
を使用しています。

### サイドバー左右入れ替え

検索窓の下にあるアイコンで左右入れ替えができます。デフォルト左サイドバーです。デフォルト値を変更したければカスタマイズしてください。

buils/js/scripts.js

```
isSidebarLeft:  true // falseに変更
```

last update 210921
update 210914
