-- PROJECT veritabanını oluştur (eğer yoksa)
CREATE DATABASE IF NOT EXISTS project CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- PROJECT veritabanını kullan
USE project;

-- PROJECT tablosunu oluştur
CREATE TABLE IF NOT EXISTS PROJECT (
    ID_NUMARASI INT AUTO_INCREMENT PRIMARY KEY,
    ADI VARCHAR(50) NOT NULL,
    SOYADI VARCHAR(50) NOT NULL,
    TELEFON_NUMARASI VARCHAR(20) NOT NULL,
    ADRES TEXT NOT NULL,
    KAYIT_TARIHI TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Örnek veriler ekle (isteğe bağlı)
INSERT INTO PROJECT (ADI, SOYADI, TELEFON_NUMARASI, ADRES) VALUES
('Ahmet', 'Yılmaz', '0532 123 45 67', 'İstanbul, Kadıköy'),
('Fatma', 'Demir', '0533 987 65 43', 'Ankara, Çankaya'),
('Mehmet', 'Kaya', '0534 555 44 33', 'İzmir, Konak');
