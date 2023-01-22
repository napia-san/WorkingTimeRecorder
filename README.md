# Working Time Recorder
Google Calendar APIを使って作業時間の記録を行うWebアプリ

# 使用APIおよびライブラリ
□API
>・Google Calendar API<br>

□ライブラリ
>・Google APIs Client Library for PHP<br>
>・Carbon<br>

# テーブル設計
## user-dataテーブル
|    Column   |  Type  |
| ----------- | ------ |
|   user_id   | string | 
|    name     | string |
| calendar_id | string |

## time_cardテーブル
|   Column   |   Type   |
| ---------- | -------- |
|  user_id   |  string  | 
| start_time | datetime |
|  event_id  |  string  |

# 内容物とその概要
□index.php
>メイン画面．<br>
>form入力を受け付けて，下記処理を実施する．
>>・作業開始時間登録<br>
>>formに入力されたユーザーIDと紐付けされたカレンダーへ作業開始時刻を登録する．尚，ユーザーIDとカレンダーIDはDBの`user_dataテーブル`に格納されている．<br>
>>次に，作業開始時刻登録時に取得したイベントIDをDBの`time_cardテーブル`へユーザーID，作業開始時刻と共に保存する．尚，イベントIDは作業終了時に，作業終了時刻をカレンダー上に反映させるために使用する．<br>
また，`time_cardテーブル`上に記録のあるIDは`作業中`であると判定させ，今後のバリデーション機能実装に利用する予定である．<br>
>>情報の反映が終わり次第，反映結果を表示する．

>>・作業終了時間登録<br>
>>formに入力されたユーザーIDと紐付けされたカレンダーに作業終了時刻を反映させる．尚，反映に必要なイベントIDはDBの`time_cardテーブル`に格納されている．<br>
>>次にアカウントの状態を`作業終了`とするため，`time_cardテーブル`上の該当レコードを削除する．<br>
>>情報の反映が終わり次第，総作業時間等を表示する．

□registration.php
>利用登録画面．<br>
>form入力を受け付けて，下記処理を実施する．
>>・利用登録<br>
>>formに入力された各値を`user_dataテーブル`に格納する．
---
## [folder]app
各種処理をまとめている．<br>
□calendar_process.php
>Google Calendar API関連の関数をまとめている．<br>
>・getClient()
>>API接続処理を行う．<br>

>・insert_event($cal_id)
>>作業開始時にカレンダーへ作業開始時刻を記録する．<br>
>>引数として`カレンダーID`，返り値として`イベントID`を設定している．<br>

>・edit_event($cal_id, $event_id)
>>作業終了時にカレンダーへ作業終了時刻を反映する．<br>

□db_connector.php
>DBへの接続処理を行う．接続関連情報は環境変数から取得する．<br>

□db_init.php
>テーブル作成処理．<br>

□db_process.php
>DBの各種操作をまとめている．<br>
>・get_user_info($user_id)
>>ユーザー名とカレンダーIDをユーザーIDで検索する．

>・put_user_status($user_id, $event_id)
>>作業開始時刻とイベントIDを記録する．

>・get_event_info($user_id)
>>作業開始時間とイベントIDをユーザーIDで検索する．

>・delete_event_info($user_id)
>>該当レコードを削除し，作業中フラグをクリアする．

>・user_registration($user_id, $user_name, $cal_id)
>>新規利用登録関連処理．
---
## [folder]css
スタイルシート各種．