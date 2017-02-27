<table border = 1>
    <tr>
        <td>番号</td>
        <td>カテゴリー</td>
        <td>名前</td>
        <td>アドレス</td>
        <td>詳細</td>
        <td>年齢</td>
        <td>画像</td>
    </tr>
    {section name = cell loop = $memberArray}
    <tr>
        <td>{$memberArray[cell].id}</td>
        <td>{$memberArray[cell].category_id}</td>
        <td>{$memberArray[cell].name}</td>
        <td>{$memberArray[cell].address}</td>
        <td>{$memberArray[cell].detail}</td>
        <td>{$memberArray[cell].age}</td>
        <td>{$memberArray[cell].image}</td>
    </tr>
    {/section}
</table>
<br>
<br>