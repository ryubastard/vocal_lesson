# 予約管理を行うシステムです

　WEB上で、レッスンなどの予約管理を行うシステムを個人開発しました。

　レスポンシブ対応となっていますので、スマホやタブレットからもご確認いただけます。

## 本システムの特徴
- **本システム開発の顧客モデル**
 
    - 本システムは、レッスンなどの予約管理をWEB上でしたい個人事業主の方を顧客モデルをペルソナとして定義しました。
    
- **工夫した点**
    <details><summary>１.管理人・講師・生徒の3者間を想定したシステムで設計しました。</summary>
    　開発にあたり、管理人・講師・生徒の3者間を想定したシステムを構築しました。</br>
    </details>
    
    <details><summary>２.講師ごとにレッスンの予約ができるように設計しました。</summary>
    　講師一覧のページを用意して、講師ごとにカレンダーからレッスンの予約が出来るようにしました。</br>
    　・講師ごとのinformationページは、講師ごとに設定できるようにプログラミングを行っています。
    </details>
    
    <details><summary>３.レッスンの定員数を超えた場合は、カレンダーからレッスンを非表示にするようにしました。</summary>
    　レッスンには定員数を設定して、定員数を超えた場合はカレンダーから非表示にするようにプログラムを行いました。</br>
    　・キャンセルなどで定員数が戻った場合は、キャンセルがあった時点で再度表示にするようにしています。</br>
    </details>
    
    <details><summary>４.生徒側で当日キャンセルが出来ないようにしました。</summary>
    　マイページでキャンセルが出来るのは前日23時59分までとして、レッスン当日はキャンセルボタンを非表示にするようにしました。</br>
    　・当日キャンセルに備え、講師側のレッスン管理画面から生徒の予約がキャンセルできるようにしています。</br>
    </details>
    
    <details><summary>５.レッスン管理画面では、レッスン日・レッスン場所ごとに管理できるようにしました。</summary>
    　概要画面では時間帯ごとの予約状況を確認でき、詳細画面では予約者の確認・キャンセルやレッスン自体の開催キャンセルができるようにしました。</br>
    　・レッスンに予約者がいる場合は、レッスン自体の開催キャンセルが出来ないように設計しています。</br>
    </details>
   
    <details><summary>６.当日以降のレッスンが予約されている場合、アカウントの削除が出来ないようにしました。</summary>
    　当日以降のレッスンが予約されている場合は、管理画面でアカウント削除のボタンは出さずに、マイページのボタンを表示するようにしました。</br>
    　・講師の場合は、当日以降のレッスンがある場合にも、アカウント削除のボタンは出さずに、レッスン管理のボタンを表示するようにしています。</br>
    </details>

## 機能一覧
- **ログイン前画面**
    - 講師一覧
    - information
    - レッスンカレンダー
         - レッスン詳細</br>
         ・会員の場合、ログイン後に予約可能なように、ログインボタンを配置</br>
         ・非会員の場合、レッスン予約と会員登録を一括して行うことができるように、導線を配置</br>
         - 新規会員登録＆レッスン予約画面
         
- **生徒画面側**
    - ログイン
    - 講師一覧
    - information
    - レッスンカレンダー
         - レッスン詳細（予約するボタンを配置）
    - マイページ
         - 最新のレッスン一覧
         - 過去のレッスン一覧</br>
         ・レッスン名をクリックすることで、レッスン詳細へ遷移</br>
         ・キャンセルは前日23時59分まで可能とし、ボタンを配置</br>
    - アカウント情報
         - アカウント情報（名前、フリガナ、メールアドレスの変更）
         - パスワード変更
         - ブラウザセッション
         - アカウント削除（当日以降のレッスンが予約されている場合は削除不可）

- **講師画面側**
    - ログイン
    - 講師一覧
    - information
    - レッスンカレンダー
         - レッスン詳細（予約するボタンを配置）
    - マイページ
         - 最新のレッスン一覧
         - 過去のレッスン一覧</br>
         ・レッスン名をクリックすることで、レッスン詳細へ遷移</br>
         ・キャンセルは前日23時59分まで可能とし、ボタンを配置</br>
    - レッスン管理
         - 最新のレッスン一覧
         - 過去のレッスン一覧
         - 新規登録
    - information管理（画像の設定、表示・非表示の切り替え・説明文の編集）
    - アカウント情報
         - アカウント情報（名前、フリガナ、メールアドレスの変更）
         - パスワード変更
         - ブラウザセッション
         - アカウント削除（当日以降のレッスンが開催・予約されている場合は削除不可）

- **管理人画面側**
    - ログイン
    - 講師一覧
    - information
    - レッスンカレンダー
         - レッスン詳細（予約するボタンを配置）
    - マイページ
         - 最新のレッスン一覧
         - 過去のレッスン一覧</br>
         ・レッスン名をクリックすることで、レッスン詳細へ遷移</br>
         ・キャンセルは前日23時59分まで可能とし、ボタンを配置</br>
    - 管理画面
         - 講師一覧（新規登録・パスワード変更）
         - 生徒一覧（パスワード変更・講師資格付与）
    - アカウント情報
         - アカウント情報（名前、フリガナ、メールアドレスの変更）
         - パスワード変更
         - ブラウザセッション
         - アカウント削除（当日以降のレッスンが開催・予約されている場合は削除不可）
 
## 参考にした教材
<a href="https://www.udemy.com/course/laravel-livewire-event-calendar/">【Laravel】イベント予約システムをつくってみよう【Jetstream x Livewire】【TALLスタック】</a></br>

## インストール後の実施事項
informationへ画像をアップロードされる場合は、「php artisan storage:link」と実行してください。

## 実装環境

　バックエンド　： PHP(8.1.6) , Laravel9  , MySQL

　フロントエンド： HTML・CSS, JavaScript, Bootstrap5, Tailwind CSS v3.0
