<?php
// Detecte Vercel ou KSWEB
$isVercel = isset($_ENV['VERCEL']) || is_dir('/tmp');
$BASE_DIR = $isVercel ? '/tmp/data' : __DIR__.'/data';
if (!is_dir($BASE_DIR)) mkdir($BASE_DIR, 0777, true);

function loadJson($name, $default=[]){
  global $BASE_DIR;
  $file = $BASE_DIR."/$name.json";
  if(!file_exists($file)){ file_put_contents($file, json_encode($default, JSON_PRETTY_PRINT)); return $default; }
  return json_decode(file_get_contents($file), true) ?: $default;
}
function saveJson($name, $data){
  global $BASE_DIR;
  file_put_contents($BASE_DIR."/$name.json", json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
}
$DEFAULT_GAMES = [
  ["id"=>"ff","name"=>"Free Fire","image"=>"https://cdn-icons-png.flaticon.com/512/686/686589.png","cats"=>["Top Up","Level Up"]],
  ["id"=>"ml","name"=>"Mobile Legends","image"=>"https://cdn-icons-png.flaticon.com/512/2972/2972185.png","cats"=>["Diamonds"]],
  ["id"=>"pubg","name"=>"PUBG Mobile","image"=>"https://cdn-icons-png.flaticon.com/512/1019/1019084.png","cats"=>["UC"]],
  ["id"=>"blood","name"=>"Blood Strike","image"=>"https://cdn-icons-png.flaticon.com/512/3069/3069011.png","cats"=>["Gold"]],
  ["id"=>"delta","name"=>"Delta Force","image"=>"https://cdn-icons-png.flaticon.com/512/1584/1584892.png","cats"=>["Coins"]],
  ["id"=>"arena","name"=>"Arena Breakout","image"=>"https://cdn-icons-png.flaticon.com/512/686/686589.png","cats"=>["Bonds"]]
];
$DEFAULT_TARIFS = [
  ["id"=>1,"gameId"=>"ff","cat"=>"Top Up","name"=>"100 Diamonds","price"=>4500,"image"=>"https://cdn-icons-png.flaticon.com/512/1029/1029183.png","tag"=>"HOT"]
];
$DEFAULT_SETTINGS = ["mvola_num"=>"034 16 155 30","mvola_name"=>"Thierry","mvola_ussd"=>"*120*0341615530#","orange_num"=>"032 25 591 21","orange_name"=>"Thierry","orange_ussd"=>"#144*0322559121#"];
?>