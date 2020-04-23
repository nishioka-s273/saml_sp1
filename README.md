# saml_sp1
CentOS Linux release 7.7.1908 (Core)
Apache/2.4.6
PHP 7.1.33
MySQL Ver 8.42 Distrib 5.7.29
SimpleSAMLphp 1.15.0

<Tips>
### mysql環境構築
1. php-mysql, mysql-community-server, phpMyAdminをyumでインストール
    - phpMyAdminはenablerepo=epelでインストールするとよい，epelは先にyumでインストール(yum install epel-release)
2. mysqld 起動
3. rootログイン，パスワード文字数・難易度変更，パスワード変更
4. phpMyAdmin設定 /etc/httpd/conf.d/phpMyAdmin.conf
5. データベース：simplesamlを作成(旧VM参照)
    - テーブル：users
    - 列：uid, idp1_uid, idp2_uid,password, uid_num, mig_id