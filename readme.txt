■環境構築について


・xammpをインストール

・xammpの設定ファイルでポートを変える
XAMPP Apache/MySQL/Tomcatのポート番号を変更
https://itsakura.com/xampp-port
※やっとかないとたいていポートエラーが出る
初期ポートは８０なのでぶつかること多し


・virtualHostの設定
https://cbc-study.com/training/advanced/page1#s1
①複数プロジェクトを扱えるようにhttpd.confの設定を変更します。
conf\apache\httpd.conf
227行目辺り
<Directory />
    Options Indexes FollowSymLinks
    AllowOverride All
</Directory>

615行目辺り
# MACの場合
# Virtual hosts
Include /Applications/MAMP/conf/apache/extra/httpd-vhosts.conf

Windowsの場合
# Virtual hosts
Include /conf/extra/httpd-vhosts.conf

②httpd-vhosts.confの編集
Listen 8001
<virtualhost *:8001>
  DocumentRoot "C:\Users\ユーザー名\stg\8001-つけた名前"
</virtualhost>

Listen 8002
<virtualhost *:8002>
  DocumentRoot "C:\Users\ユーザー名\stg\8002-つけた名前"
</virtualhost>
・
・
・増やしていく


・apacheとMySQLが動くかチェック
　_apacheでポートエラーが出たとき
　https://blog.masuyoshi.com/xampp_apache_blocked_port/
　_「cd コマンド」を使って、xamppフォルダに移動。
  _「apache_start.bat」ファイルを指定して、エンター。
  　⇒エラーが発生していればメッセージが出る

・MySQLでエラーが出た場合
xamppでmysqlが動いてくれない…　そんなときはPortをチェック
https://qiita.com/kyorochan0219/items/01fafab61fc66aef86f8

⇒MySQLを単独でインストールしている場合はアンインストールしておく
　使用ポートがぶつかってエラーになった

