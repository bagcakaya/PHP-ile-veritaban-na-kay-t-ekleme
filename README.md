# Kişi Kayıt Sistemi

Bu PHP projesi, kişi bilgilerini veritabanına kaydetmek ve görüntülemek için tasarlanmıştır.

## Özellikler

- Kişi bilgilerini form ile giriş
- Veritabanına otomatik kayıt
- Kayıtlı kişileri tablo halinde görüntüleme
- Modern ve kullanıcı dostu arayüz
- Türkçe karakter desteği

## Kurulum

1. **XAMPP/WAMP Kurulumu:**
   - XAMPP veya WAMP sunucusunu bilgisayarınıza kurun
   - Apache ve MySQL servislerini başlatın

2. **Veritabanı Kurulumu:**
   - phpMyAdmin'e gidin: `http://localhost/phpmyadmin`
   - `create_table.sql` dosyasını phpMyAdmin'de çalıştırın
   - Veya SQL komutlarını manuel olarak çalıştırın

3. **Dosyaları Yerleştirme:**
   - Proje dosyalarını `htdocs` klasörüne kopyalayın
   - Örnek: `C:\xampp\htdocs\php_project\`

4. **Erişim:**
   - Tarayıcınızda `http://localhost/php_project/` adresine gidin

## Dosya Yapısı

```
php_project/
├── index.php          # Ana sayfa (form ve tablo)
├── config.php         # Veritabanı bağlantı ayarları
├── create_table.sql   # Veritabanı tablosu oluşturma
└── README.md          # Bu dosya
```

## Veritabanı Yapısı

Tablo: `PROJECT`
- `ID_NUMARASI` - Otomatik artan benzersiz kimlik
- `ADI` - Kişinin adı
- `SOYADI` - Kişinin soyadı
- `TELEFON_NUMARASI` - Telefon numarası
- `ADRES` - Adres bilgisi
- `KAYIT_TARIHI` - Kayıt tarihi (otomatik)

## Güvenlik Özellikleri

- PDO kullanarak SQL injection koruması
- HTML özel karakterlerin güvenli çıktısı
- Prepared statements ile güvenli veri girişi

## Sorun Giderme

1. **Veritabanı Bağlantı Hatası:**
   - MySQL servisinin çalıştığından emin olun
   - `config.php` dosyasındaki bağlantı bilgilerini kontrol edin

2. **Türkçe Karakter Sorunu:**
   - Veritabanı karakter setinin `utf8mb4` olduğundan emin olun
   - PHP dosyalarının UTF-8 kodlamasında kaydedildiğini kontrol edin

3. **Dosya Bulunamadı Hatası:**
   - Dosyaların doğru klasörde olduğunu kontrol edin
   - Apache servisinin çalıştığından emin olun
