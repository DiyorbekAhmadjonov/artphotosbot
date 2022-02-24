<?php
$token = "";
date_default_timezone_set("asia/Tashkent");
$admin  = 733875389;
include 'fun/mysql.php';
function bot($method,$datas=[]){
global $token;
    $url = "https://api.telegram.org/bot".$token."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
//--------[connection]---------//
$servername="127.0.0.1:3311";  // server nomi localhost standars
$username="ephoto360"; // mysql usernamesi
$password="ephoto360"; //mysql paroli
$dbname="ephoto360"; // db nmi
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
echo 	die("Connect Error Database :");
}


$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $message->text;
$photos = $message->photo;
$caption = $message->caption;
$cid = $message->chat->id;
$uid = $message->from->id;
$mid = $message->message_sid;
$fname = $message->from->first_name;
$user = $message->from->username;
$type = $message->chat->type;
$nomer = $message->contact->phone_number;
$name = $message->contact->first_name;
$new = $message->new_chat_member;
$left = $message->left_chat_member;
$new_chat_members = $message->new_chat_member->id;
$lan = $message->new_chat_member->language_code;
$first_name = $message->from->first_name;
$is_bot = $message->new_chat_member->is_bot;
$ismcha = $message->from->first_name;
$familiya = $message->from->last_name;
$bio1 = $message->from->about;
$login = $message->from->username;


$call = $update->callback_query;
$mes = $call->message;
$data = $call->data;
$qid = $call->id;
$callcid = $mes->chat->id;
$callmid = $mes->message_id;
$callfrid = $call->from->id;
$calluser = $mes->chat->username;
$callfname = $call->from->first_name;


function deletemessage($cid,$mid){
	bot('deletemessage',[
	'chat_id'=>$cid,
	'message_id'=>$mid,
]);
}
$home = json_encode([
'inline_keyboard'=>[
[["text"=>"🏠 Bosh menyu","callback_data"=>"home"],],
]
]);
$menu = json_encode([
'resize_keyboard'=>true,
'inline_keyboard'=>[
[["text"=>"🖼 Rasm yasash","callback_data"=>"createphoto"],["text"=>"🖊 Nik yasash","callback_data"=>"createnic"]],
[["text"=>"🎞 Video yasash","callback_data"=>"creatvideo"],["text"=>"🌠 Rasmga Effect","callback_data"=>"rasmgaeffect"]],
[["text"=>"🕋 Namoz vaqtlari","callback_data"=>"namoz"],["text"=>"💵 Valyuta kursi","callback_data"=>"valyuta"]],
]
]);


if ($type == "private"){
	$mysqluser_id = $connn->query("SELECT * FROM `users` WHERE user_id ='$cid'")->fetch_assoc()['user_id'];
if($mysqluser_id){
}else{
$inser = $connn->query("INSERT INTO users(user_id) VALUES ($cid)");

$me = bot('sendmessage',[
	'chat_id'=>$cid,
	'text'=>"Asalomu alaykum $fname",
	 'parse_mode'=>"html",
	 'reply_markup'=>$menu,
])->result->message_id;
sleep(3);
bot('editMessageText',[
'chat_id'=>$cid,
'message_id'=>$me,
'text'=>"Sizgaham shunday bot kerakmi unda @Diyorbek_Ahmadjonov_official ga yozing siz istagan turdagi telegram botlar ochib beramiz!",
 'reply_markup'=>$menu,
]);

exit();
}
}



if ($text=='/start') {
bot('sendmessage',[
	'chat_id'=>$cid,
	'text'=>"Asalomu alaykum $fname",
	 'parse_mode'=>"html",
	 'reply_markup'=>$menu,
]);
exit();
}
//<a href='https://t.me/Hande_Kanaliga/258'>&#8239;</a>
$step= file_get_contents("step/$cid.step2");
if ($data =='rasmgaeffect') {
    	deletemessage($callcid,$callmid);
 file_put_contents("step/$callcid.step2","rasmgaeffect");
bot ('answerCallbackQuery', [
'callback_query_id'=>$qid,
'text'=>"rasm yuboring",
'show_alert'=>true,
]);
}
 
    $photos = $message->photo;
    if($step =="rasmgaeffect" and $photos){
         bot('sendmessage',[
    'chat_id'=>$cid,
    'text'=>"Iltimos kutib turing..",
    'parse_mode'=>"html",

]);
   $file = $photos[count($photos)-1]->file_id;
   $get = bot('getfile',['file_id'=>$file]);
      $patch = $get->result->file_path;
'https://api.telegram.org/file/bot'.$token.'/'.$patch;
$whilenum = 0;
while(true){
    $whilenum++;
	$url = json_decode(file_get_contents('https://api.codebazan.ir/ephoto/addEffect?output=json&effect=https://en.ephoto360.com/2-layer-stained-glass-photo-frame-effect-416.html&image_url=https://api.telegram.org/file/bot'.$token.'/'.$patch),true);
$result = $url['success'];
$rasm = $url['image_url'];
if($result =='true'){
		deletemessage($cid,$midd);
	 $t = file_get_contents("https://api.telegram.org/bot".$token."/sendphoto?chat_id=".$cid."&photo=".$rasm."&reply_markup=".$home."");
	  file_put_contents("step/$cid.step",'null');
	  unlink("step/$cid.step2");

    exit();

}
if($whilenum==3){
	deletemessage($cid,$mid);
		  bot('sendmessage',[
    'chat_id'=>$cid,
    'text'=>"Iltimos qayta urunib ko'ring",
    'parse_mode'=>"html",
    'reply_markup'=>$home,
]);
    exit();
}
    
}
}
if ($data=='createphoto'){
	deletemessage($callcid,$callmid);
	$resnum = $conn->query("SELECT * FROM `ephoto`")->num_rows;
	$sqll = "SELECT * FROM `ephoto` WHERE id ='1'";
	$ress = $conn->query($sqll)->fetch_assoc();
	$photo=$ress['photo'];
	$url=$ress['url'];
bot('sendphoto',[
	'chat_id'=>$callcid,
	'photo'=>$photo,
	'caption'=>"O`zingizga kerakli bo'lgan logoni tanlang:",
	'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["text"=>"⬅️1x","callback_data"=>"back_0"],['text'=>"1/$resnum","callback_data"=>"null"],["text"=>"1x➡️","callback_data"=>"next_2"]],
[["text"=>"⬅️5x","callback_data"=>"bac5_0"],["text"=>"5x➡️","callback_data"=>"nex5_5"]],
[["text"=>"Tanlash✅","callback_data"=>"tanlash_1"],],
[["text"=>"🏠 Bosh menyu","callback_data"=>"home"],],
]
]),
]);
}

//////COde
if ($photos and $mid == $admin) {
	 bot('sendphoto',[
	'chat_id'=> $cid,
	'photo'=>$photos[0]->file_id,
]);
	 $t = "https://api.telegram.org/bot".$token."/sendphoto?chat_id=@ephotodata&photo=".$photos[0]->file_id."&caption=$caption";
	$tru = json_decode(file_get_contents($t));
	$id = $tru->result->message_id;

	$sqll = "INSERT INTO `ephoto`(`url`, `photo`) VALUES ('$caption','https://t.me/ephotodata/$id')";
	$ress = $conn->query($sqll);

	bot('sendmessage',[
	'chat_id'=>$cid,
	'text'=>$tru->result->message_id,
]);
}


if($data){
	if(strpos($data , 'nex5') !== false){
$resnum = $conn->query("SELECT * FROM `ephoto`")->num_rows;
	$num = explode('_', $data)[1];
	if ($num<=$resnum) {
		bot('deletemessage',[
	'chat_id'=>$callcid,
	'message_id'=>$callmid,
]);
		$nextnum = $num+1;
		$backnum = $num-1;
		$nextnum5 = $num+5;
		$backnum5 = $num-5;
		$sqll = "SELECT * FROM `ephoto` WHERE id ='$num'";
		 $ress = $conn->query($sqll)->fetch_assoc();
		 		 $photo=$ress['photo'];
		 		 $url=$ress['url'];

  bot('sendphoto',[
    'chat_id'=>$callcid,
    'photo'=>$photo,
    'caption'=>"<b>O`zingizga kerakli bo'lgan logoni tanlang:</b>",
    'parse_mode'=>"html",
    'reply_markup'=> json_encode([
'inline_keyboard'=>[
[["text"=>"⬅️1x","callback_data"=>"back_$backnum"],['text'=>"$num/$resnum","callback_data"=>"null"],["text"=>"1x➡️","callback_data"=>"next_$nextnum"]],
[["text"=>"⬅️5x","callback_data"=>"bac5_$backnum5"],["text"=>"5x➡️","callback_data"=>"nex5_$nextnum5"]],
[["text"=>"Tanlash✅","callback_data"=>"tanlash_$num"]],
[["text"=>"🏠 Bosh menyu","callback_data"=>"home"],],
]
]),
]);


	}else{
	bot ('answerCallbackQuery', [
'callback_query_id'=>$qid,
'text'=>"Bu oxirgi sahifa",
'show_alert'=>false,
]);

	}

}


	if(strpos($data , 'next') !== false){
$resnum = $conn->query("SELECT * FROM `ephoto`")->num_rows;
		$num = explode('_', $data)[1];
		if ($num<=$resnum) {
		bot('deletemessage',[
	'chat_id'=>$callcid,
	'message_id'=>$callmid,
]);
		$nextnum = $num+1;
		$backnum = $num-1;
		$nextnum5 = $num+5;
		$backnum5 = $num-5;
		$sqll = "SELECT * FROM `ephoto` WHERE id ='$num'";
		 $ress = $conn->query($sqll)->fetch_assoc();
		 		 $photo=$ress['photo'];
		 		 $url=$ress['url'];

  bot('sendphoto',[
    'chat_id'=>$callcid,
    'photo'=>$photo,
    'caption'=>"<b>O`zingizga kerakli bo'lgan logoni tanlang:</b>",
    'parse_mode'=>"html",
    'reply_markup'=> json_encode([
'inline_keyboard'=>[
[["text"=>"⬅️1x","callback_data"=>"back_$backnum"],['text'=>"$num/$resnum","callback_data"=>"null"],["text"=>"1x➡️","callback_data"=>"next_$nextnum"]],
[["text"=>"⬅️5x","callback_data"=>"bac5_$backnum5"],["text"=>"5x➡️","callback_data"=>"nex5_$nextnum5"]],
[["text"=>"Tanlash✅","callback_data"=>"tanlash_$num"]],
[["text"=>"🏠 Bosh menyu","callback_data"=>"home"],],
]
]),
]);

	}else{
	bot ('answerCallbackQuery', [
'callback_query_id'=>$qid,
'text'=>"Bu oxirgi sahifa",
'show_alert'=>false,
]);

	}

}

if(strpos($data , 'bac5') !== false){
		$resnum = $conn->query("SELECT * FROM `ephoto`")->num_rows;
		$num = explode('_', $data)[1];
		if ($num>=1) {
bot('deletemessage',[
	'chat_id'=>$callcid,
	'message_id'=>$callmid,
]);
		$nextnum = $num+1;
		$backnum = $num-1;
		$nextnum5 = $num+5;
		$backnum5 = $num-5;
$sqll = "SELECT * FROM `ephoto` WHERE id ='$num'";
		 $ress = $conn->query($sqll)->fetch_assoc();
		 		 $photo=$ress['photo'];
		 		 $url=$ress['url'];

  bot('sendphoto',[
    'chat_id'=>$callcid,
    'photo'=>$photo,
    'caption'=>"<b>O`zingizga kerakli bo'lgan logoni tanlang:</b>",
    'parse_mode'=>"html",
    'reply_markup'=> json_encode([
'inline_keyboard'=>[
[["text"=>"⬅️1x","callback_data"=>"back_$backnum"],['text'=>"$num/$resnum","callback_data"=>"null"],["text"=>"1x➡️","callback_data"=>"next_$nextnum"]],
[["text"=>"⬅️5x","callback_data"=>"bac5_$backnum5"],["text"=>"5x➡️","callback_data"=>"nex5_$nextnum5"]],
[["text"=>"Tanlash✅","callback_data"=>"tanlash_$num"]],
[["text"=>"🏠 Bosh menyu","callback_data"=>"home"],],
]
]),
]);

		}else{
				bot ('answerCallbackQuery', [
'callback_query_id'=>$qid,
'text'=>"Bu birinchi sahifa",
'show_alert'=>false,
]);

		}
		}


	if(strpos($data , 'back') !== false){
		$resnum = $conn->query("SELECT * FROM `ephoto`")->num_rows;
		$num = explode('_', $data)[1];
		if ($num>=1) {
bot('deletemessage',[
	'chat_id'=>$callcid,
	'message_id'=>$callmid,
]);
		$nextnum = $num+1;
		$backnum = $num-1;
		$nextnum5 = $num+5;
		$backnum5 = $num-5;
$sqll = "SELECT * FROM `ephoto` WHERE id ='$num'";
		 $ress = $conn->query($sqll)->fetch_assoc();
		 		 $photo=$ress['photo'];
		 		 $url=$ress['url'];

  bot('sendphoto',[
    'chat_id'=>$callcid,
    'photo'=>$photo,
    'caption'=>"<b>O`zingizga kerakli bo'lgan logoni tanlang:</b>",
    'parse_mode'=>"html",
    'reply_markup'=> json_encode([
'inline_keyboard'=>[
[["text"=>"⬅️1x","callback_data"=>"back_$backnum"],['text'=>"$num/$resnum","callback_data"=>"null"],["text"=>"1x➡️","callback_data"=>"next_$nextnum"]],
[["text"=>"⬅️5x","callback_data"=>"bac5_$backnum5"],["text"=>"5x➡️","callback_data"=>"nex5_$nextnum5"]],
[["text"=>"Tanlash✅","callback_data"=>"tanlash_$num"]],
[["text"=>"🏠 Bosh menyu","callback_data"=>"home"],],
]
]),
]);

		}else{
				bot ('answerCallbackQuery', [
'callback_query_id'=>$qid,
'text'=>"Bu birinchi sahifa",
'show_alert'=>false,
]);

		}
		}
}

if(strpos($data , 'tanlash') !== false){
		$num = explode('_', $data)[1];
		$sqll = "SELECT * FROM `ephoto` WHERE id ='$num'";
		 $ress = $conn->query($sqll)->fetch_assoc();
		 		 $url=$ress['url'];
	    bot('deletemessage',[
    'chat_id'=>$callcid,
    'message_id'=>$callmid,
]);
    bot('sendmessage',[
	'chat_id'=>$callcid,
	'text'=>"<i><b>Marhamat, ismingizni yuboring..</b></i>\n\n<i>Barcha harflar bosh harfda bo'lsin</i>",
	'parse_mode'=>"html",
]);
file_put_contents("step/$callcid.step",$url);
file_put_contents("step/$callcid.step2",'tayyor');
}

$step= file_get_contents("step/$cid.step2");
$steprasm= file_get_contents("step/$cid.step");
	$tayyprtx ="$text ismiga rasm tayyor";
if ($step =='tayyor' and $text and $text !=='/start' and $text !=='.' ) {
	$midd =  bot('sendmessage',[
	'chat_id'=>$cid,
	'text'=>"<b>✅ Tayyorlanmoqda biroz kuting...</b>",
	'parse_mode'=>"html",
	'reply_to_message_id'=>$mid,
])->result->message_id;
	$sqll = "SELECT *  FROM `succes` WHERE `url` = '$steprasm' AND `text` = '$text'";
		 $ress = $conn->query($sqll)->fetch_assoc();
		 		 $photo=$ress['photo'];
		 		 if ($photo) {
		 		 	sleep(1.5);
		 		 		deletemessage($cid,$midd);
		 		 bot('sendphoto',[
    'chat_id'=>$cid,
    'photo'=>$photo,
    'caption'=>"$tayyprtx",
    'parse_mode'=>"html",
    'reply_markup'=>$home,
]);
		 		 }else{
		 		     
while(true){
    $whilenum++;
    
    
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  



    $ephoto = "https://api.codebazan.ir/ephoto/writeText?output=json&effect=".$steprasm."&text=".$text."";

$html = file_get_contents($ephoto, false, stream_context_create($arrContextOptions));

	$url = json_decode($html,true);
$result = $url['success'];
$rasm = $url['image_url'];

	 bot('sendmessage',[
    'chat_id'=>733875389,
    'text'=> $html,
    'parse_mode'=>"html",
    'reply_markup'=>$home,
]);


if($result =='true'){
		deletemessage($cid,$midd);
	 $t = "https://api.telegram.org/bot".$token."/sendphoto?chat_id=".$cid."&photo=".$rasm."&caption=$tayyprtx&reply_markup=".$home."";
	$tru = json_decode(file_get_contents($t));
	 $t1 = "https://api.telegram.org/bot".$token."/sendphoto?chat_id=@ephotocech&photo=".$rasm."&caption=$text";
	$tru1 = json_decode(file_get_contents($t1));
	$mesid = $tru1->result->message_id;
	$sqll = "INSERT INTO `succes`(`text`,`photo`, `url`) VALUES ('$text','https://t.me/ephotocech/$mesid','$steprasm')";
	$ress = $conn->query($sqll);
	  file_put_contents("step/$cid.step",'null');
	  unlink("step/$cid.step2");
	  
    exit();

}

if($whilenum==30){
	deletemessage($cid,$midd);
		 		 bot('sendmessage',[
    'chat_id'=>$cid,
    'text'=>"Iltimos qayta urunib ko'ring",
    'parse_mode'=>"html",
    'reply_markup'=>$home,
]);
file_put_contents("step/$cid.step",'null');
	  unlink("step/$cid.step2");
    exit();
}
}


}
}


if ($data=='createnic') {
	$cid = $callcid;
	 bot('sendmessage',[
    'chat_id'=>$cid,
    'text'=>"Menga nik nomininiz yuboring",
    'parse_mode'=>"html",
]);
	 file_put_contents("step/$cid.step2",'nik');
	 deletemessage($callcid,$callmid);
	 exit();
}
$step= file_get_contents("step/$cid.step2");


if ($step =='nik' and $text and $text !=='/start' and $text !=='.') {
	$text = str_replace(['.','-','/'], [' ',' ',' ',' '], $text);
	
	$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  



    $ephoto = "https://api.codebazan.ir/font/?text=$text";

$html = file_get_contents($ephoto, false, stream_context_create($arrContextOptions));

bot('sendmessage',[
	'chat_id'=> $cid,
	'text'=>json_encode($html),
'parse_mode'=>'HTML',

]);

	$link = json_decode($html,true);
$resultlink = $link["result"];
foreach ($resultlink as $key => $value) {
	if ($key <=15) {


	$matn .= "$key - <code>$value</code> \n";
}
}
bot('sendmessage',[
	'chat_id'=> $cid,
	'text'=>"O`zingizga kerakli bo'lgan nikni tanlang:\n\n $matn",
'parse_mode'=>'HTML',
	'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["text"=>"Oldingisi","callback_data"=>"null"],["text"=>"1/15/138","callback_data"=>"M"],["text"=>"Keyingisi","callback_data"=>"nik|30|$text"]],
[["text"=>"🏠 Bosh menyu","callback_data"=>"home"],],
]
]),
]);
unlink("step/$cid.step2");
}


if(strpos($data , 'nik') !== false){
		$ex = explode('|', $data);
		$limit = $ex[1];
		if ($limit <=138 ) {
	bot ('answerCallbackQuery', [
'callback_query_id'=>$qid,
'text'=>'Loading..',
'show_alert'=>false,
]);


		$offset = $ex[1] - 15;
			$next = $ex[1] + 15;
		
		$text = $ex[2];
$link = json_decode(file_get_contents("http://api.codebazan.ir/font/?text=$text"),true);
$resultlink = $link["result"];
foreach ($resultlink as $key => $value) {
	if ($limit ==135) {
	$limit =138;
		}
	if ($key <=$limit and $key >=$offset+1) {
	$matn .= "$key - <code>$value</code>\n";
}
}
bot('editMessageText',[
	'chat_id'=> $callcid,
	'message_id'=>$callmid,
	'text'=>"O`zingizga kerakli bo'lgan nikni tanlang:\n\n$matn \n @ArtPhotosbot",
'parse_mode'=>'HTML',
	'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["text"=>"Oldingisi","callback_data"=>"nic|$offset|$text"],["text"=>"$offset/$limit/138","callback_data"=>"M"],["text"=>"Keyingisi","callback_data"=>"nik|$next|$text"]],
[["text"=>"🏠 Bosh menyu","callback_data"=>"home"],],
]
]),
]);
}else{

	bot ('answerCallbackQuery', [
'callback_query_id'=>$qid,
'text'=>'Bunday sahifa mavjud emas',
'show_alert'=>false,
]);
}
}

if(strpos($data , 'nic') !== false){
		$ex = explode('|', $data);
		$limit = $ex[1];
		$offset = $ex[1] - 15;
		$offsett = $ex[1] - 14;
		$next = $ex[1] + 15;
		if ($limit <=138) {
	bot ('answerCallbackQuery', [
'callback_query_id'=>$qid,
'text'=>'Loading..',
'show_alert'=>false,
]);
		$text = $ex[2];
$link = json_decode(file_get_contents("http://api.codebazan.ir/font/?text=$text"),true);
$resultlink = $link["result"];
foreach ($resultlink as $key => $value) {
	if ($key <=$limit and $key >=$offset+1) {
	$matn .= "$key - <code>$value</code>\n";
}
}
bot('editMessageText',[
	'chat_id'=> $callcid,
	'message_id'=>$callmid,
	'text'=>"O`zingizga kerakli bo'lgan nikni tanlang:\n\n$matn \n @ArtPhotosbot",
'parse_mode'=>'HTML',
	'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["text"=>"Oldingisi","callback_data"=>"nic|$offset|$text"],["text"=>"$offsett/$limit/138","callback_data"=>"M"],["text"=>"Keyingisi","callback_data"=>"nik|$next|$text"]],
[["text"=>"🏠 Bosh menyu","callback_data"=>"home"],],
]
]),
]);
}
}


if($data =='null'){
	bot ('answerCallbackQuery', [
'callback_query_id'=>$qid,
'text'=>'Bunday sahifa mavjud emas',
'show_alert'=>false,
]);
}



$okun=date("n", strtotime("+1 day"));
$kun = date("d", strtotime("+1 day"));
$yil = date("Y");
$ran = "$okun-$kun-$yil-10";
if($data =='namoz'){
	deletemessage($callcid,$callmid);
    bot('SendPhoto',[ 
      'chat_id'=>$callcid, 
      'photo'=>"http://diyormedia.uz/bots/nomozni_organamizzbot/namozvaqti/index.php?text=$ran",
'caption'=>"Namoz Vaqtlari

",
'reply_markup'=>$home,
        ]);
}

if ($data =='home') {
	deletemessage($callcid,$callmid);
bot('sendmessage',[
	'chat_id'=>$callcid,
	'text'=>"Asalomu alaykum $fname",
	 'parse_mode'=>"html",
	 'reply_markup'=>$menu,
]);
}
$remkey= json_encode([
'ReplyKeyboardRemove'=>true,
'remove_keyboard'=>true,
]);

    $step= file_get_contents("step/$cid.step2");
    $callstep= file_get_contents("step/$callcid.step2");
    if($data=='creatvideo'){
    	deletemessage($callcid,$callmid);
    bot('sendmessage',[
	'chat_id'=>$callcid,
	'text'=>"<i><b>Video tayyorlash bo'limiga hush kelibsiz 😘</b></i>\n<i>Video tayyorlash uchun rasmni ko'rinish vaqtni tanlang</i>",
	 'parse_mode'=>"html",
	 'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["text"=>"2 s","callback_data"=>"creatvideo|2"],["text"=>"3 s","callback_data"=>"creatvideo|3"],["text"=>"4 s","callback_data"=>"creatvideo|4"],["text"=>"5 s","callback_data"=>"creatvideo|5"],["text"=>"6 s","callback_data"=>"creatvideo|6"]],
]
]),
	 
]);
file_put_contents("step/$callcid.step2","creatvideo|time");
}

if($callstep =="creatvideo|time"){
    if($data){
    	deletemessage($callcid,$callmid);
        $ex = explode("|",$data)[1];
        $ar = [2,3,4,5,6];
        if (in_array($ex, $ar)) {

         bot('sendmessage',[
	'chat_id'=>$callcid,
	'text'=>"<i><b>Rasm ko'rinish vaqtni $ex soniya qilib sozlandi 🥳 </b></i>\n<i>Video tayyorlash uchun 1 tadan ko'p rasm yuboring!</i>",
	 'parse_mode'=>"html",
	 'reply_markup'=>$remkey,
	 
]);
         file_put_contents("step/$callcid.secund",$ex);
file_put_contents("step/$callcid.step2","creatvideo|photo");
}
}
}
$mesid= file_get_contents("path/$cid/mid.txt");
 $secund = file_get_contents("step/$cid.secund");
$list = file_get_contents("path/$cid/list.txt");
$photos = $message->photo;
    if($step =="creatvideo|photo" and $photos){

   $file = $photos[count($photos)-1]->file_id;
   $get = bot('getfile',['file_id'=>$file]);
      $patch = $get->result->file_path;
mkdir("path");
mkdir("path/$cid");
$dirnum = count(glob("path/$cid/*.jpg"));


   if(copy('https://api.telegram.org/file/bot'.$token.'/'.$patch,"path/$cid/$dirnum.jpg")){
deletemessage($cid,$mesid);
file_put_contents("path/$cid/time.txt",time());
$mesid = bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"".$dirnum +1 ." rasm yuklandi \n $te",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["text"=>"Video tayyorlash","callback_data"=>"succesvideo"],],
]
]),
 
])->result->message_id;
file_put_contents("path/$cid/mid.txt",$mesid);
file_put_contents("path/$cid/list.txt","$list\nfile '$dirnum.jpg'\nduration $secund");
}
}


if($data =='succesvideo'){
	deletemessage($callcid,$callmid);
	$cid = $callcid;
	 bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"Tayyorlanmoqda",
]);
   /* bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"ffmpeg -f concat -i path/$cid/list.txt -i 1.mp3 -c:v libx264 -c:a aac -b:a 192k -shortest $cid.mp4",
]);*/
exec("ffmpeg -f concat -i path/".$cid."/list.txt -i 1.mp3 -c:v libx264 -c:a aac -b:a 192k -shortest ".$cid.".mp4");

$ok = bot('sendvideo',[
          'chat_id'=>$cid,
          'video'=>new CURLFile($cid.".mp4"),
          ])->ok;

if ($ok =='true') {
}else{
	 bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"Xatolik boldi iltimos boshqa rasm yuklab ko'ring",
'reply_markup'=>$home,
]);


}
array_map('unlink', glob("path/$cid/*.*"));
 unlink("$cid.mp4");
}

if ($data=='valyuta'){
$xml = file_get_contents("http://cbu.uz/uzc/arkhiv-kursov-valyut/xml/");
$m = new SimpleXMLElement($xml);
foreach ($m as $val) {
    $nomi = $val->CcyNm_UZ;
    $summa = number_format("$val->Rate", 2, ',', ' ');
    $matn .= "<b>1 $nomi = $summa UZS</b> \n";
}
	 $bugun = date('d.m.Y');
	deletemessage($callcid,$callmid);
bot('sendMessage',[
'chat_id'=>$callcid,
'text'=>"🇺🇿 Markaziy Bank kursni yangiladi: $bugun \n $matn",
'parse_mode'=>"HTML",
'reply_to_message_id'=>$miid,
'reply_markup'=>json_encode(
['inline_keyboard' => [
[['callback_data' => "home", 'text' => "🏠 Bosh menyu"],['callback_data' => "updatevalyuta", 'text' => "🔄 Yangilash"]],
]
]),
]);
}

if($data=="updatevalyuta"){
$xml = file_get_contents("http://cbu.uz/uzc/arkhiv-kursov-valyut/xml/");
$m = new SimpleXMLElement($xml);
foreach ($m as $val) {
    $nomi = $val->CcyNm_UZ;
    $summa = number_format("$val->Rate", 2, ',', ' ');
    $matn .= "<b>1 $nomi = $summa UZS</b> \n";
}
	 $bugun = date('d.m.Y');
bot('editMessageText',[
 'chat_id'=>$callcid,
 'message_id'=>$callmid,
 'parse_mode'=>"HTML",
 'text'=>"🇺🇿 Markaziy Bank kursni yangiladi: $bugun\n$matn",
'reply_markup'=>json_encode(
['inline_keyboard' => [
[['callback_data' => "home", 'text' => "🏠 Bosh menyu"],['callback_data' => "updatevalyuta", 'text' => "🔄 Yangilash"]],
]
]),
 ]);
bot("answerCallbackQuery",[
"callback_query_id"=>$qid,
"text"=>"Yangilandi: $bugun",
"show_alert"=>true,
]);
}


