<?php
mb_internal_encoding("UTF-8");
include('db.php');

print_r($_REQUEST);
print_r($_FILES);



$email = $_POST['email'];
$message = $_POST['message'];
$file = $_FILES['screen']['name'];

$query = "INSERT INTO db_table (email, message, file) VALUES (:email, :message, :file)";

$query_prep = $connection->prepare($query);
$data =['email'=>$email, 'message'=>$message, 'file'=>$file];
$result = $query_prep->execute($data);


if(isset($_FILES['screen'])){
    $errors = array();
    $file_name = $_FILES['screen']['name'];
    $file_size = $_FILES['screen']['size'];
    $file_tmp = $_FILES['screen']['tmp_name'];
    $file_type = $_FILES['screen']['type'];
    $expension = array("jpeg", "jpg", "png");

    if($file_size> 10097152){
        $errors[]= 'Не больше 10 мб';
    }

    if(empty($errors) == true){
        move_uploaded_file($file_tmp, "./files/".$file_name);
        echo "Success";
    }
    else {
        print $errors;
    }
}
$botToken = "688730331:AAFMAAwp5MagoHeFwQawOhE0QdHd7Ie-XSs";
$chatId = "421801593";
$website="https://api.telegram.org/bot".$botToken;
$params=[
'chat_id' => $chatId,
'parse_mode' => 'html',
'text' => implode(PHP_EOL, array(
    "<b>E-mail:</b> ". $email,
    "Сообщение:  " .  $message,
    "Скриншот: "  . 'http://form/files/'.$file,
  ) )

];


$ch = curl_init($website . '/sendMessage');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// $url = "https://api.telegram.org/".$botToken."/sendDocument";
//                // $_document = "ok.json";
//                $_document = $_FILES['document']['tmp_name'];
//            $document = new CURLFile(realpath("./files/'.$file"));
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_POST, 1);
//            curl_setopt($ch, CURLOPT_POSTFIELDS, ["chat_id" => $chatId, "document" => $document]);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//            $out = curl_exec($ch);
//            curl_close($ch);
//            print_r($out);
$result = curl_exec($ch);
curl_close($ch);
print_r($result );



die();
?>
