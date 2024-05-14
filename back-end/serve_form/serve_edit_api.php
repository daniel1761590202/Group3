<?php
require '../parts/form_pdo-connect.php';
header('Content-Type: application/json');

# 回應給用戶端的欄位 (格式 JSON)
$output = [
  'success' => false,
  'postData' => $_POST, # 除錯用
  'error' => '',
  'code' => 0, # 除錯或追踪程式碼
];


// 判斷表單有無送過來
// 如過這欄是空的
if (!empty($_POST['sid']) and !empty($_POST['group_id'])) {

  $isPass = true;

  // 在Network 回應的訊息
  if (!is_numeric($_POST['group_id']) || $_POST['group_id'] > 100 || $_POST['group_id'] === 0) {
    $isPass = false;
    $output['error'] = '請輸入正確的團體行程 ID（1~99）';
}
  if (mb_strlen($_POST['name']) < 2) {
    $isPass = false;
    $output['error'] = '姓名請填兩個字以上';
  }
  if (mb_strlen($_POST['email']) and !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $isPass = false;
    $output['error'] = 'Email 請符合格式';
  }
  if (!preg_match('/^\d{10}$/', $_POST['mobile'])) {
    $isPass = false;
    $output['error'] = '手機號碼格式錯誤，請輸入10位數字';
}


  if ($isPass) {
    # 避免 SQL injection
    $sql = "UPDATE `serve_list` SET 
  `group_id`=?,
  `name`=?,
  `mobile`=?,
  `email`=?,
  `restaurant`=?,
  `restaurantaddress`=?,
  `restauranttime`=?,
  `airline`=?,
  `airportplace`=?,
  `airporttime`=?,
  `hotelname`=?,
  `hoteladdress`=?
  WHERE `sid`=?";

$stmt = $pdo->prepare($sql); // 準備 SQL 語句

$stmt->execute([
  $_POST['group_id'],
  $_POST['name'],
  $_POST['mobile'],
  $_POST['email'],
  $_POST['restaurant'],
  $_POST['restaurantaddress'],
  $_POST['restauranttime'],
  $_POST['airline'],
  $_POST['airportplace'],
  $_POST['airporttime'],
  $_POST['hotelname'],
  $_POST['hoteladdress'],
  $_POST['sid'] // 最後一個參數是 sid
]);

    
    $output['success'] = boolval($stmt->rowCount());
  }
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
}
