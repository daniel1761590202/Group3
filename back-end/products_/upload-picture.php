<?php
$dir = __DIR__. './uploads/'; # 存放檔案的資料夾

$exts = [   # 檔案類型的篩選
  'image/jpeg' => '.jpg',
  'image/png' =>  '.png',
  'image/webp' => '.webp',
];

$output = [ 
  'success' => false,
  'file' => '' ]; # 輸出的格式
  
# 確保有上傳檔案，並且有 picture 欄位，並且沒有錯誤
if (!empty($_FILES) and !empty($_FILES['picture']) and $_FILES['picture']['error']==0) {
  # 如果類型有對應到副檔名
  $type = $_FILES['picture']['type'];
  if (!empty( $exts[$type] )) {
    $ext = $exts[$type]; # 副檔名
    $f = sha1($_FILES['picture']['name']. uniqid()); # 隨機的主檔名
    if ( move_uploaded_file( $_FILES['picture']['tmp_name'], $dir . $f. $ext ) ) {
      $output['success'] = true;
      $output['file'] = $f. $ext;
    }
  }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);