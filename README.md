# saml_sp1

- [x] MySQL環境構築
- [ ] URI等齟齬修正
- [ ] 送受信情報見直し(Cookie/HTTP_POST)

~~*MySQL環境構築前にphpバージョン更新(5.6)*~~
### mysql環境構築
1. php-mysql, mysql-community-server, phpMyAdminをyumでインストール
2. mysqld 起動
3. rootログイン，パスワード文字数・難易度変更，パスワード変更
4. phpMyAdmin設定 /etc/httpd/conf.d/phpMyAdmin.conf
5. データベース：simplesamlを作成(旧VM参照)
    - テーブル：users
    - 列：uid, idp1_uid, idp2_uid,password, uid_num, mig_id