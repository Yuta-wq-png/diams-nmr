<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
require 'config.php';
$action = $_GET['action'] ?? $_POST['action'] ?? '';
if($action==='getAll'){
  echo json_encode(['games'=>loadJson('games',$DEFAULT_GAMES),'tarifs'=>loadJson('tarifs',$DEFAULT_TARIFS),'orders'=>loadJson('orders',[]),'settings'=>loadJson('settings',$DEFAULT_SETTINGS)]);
  exit;
}
if(in_array($action,['saveGames','saveTarifs','saveSettings'])){
  $map=['saveGames'=>'games','saveTarifs'=>'tarifs','saveSettings'=>'settings'];
  saveJson($map[$action], json_decode($_POST['data'],true));
  echo json_encode(['ok'=>true]); exit;
}
if($action==='newOrder'){
  $orders=loadJson('orders',[]); $o=json_decode($_POST['data'],true); $o['id']=time().rand(10,99); array_unshift($orders,$o); saveJson('orders',$orders);
  echo json_encode(['ok'=>true]); exit;
}
if($action==='updateOrder'){ $orders=loadJson('orders',[]); foreach($orders as &$o){ if((string)$o['id']===(string)$_POST['id']) $o['status']=$_POST['status']; } saveJson('orders',$orders); echo json_encode(['ok'=>true]); exit; }
if($action==='deleteOrder'){ $orders=loadJson('orders',[]); $orders=array_values(array_filter($orders, fn($o)=>(string)$o['id']!==(string)$_POST['id'])); saveJson('orders',$orders); echo json_encode(['ok'=>true]); exit; }