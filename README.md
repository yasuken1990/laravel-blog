# Laravel Blog
 Create a blog with Laravel.

## 目的
Laravelの知識がないので、Blogを作ることで学び現在WordPressで実装しているブログと切り替える。  
実装する機能は、WordPressを模倣する。

## 最終目標
- WordPRessで運用しているBlogを、Laravelで自作したBlogで置き換える。
- ローカルではなく、VPSで運用して公開状態にする。
- Laravelで作りたいものが作れるようになること。
- WordPressの記事をインポートできるまでできたらいいかな…

## 必要な機能 (時間に限りはあるので、最低限のものを短期間で)
- ログイン
	- ソーシャルログイン(TwitterID, GitHubID等)
- ~~ログアウト~~
- 管理画面
	- ~~サイト管理(タイトル等、詳細はまだ決まっていません...)~~
	- ~~記事管理(リッチテキストエディタ使用)~~
	- 画像管理
	- タグ管理
	- ~~コメント管理~~
	- テンプレ管理(フロント画面のレイアウト調整)
	- インスタ連携
		- インスタで投稿した写真をハッシュタグごとにAPIで取得できたらいいなあ。
		- インスタの位置情報を地図を表示して…
			- ランチや観光地をまとめるのが楽になるかも
	- Twitter連携
		- TLをブログの横に表示(ウィジェット)
- フロント画面
	- ~~記事表示~~
		- ~~一覧~~
		- ~~詳細~~
		- ~~コメント(セキュリティ面を考えると...)~~
	- タグ表示
		- 記事リンク(タグが紐づいた記事)
	- カレンダー表示
		- 記事リンク(日付条件にあった記事)
	- 検索
		- 全文検索(タイトル、記事本文、タグ)
	- アーカイブ
		- 記事リンク(年月単位の条件にあった記事)

## どうやって実装するか
- 言語：PHP7
- フレームワーク：Laravel5.4
- OS：Develop macOS Sierra / Production CentOS7
- DB Server: mariaDB
- Web Server: Develop Laravel 組み込みサーバ / Production Nginx or Apache
- バージョン管理: Git Hosting, GitHub
- Production Server: どこかのVPSを予定, 決まり次第更新
- 設計: Caccoo, Xmind, Googl Drive Spread Sheet

## WordPressにある機能一覧
### 管理画面
- ログイン
- ログアウト
- パスワードリマインダ
- 記事管理
	- 記事一覧
	- 記事登録
	- 記事編集
	- 記事削除
		- リッチテキストエディタを使用
	- コメントステータス(公開・非公開)
	- コメント削除
	- ステータス(公開・非公開)
	- 投稿設定
- 固定ページ管理
	- 固定ページ一覧
	- 固定ページ編集
	- 固定ページ削除
		- リッチテキストエディタを使用
- 画像管理
	- 画像一覧
	- 画像アップロード
	- 画像削除
- テンプレート管理
	- テンプレート一覧
	- テンプレート編集
	- テンプレート削除
- ヘッダー
	- サイトタイトル設定
	- キャッチフレーズ設定
	- ロゴ設定
	- 固定フロントページ
	- 追加CSS
- 設定
	- サイトタイトル
	- キャッチフレーズ
	- メールアドレス
	- 日付フォーマット
	- 時刻フォーマット

### フロント画面
- TOPページ表示
- 固定ページ表示
- 記事タイトル表示
- 記事詳細表示
- 記事コメント投稿
- 記事検索
- カレンダー表示(投稿された記事とリンク)
- 最近の投稿
- アーカイブ(年月日毎)
