# CW AR-GE Shell V1
**[Cyber-Warrior.Org](https://www.cyber-warrior.org/) [AR-GE](https://www.cyber-warrior.org/Forum/GorevOrg_Ar-Ge.asp)** grubu tarafından geliştirilen, **konsol görünümlü** PHP SHELL yazılımdır.

## Kurulum
Yukarıdan "Clone or download" seçeneğinden zip olarak indirin. İndirdiğiniz zip dosyasını arşivden çıkarın. Klasörün içerisinde bulunan "**ShellV1.php**" yazılımı kullanıma hazır halde gelmektedir. Bazı sunucularda kodlar zararlı olarak algılandığında "**ShellV1_Encrypted.php**" dosyasını kullanabilirsiniz. Bu dosya şifrelenmiş olduğu için tespit edilmeyecektir.

Sisteme giriş şifresini **6. satırda** yer alan **$girisSifre = "demo";** bölümündeki "**demo**" kısmına kullanmak istediğiniz şifreyi yazarak değiştirebilirsiniz.

## Komutlar
* **yardim:** Kullanım ile ilgili bilgileri verir.
* **giris:** AR-GE Shell V1'i kullanabilmek için giriş yapılmalıdır. **giris [sifreniz]** şeklinde kullanılır.
* **sistem:** Sunucu ile ilgili ayrıntılı bilgileri verir.
* **temizle:** Tüm ekrandaki içerikleri temizler.
* **ls:** Bulunduğunuz dizindeki dosya bilgisini verir.
* **cd:** Dizinler arası geçiş için kullanılır. Bulunduğunuz dizinde bir klasöre girmek için **cd [klasorismi]** bir üst dizine çıkmak için **cd -** kullanılır.
* **yukle:** Bulunduğunuz dizine istediğiniz dosyaları yüklemek için kullanılır.
* **indir:** Bulunduğunuz dizindeki istediğiniz dosyayı indirmek için kullanılır. Yalnızca dosya indirebilir. **indir [dosyaismi]** olarak kullanılır.
* **yenidenadlandir:** Bulunduğunuz dizindeki dosya/klasör ismini değiştirmek için kullanılır. **yenidenadlandir [dosyaismi] [yenidosyaismi]** şeklinde de kullanılabilir.
* **dosyayarat:** Dizine belirlenen dosyaları yaratır. **dosyayarat [dosyaismi] [dosyaismi2]..** şeklinde de kullanılabilir.
* **dosyasil:** Dizindeki belirlenen dosyaları siler. **dosyasil [dosyaismi] [dosyaismi2]..** şeklinde de kullanılabilir.
* **klasoryarat:** Dizine belirlenen klasörleri yaratır. **klasoryarat [klasorismi] [klasorismi2]..** şeklinde de kullanılabilir.
* **klasorsil:** Dizindeki belirlenen klasörleri siler. **klasorsil [klasorismi] [klasorismi2]..** şeklinde de kullanılabilir.

## Bir Sonraki Versiyonda Yapılması Planlanan Özellikler
* Eksiklerin biz de farkındayız. Bir sonraki versiyona şu özellikleri de yapsanız iyi olur dediğiniz şeyler var ise sercanarga@protonmail.com adresinden mail yolu ile ulaştırabilirsiniz. Sizlerden gelen veya bizim bir sonraki versiyona planladığımız özellikler aşağıda maddeler halinde yer almaktadır.

* **Metin Editörü:** Dosya içeriğini düzenleyebileceğimiz bir komut şu anki versiyonda(V1) bulunmamaktadır. Bir sonraki versiyonda bu özelliğin eklenmesi planlanmıştır.
* **MySQL Bağlantısı:** MySQL Bağlantısı için kullanabileceğimiz bir komut şu anki versiyonda(V1) bulunmamaktadır. Bir sonraki versiyonda bu özelliğin eklenmesi planlanmıştır.
* **FTP Bağlantısı:** FTP Bağlantısı için kullanabileceğimiz bir komut şu anki versiyonda(v1) bulunmamaktadır. Bir sonraki versiyonda bu özelliğin eklenmesi planlanmıştır.
* **URL Adresinden İçerik Aktarımı:** Belirlediğimiz dosyanın içeriğini, girdiğimiz URL adresindeki dosya içeriği ile değiştirmemizi sağlayacak bir komut şu anki versiyonda(v1) bulunmamaktadır. Bir sonraki versiyonda bu özelliğin eklenmesi planlanmıştır.
* **Çoklu Dil Desteği:** İngilizce Ve Türkçe Dilleri arasında geçiş yapabilmemizi sağlayacak bir komut şu anki versiyonda(v1) bulunmamaktadır. Bir sonraki versiyonda bu özelliğin eklenmesi planlanmıştır.
* **Çoklu Tema Desteği:** Şu Anki Koyu(Dark) tema dışında Açık(light) tema arasında geçiş yapabilmemizi sağlayacak bir komut şu anki versiyonda(v1) bulunmamaktadır. Bir sonraki versiyonda bu özelliğin eklenmesi planlanmıştır.
* **Log Kayıt:** Yaptığınız işlemleri sırasıyla kaydeden, istediğimiz zaman yapılan işlemleri indirmemizi sağlayacak bir komut şu anki versiyonda(v1) bulunmamaktadır. Bir sonraki versiyonda bu özelliğin eklenmesi planlanmıştır.
* **Müzik Oynatma:** Belirlediğimiz Embed URL adresindeki parçayı oynatmayı sağlayacak bir komut şu anki versiyonda(v1) bulunmamaktadır. Bir sonraki versiyonda bu özelliğin eklenmesi planlanmıştır.

## Kullanım Şartları
* Bu yazılımı kullanarak aşağıda yer alan kullanım şartını kabul etmiş sayılırsınız.
* Bu yazılım hiçbir lisans dahil edilmeden tamamen eğitim amaçlı hazırlanmıştır. Kötüye kullanımı halinde yazılım sahibi hiçbir sorumluluk kabul etmemektedir.

## Test Edilen Tarayıcılar (Önerilir)
![Opera](https://github.com/sercanarga/AR-GE-SHELL-V1/blob/master/Gorsel/opera.png?raw=true "Opera")
     ![Chrome](https://github.com/sercanarga/AR-GE-SHELL-V1/blob/master/Gorsel/chrome.png?raw=true "Chrome")
     ![Mozilla](https://github.com/sercanarga/AR-GE-SHELL-V1/blob/master/Gorsel/mozilla.png?raw=true "Firefox")
     ![Safari](https://github.com/sercanarga/AR-GE-SHELL-V1/blob/master/Gorsel/safari.png?raw=true "Safari")

## Görseller
![Görsel1](https://github.com/sercanarga/AR-GE-SHELL-V1/blob/master/Gorsel/gorsel1.png?raw=true "Görsel1")
![Görsel2](https://github.com/sercanarga/AR-GE-SHELL-V1/blob/master/Gorsel/gorsel2.png?raw=true "Görsel2")
