    <p>{{ $user }}様</p>
    <p>この度は、レッスンの予約が完了しました。</p>
    <p>以下の詳細情報をご確認ください。</p>
    <table>
        <tr>
            <td>レッスン名:</td>
            <td>{{ $lesson->name }}</td>
        </tr>
        <tr>
            <td>レッスン料金:</td>
            <td>{{ $lesson->price }}</td>
        </tr>
        <tr>
            <td>レッスン場所:</td>
            <td>{{ $lesson->location }}</td>
        </tr>
        <tr>
            <td>開始時間:</td>
            <td>{{ $lesson->start_date }}</td>
        </tr>
        <tr>
            <td>終了時間:</td>
            <td>{{ $lesson->end_date }}</td>
        </tr>
    </table>