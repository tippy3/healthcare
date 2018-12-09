# [血圧メモ](https://web.sfc.keio.ac.jp/~s15499dt/2016/healthcare/index.html)

公開中 → https://web.sfc.keio.ac.jp/~s15499dt/2016/healthcare/index.html

毎日の血圧メモ。RDBとGoogle Chart APIの練習として作成。

製作時大学１年生。今コードを見ると「ちゃんと理解せず書いてたなー」と微笑ましく思えます。

次同じものを作るならSinatraでサクッと作ります。

# PRポイント（レポートより引用）

## Google Chart APIによるSVGでのグラフ描画
 - 多次元配列から自動的にグラフを作成するGoogle Chart APIをマッシュアップ
## マルチデバイス対応
 - データベースに情報を保存しているので、どの端末からでも同じ表示ができます
 - JavaScriptからAjaxでPHPにPOSTでアクセス、PHPがデータベースに読み書きします
## データの簡易パスワード保護
 - レコードの登録・削除にはパスワードが必要です
## Bootstrapによるレスポンシブデザイン
## とにかく細かいところに気をつけました
 - 送信前のJavaScriptでの入力値チェック
 - API読み込み中の「読込中…」の表示
 - 登録後はフォームを初期化
 - フォームのplaceholderの設定
 - リロードボタンの設置
 - 通信エラー発生時のフォロー　　ほか
