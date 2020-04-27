# saml_sp1
CentOS Linux release 7.7.1908 (Core)

Apache/2.4.6

PHP 7.1.33

MySQL Ver 8.42 Distrib 5.7.29

SimpleSAMLphp 1.15.0

## What to Submit / What to Receive (via HTTP_POST)
### (submit-1) for registering the migration service (to ap/sample/index.php)
|  input type  |  name  |  value  |
| ---- | ---- | ---- |
|  hidden  |  mig_id  |  migration ID  |
|  hidden  |  sp  |  your sp name  |
|  hidden  |  ret_url  |  return URL  |

*notice*
- Migration ID must be linked to the user in your database.
- Your sp name is used to identify the sp in the AP.
- After registering at the AP, the user will be redirected to "ret_url".

```example1; start.php
<input type="hidden" name="mig_id" value="<?php echo $mig_id; ?>">
<input type="hidden" name="sp" value="sp1">
<input type="hidden" name="ret_url" value="https://sp1.local/sample/start.php">
```

### (submit-2) for migration, moving out from migration-source IdP (to ap/sample/migr.php)

|  input type  |  name  |  value  |
| ---- | ---- | ---- |
|  hidden  |  sp  |  your sp name  |
|  hidden  |  ret_url  |  return URL  |
|  hidden  |  ret_url2  | return URL  |

*notice*
- "sp" is the same as (submit-1)
- An user will be redirected to "ret_url" when he want to log-in with new IdP after a while, or has not registered for the service. (Then the URL like start page is recommended)
- An user will be redirected to "ret_url2" when he has already completed the migration at another SP. (Then the URL to receive the migration ID is recommended)

```example2; start.php
<input type="hidden" name="sp" value="sp1">
<input type="hidden" name="ret_url" value="https://sp1.local/sample/start.php">
<input type="hidden" name="ret_url2" value="https://sp1.local/sample/complete.php">
```
### (receive-1) for migration, moving in from migration-destination IdP (from ap/sample/migr.php/movin2.php)

|  input type  |  name  |  value  |
| ---- | ---- | ---- |
|  hidden  |  mig_id_sp  |  the user's migration ID  |

*notice*
- This migration ID is that you submitted at (submit-1).
- You can complete the user's migration by using this migration ID.
- The user logging in now (with user ID of the destination IdP) can be connected to the user linked to this migration ID.

## <Tips>
### mysql環境構築

1. php-mysql, mysql-community-server, phpMyAdminをyumでインストール
    - phpMyAdminはenablerepo=epelでインストールするとよい，epelは先にyumでインストール(yum install epel-release)

2. mysqld 起動

3. rootログイン，パスワード文字数・難易度変更，パスワード変更

4. phpMyAdmin設定 /etc/httpd/conf.d/phpMyAdmin.conf

5. データベース：simplesamlを作成(旧VM参照)
    - テーブル：users
    - 列：uid, idp1_uid, idp2_uid,password, uid_num, mig_id