<?php require 'config.php'; $s=loadJson('settings',$DEFAULT_SETTINGS);?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>GameTop MG</title><script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
<style>
*{ -webkit-tap-highlight-color: transparent } body{font-family:Inter,sans-serif;background:#050507;color:#fff;overflow-x:hidden}
.orbit{font-family:Orbitron}.bg-mesh{background:radial-gradient(at 10% 10%,rgba(250,204,21,0.18) 0%,transparent 40%),radial-gradient(at 90% 20%,rgba(168,85,247,0.15) 0%,transparent 40%),#050507}
.glass{background:linear-gradient(135deg,rgba(22,22,30,0.8) 0%,rgba(14,14,20,0.6) 100%);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,0.08)}
.glass-yellow{background:linear-gradient(135deg,rgba(250,204,21,0.15) 0%,rgba(250,204,21,0.05) 100%);border:1px solid rgba(250,204,21,0.2)}
.btn{transition:.2s;transform:translateZ(0)}.btn:active{transform:scale(.93)}
@keyframes slideIn{from{transform:translateX(120%)}to{transform:translateX(0)}}.toast{animation:slideIn.4s}
@keyframes shake{0%,100%{transform:translateX(0)}20%,60%{transform:translateX(-6px)}40%,80%{transform:translateX(8px)}}.shake{animation:shake.3s}
</style>
</head>
<body class="bg-mesh min-h-screen">
<div id="toasts" class="fixed top-4 right-4 z-[999] space-y-3 w-[90%] max-w-sm"></div>
<header class="glass sticky top-0 z-50 px-5 py-4 flex justify-between items-center mx-4 mt-4 rounded-[20px]">
<div class="flex items-center gap-3"><div class="w-9 h-9 rounded-xl bg-yellow-400 flex items-center justify-center text-black font-black orbit text-xs">GT</div><div><h1 class="orbit font-black text-[12px]">GAMETOP <span class="text-yellow-400">MG</span></h1><p class="text-[8px] text-white/30">MADAGASCAR OFFICIAL</p></div></div>
<div class="flex gap-2"><button onclick="nav('history')" class="btn glass px-4 py-2.5 rounded-full text-[10px]">HISTORIQUE</button><button onclick="nav('cart')" class="btn bg-yellow-400 text-black px-5 py-2.5 rounded-full text-[10px] font-black">PANIER <span id="cartCount" class="bg-black text-yellow-400 w-5 h-5 rounded-full flex items-center justify-center">0</span></button></div>
</header>

<div id="home" class="max-w-6xl mx-auto p-4">
<div class="glass rounded-[32px] p-8 md:p-12 mt-6"><h2 class="orbit text-5xl md:text-7xl font-black leading-[0.8]">RECHARGE<br><span class="text-yellow-400">2 MINUTES</span></h2><p class="text-white/50 text-sm mt-4">Vendeur #1 Mada - Mvola <?= $s['mvola_num']?> / Orange <?= $s['orange_num']?></p><div id="gamesList" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mt-8"></div></div>
</div>

<div id="gameView" class="hidden max-w-6xl mx-auto p-4"><button onclick="nav('home')" class="btn text-xs text-white/30">← Retour</button><div id="gameHeader" class="mt-6"></div><div id="catTabs" class="flex gap-2 mt-8 overflow-auto"></div><div id="tarifsList" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6"></div></div>

<div id="cart" class="hidden max-w-xl mx-auto p-4"><button onclick="nav('home')" class="btn text-xs text-white/30">← Boutique</button><h2 class="orbit font-black mt-6 text-2xl">PANIER</h2><div id="cartItems" class="mt-6 space-y-3"></div><div class="glass rounded-[24px] p-6 mt-6 space-y-4" id="userBox"><input id="pseudo" placeholder="Pseudo *" class="w-full bg-black/50 border border-white/10 rounded-xl p-4 text-xs"><input id="uid" placeholder="UID *" class="w-full bg-black/50 border border-white/10 rounded-xl p-4 text-xs"><button onclick="goPay()" class="btn w-full bg-white text-black rounded-xl py-4 font-black text-xs">CONTINUER → PAIEMENT</button></div></div>

<div id="payView" class="hidden max-w-xl mx-auto p-4">
<button onclick="nav('cart')" class="btn text-xs text-white/30">← Retour</button><h2 class="orbit font-black mt-6 text-2xl">PAIEMENT</h2>
<div class="glass-yellow rounded-[24px] p-6 mt-6"><div class="grid grid-cols-2 gap-3"><div class="glass rounded-2xl p-4"><p class="text-[10px] text-green-400">🟢 MVOLA</p><p class="font-black"><?= $s['mvola_num']?></p><p class="text-[10px] text-white/40"><?= $s['mvola_name']?></p><a href="tel:<?= $s['mvola_ussd']?>" class="btn mt-2 block text-center bg-yellow-400 text-black rounded-full py-2 text-[10px]">📞 <?= $s['mvola_ussd']?></a></div><div class="glass rounded-2xl p-4"><p class="text-[10px] text-orange-400">🟠 ORANGE</p><p class="font-black"><?= $s['orange_num']?></p><a href="tel:<?= $s['orange_ussd']?>" class="btn mt-2 block text-center bg-white text-black rounded-full py-2 text-[10px]">📞 <?= $s['orange_ussd']?></a></div></div></div>
<div class="glass rounded-[24px] p-6 mt-4 space-y-5" id="payBox">
<div class="relative" id="customSelectWrap"><p class="text-[10px] text-white/30 mb-2 orbit">CHOISIR NUMÉRO *</p><button type="button" id="customSelectBtn" class="w-full bg-black border-2 border-yellow-400 rounded-[16px] p-4 text-xs flex justify-between"><span id="customSelectValue">🟠 Orange Money - <?= $s['orange_num']?></span><span>▼</span></button><div id="customSelectList" class="hidden absolute z-30 w-full mt-2 glass rounded-2xl overflow-hidden"><button data-v="MVola - <?= $s['mvola_num']?>" class="w-full text-left p-4 text-xs">🟢 MVola - <?= $s['mvola_num']?></button><button data-v="Orange Money - <?= $s['orange_num']?>" class="w-full text-left p-4 text-xs">🟠 Orange Money - <?= $s['orange_num']?></button><button data-v="Cash Point" class="w-full text-left p-4 text-xs">🏪 Cash Point</button></div></div>
<select id="payMethod" class="hidden"><option>MVola - <?= $s['mvola_num']?></option><option selected>Orange Money - <?= $s['orange_num']?></option><option>Cash Point</option></select>
<input id="senderPhone" placeholder="Ton numéro expéditeur *" class="w-full bg-black/50 border border-white/10 rounded-xl p-4 text-xs">
<input id="payRef" placeholder="Référence transaction *" class="w-full bg-black/50 border border-white/10 rounded-xl p-4 text-xs">
<div id="fileZone" class="rounded-2xl p-[1.5px] bg-gradient-to-br from-yellow-400/40 to-white/5 cursor-pointer"><div class="bg-[#101018] rounded-[15px] p-5"><input type="file" id="proofFile" accept="image/*" class="hidden"><div id="fileEmpty" class="text-center"><div class="w-14 h-14 mx-auto rounded-2xl bg-yellow-400/15 flex items-center justify-center">📸</div><p class="font-black text-[11px] mt-3">CLIQUER POUR CAPTURE</p><p class="text-[10px] text-white/40">Obligatoire même cash point</p></div><div id="fileHas" class="hidden"><img id="previewImg" class="w-full max-h-[260px] object-contain"><p id="fileName" class="text-[10px] mt-2"></p><button type="button" onclick="removeFile()" class="btn bg-red-500/15 text-red-400 px-3 py-1 rounded-full text-[10px] mt-2">Retirer</button></div></div></div>
<button onclick="confirmOrder()" class="btn w-full bg-yellow-400 text-black rounded-xl py-5 font-black text-xs orbit">CONFIRMER COMMANDE</button>
</div>
</div>

<div id="history" class="hidden max-w-xl mx-auto p-4"><button onclick="nav('home')" class="btn text-xs text-white/30">← Accueil</button><h2 class="orbit font-black mt-6 text-2xl">HISTORIQUE</h2><div id="historyList" class="mt-6 space-y-3"></div></div>

<script>
const $=s=>document.querySelector(s);
const toast=(m,t='ok')=>{let c=$('#toasts');let d=document.createElement('div');d.className=`toast glass px-5 py-4 rounded-2xl text-xs border-l-4 ${t==='ok'?'border-green-500':'border-red-500'}`;d.innerText=m;c.appendChild(d);setTimeout(()=>d.remove(),3000)};
let games=[],tarifs=[],orders=[],settings={},cart=JSON.parse(localStorage.getItem('gt_cart')||'[]'),proof='';
async function load(){let r=await fetch('api.php?action=getAll');let d=await r.json();games=d.games;tarifs=d.tarifs;orders=d.orders;settings=d.settings;renderGames();$('#cartCount').innerText=cart.length;}
function saveCart(){localStorage.setItem('gt_cart',JSON.stringify(cart));}
function nav(id){['home','gameView','cart','payView','history'].forEach(v=>$('#'+v).classList.add('hidden'));$('#'+id).classList.remove('hidden');if(id==='home')renderGames();if(id==='cart')renderCart();if(id==='history')renderHistory();}
function renderGames(){$('#gamesList').innerHTML=games.map(g=>`<div onclick="openGame('${g.id}')" class="btn glass rounded-[28px] p-7 text-center"><img src="${g.image}" class="w-12 h-12 mx-auto"><h4 class="orbit text-[11px] font-black mt-4">${g.name}</h4><p class="text-[9px] text-white/30">${g.cats.length} cats • ${tarifs.filter(t=>t.gameId===g.id).length} offres</p></div>`).join('');}
let curG,curCat;function openGame(id){curG=games.find(g=>g.id===id);curCat=curG.cats[0];nav('gameView');$('#gameHeader').innerHTML=`<div class="glass rounded-[28px] p-7"><h2 class="orbit font-black text-2xl">${curG.name}</h2></div>`;$('#catTabs').innerHTML=curG.cats.map(c=>`<button onclick="setCat('${c}')" class="btn px-6 py-3 rounded-full text-[10px] ${curCat===c?'bg-yellow-400 text-black':'glass'}">${c}</button>`).join('');renderTarifs();}
function setCat(c){curCat=c;$('#catTabs').innerHTML=curG.cats.map(x=>`<button onclick="setCat('${x}')" class="btn px-6 py-3 rounded-full text-[10px] ${curCat===x?'bg-yellow-400 text-black':'glass'}">${x}</button>`).join('');renderTarifs();}
function renderTarifs(){let list=tarifs.filter(t=>t.gameId===curG.id&&t.cat===curCat);$('#tarifsList').innerHTML=list.map(t=>`<div class="glass rounded-[22px] p-5"><img src="${t.image}" class="w-14 h-14 mx-auto"><h4 class="font-bold text-[13px] mt-3">${t.name}</h4><p class="text-yellow-400 font-black">${Number(t.price).toLocaleString()} Ar</p><button onclick='addCart(${JSON.stringify(t).replace(/'/g,"")})' class="btn w-full mt-3 bg-white text-black rounded-full py-2 text-[10px]">+ PANIER</button></div>`).join('');}
function addCart(t){cart.push(t);saveCart();toast('Ajouté '+t.name,'ok');$('#cartCount').innerText=cart.length;}
function renderCart(){let tot=cart.reduce((s,c)=>s+Number(c.price),0);$('#cartItems').innerHTML=cart.length?cart.map((c,i)=>`<div class="glass rounded-2xl p-4 flex justify-between text-xs"><span>${c.name}</span><span>${c.price} Ar <button onclick="cart.splice(${i},1);saveCart();renderCart();$('#cartCount').innerText=cart.length">✕</button></span></div>`).join('')+`<div class="glass-yellow rounded-2xl p-4 flex justify-between font-black"><span>TOTAL</span><span>${tot.toLocaleString()} Ar</span></div>`:'<div class="glass rounded-2xl p-10 text-center opacity-30">Panier vide</div>';}
function goPay(){if(!pseudo.value.trim()||!uid.value.trim()){toast('Pseudo + UID obligatoire');return}if(!cart.length){toast('Panier vide');return}localStorage.setItem('gt_tmp_p',pseudo.value);localStorage.setItem('gt_tmp_u',uid.value);nav('payView');}
const csBtn=$('#customSelectBtn'), csList=$('#customSelectList'), csVal=$('#customSelectValue'), realSelect=$('#payMethod');
csBtn.addEventListener('click',()=>csList.classList.toggle('hidden'));
csList.querySelectorAll('button').forEach(b=>b.addEventListener('click',()=>{csVal.innerText=b.innerText;realSelect.value=b.dataset.v;csList.classList.add('hidden');}));
const fileZone=$('#fileZone'), proofFile=$('#proofFile');
fileZone.addEventListener('click',()=>proofFile.click());
proofFile.addEventListener('change',e=>{let r=new FileReader();r.onload=()=>{proof=r.result;$('#previewImg').src=proof;$('#fileName').innerText=e.target.files[0].name;$('#fileEmpty').classList.add('hidden');$('#fileHas').classList.remove('hidden');};r.readAsDataURL(e.target.files[0]);});
function removeFile(){proof='';proofFile.value='';$('#fileEmpty').classList.remove('hidden');$('#fileHas').classList.add('hidden');}
async function confirmOrder(){let ref=$('#payRef').value.trim(), sender=$('#senderPhone').value.trim();if(!sender||!ref||!proof){toast('Remplis tout + capture');return}let o={pseudo:localStorage.getItem('gt_tmp_p'),uid:localStorage.getItem('gt_tmp_u'),items:cart,total:cart.reduce((s,c)=>s+Number(c.price),0),method:realSelect.value,ref,sender,proof,status:'pending',date:new Date().toLocaleString()};let fd=new FormData();fd.append('action','newOrder');fd.append('data',JSON.stringify(o));let res=await fetch('api.php',{method:'POST',body:fd});let j=await res.json();if(j.ok){cart=[];saveCart();proof='';toast('Commande envoyée','ok');nav('history');load();}}
function renderHistory(){$('#historyList').innerHTML=orders.filter(o=>o.pseudo===localStorage.getItem('gt_tmp_p')).map(o=>`<div class="glass rounded-2xl p-5 text-xs"><b>#${o.id.toString().slice(-6)} • ${o.total} Ar - ${o.status}</b><p>${o.pseudo} • ${o.method} • Ref ${o.ref} • Exp ${o.sender}</p></div>`).join('')||'<div class="glass p-10 text-center opacity-30">Aucune commande</div>';}
load();
</script></body></html>