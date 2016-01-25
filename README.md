# PosTom
　PosTomは、展示会向けwebアプリ作成支援ツールです。
ポスター発表を含む学会を対象とし、ポスター配置をwebブラウザ上で配置することができます。


## 概要
　展示会などを含む学会のためのスマートフォン向けWebアプリ「PosMApp」はDEIM2015をはじめとする様々な学会で利用されたきました。
　実際の利用を経て、多くの方々から「他の学会で利用したい」との要望があったが、現在のPosMAppを他の学会で利用しようとする際には、コード変更などの専門的な作業が必須でした。
　そこで、我々はPosMAppを各イベントごとに簡単に作成できるようなWebアプリ「PosTom」を開発しました。
　PosTomを利用することにより、ポスターセッション・タイムテーブル・プレゼンテーション一覧のコンテンツを簡単に作成することができ、CSVファイルの一括登録やドラッグアンドドロップによる直感的な操作により、学会向けWebアプリ作成の労力を大幅に削減が可能となりました。
　

## システム要件
PosTomはCakePHP 2.xを使用して開発されております。
そのためシステム要件には[CakePHP 2.x のシステム要件](http://book.cakephp.org/2.0/ja/installation.html#id2)に準拠することが求められます

* HTTP サーバー (Apache推奨)
* PHP 5.3.0 以上
* MySQL 4 以上


## 動作環境
以下のブラウザ・バージョンで動作できることを確認しております。

* Google Chrome 40 以上
* Firefox 40 以上
* Safari 9 以上


## サービスの設置方法
ここでは、githubリポジトリの取得からサービス開始までの手順を説明します。

### Step.1 GitHubからソースを取得
```
wget --no-check-certificate https://github.com/tsss-a/PosTom/archive/master.zip
```

### Step.2 ファイルを解凍
```
unzip master.zip
```

### Step.3 プロジェクトフォルダの権限を設定
```
chmod -R 755 プロジェクト名
```

### Step.4 .gitignoreされているtmpフォルダを生成
```
cd プロジェクト名/app/
mkdir tmp
```

### Step.5 .gitignoreされているtmpフォルダの権限を設定
```
chmod -R 755 tmp
```

### Step.6 .gitignoreされているtmpファルダ内のemptyファイルを個別生成
```
cd tmp && mkdir cache && mkdir logs && mkdir sessions && mkdir tests && cd cache && mkdir models && mkdir persistent && mkdir views && touch models/empty && touch persistent/empty && touch views/empty && cd ../ && touch logs/empty && touch sessions/empty && touch tests/empty
```

### Step.7 databaseファイルの複製
```
cd ../Config/
cp database.php.default database.php
```

### Step.8 databaseファイルの編集
```
class DATABASE_CONFIG {
	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => '[データベースホスト名]',
		'login' => '[ユーザー名]',
		'password' => '[パスワード]',
		'database' => '[データベース名]',
		'prefix' => '',
		'encoding' => 'utf8',
	);
	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => '[データベースホスト名]',
		'login' => '[ユーザー名]',
		'password' => '[パスワード]',
		'database' => '[データベース名]',
		'prefix' => '',
		'encoding' => 'utf8',
	);
}
```

以上で、ファイルやフォルダ構成の準備が整いました。

これ以降で、データベースの設定をおこないます。

## データベース準備
ここでは、データベースにサービスで必要なテーブルの追加をおこないます。

まずは、SSHでサービスを設置したサーバに接続し、MySQLを起動し、使用するデータベースを選択したところから以下を初めてください。

### リポジトリに含まれているinit.sqlファイルを実行
SQLファイルまでのパスは各自で入力してください。

```
mysql > SOURCE /xxxxxxxxxxxx/init.sql
```

### テーブルが挿入されたことを確認
```
mysql > show tables;
```

以下のように表示されればデータベースの準備が完了です。

```
+------------------------------+
| name_of_database             |
+------------------------------+
| areas                        |
| authors                      |
| commentators                 |
| disuses                      |
| editors                      |
| events                       |
| posters                      |
| presentations                |
| rooms                        |
| schedules                    |
| test                         |
| users                        |
+------------------------------+
12 rows in set (0.00 sec)
```

## 使用マニュアル
ここでは一通り、学会用スマートフォン向けWebアプリ「PosMApp」を生成するための手順を説明します。

作成中。


### 問い合わせ
以上、マニュアルとなります。その他、問い合わせ等ありましたら開発者までお問合せください。


## 開発チーム
筑波大学 大学院 システム情報工学研究科 コンピュータサイエンス専攻  
高度IT人材育成のための実践的ソフトウェア開発専修プログラム（高度ITコース）

University of Tsukuba  
Graduate School of Systems and Information Engineering  
Department of Computer Science  
Practical Software Development Specialization Program  
for Advanced IT Personnel Training (AIT, SIT)

[小串 光和(Mitsukazu Ogushi)](https://github.com/tsss-g)  
[小幡 潤(Jun Obata)](https://github.com/tsss-j)  
[小寺 暁久(Akihisa Kodera)](https://github.com/tsss-a)  
[杜 天行(Du Tianhang)](https://github.com/tsss-t)


=======

<p style="text-align: center">Copyright &copy; [筑波大学CS専攻 高度ITコース](http://www.cs.tsukuba.ac.jp/ITsoft/)</p>  
<p style="text-align: center">Team TSSS</p>

