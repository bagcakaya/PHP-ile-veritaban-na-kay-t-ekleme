<?php
session_start();
require_once 'config.php';

// Form gönderildiğinde veritabanına kaydet
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adi = $_POST['adi'];
    $soyadi = $_POST['soyadi'];
    $telefon = $_POST['telefon'];
    $adres = $_POST['adres'];
    
    try {
        // Tablo yapısını kontrol et ve uygun sütun adlarını bul
        $sql = "DESCRIBE PROJECT";
        $stmt = $conn->query($sql);
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Sütun adlarını bul (büyük/küçük harf duyarlılığı için)
        $column_names = [];
        foreach ($columns as $column) {
            $lower_column = strtolower($column);
            if ($lower_column === 'adi' || $lower_column === 'ad') {
                $column_names['adi'] = $column;
            } elseif ($lower_column === 'soyadi' || $lower_column === 'soyad') {
                $column_names['soyadi'] = $column;
            } elseif ($lower_column === 'telefon_numarasi' || $lower_column === 'telefon') {
                $column_names['telefon'] = $column;
            } elseif ($lower_column === 'adres') {
                $column_names['adres'] = $column;
            }
        }
        
        // INSERT sorgusunu oluştur
        $sql = "INSERT INTO PROJECT (" . implode(', ', $column_names) . ") VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$adi, $soyadi, $telefon, $adres]);
        
        // Flash mesaj ve yönlendirme (PRG)
        $_SESSION['mesaj'] = 'Kayıt başarıyla eklendi!';
        $_SESSION['mesaj_tipi'] = 'success';
        header('Location: index.php');
        exit;
    } catch(PDOException $e) {
        $_SESSION['mesaj'] = 'Hata: ' . $e->getMessage();
        $_SESSION['mesaj_tipi'] = 'error';
        header('Location: index.php');
        exit;
    }
}

// Veritabanından kayıtları çek
try {
    // Önce tablo yapısını kontrol et
    $sql = "DESCRIBE PROJECT";
    $stmt = $conn->query($sql);
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // ID sütununu bul (muhtemelen id, ID, Id olabilir)
    $id_column = null;
    foreach ($columns as $column) {
        if (strtolower($column) === 'id' || strtolower($column) === 'id_numarasi') {
            $id_column = $column;
            break;
        }
    }
    
    // Eğer ID sütunu bulunamazsa, ORDER BY kullanmadan çek
    if ($id_column) {
        $sql = "SELECT * FROM PROJECT ORDER BY $id_column DESC";
    } else {
        $sql = "SELECT * FROM PROJECT";
    }
    
    $stmt = $conn->query($sql);
    $kayitlar = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $kayitlar = [];
    $mesaj = "Veri çekme hatası: " . $e->getMessage();
    $mesaj_tipi = "error";
}

// Flash mesajı oturumdan al ve tek seferlik göster
if (isset($_SESSION['mesaj'])) {
    $mesaj = $_SESSION['mesaj'];
    $mesaj_tipi = $_SESSION['mesaj_tipi'] ?? 'success';
    unset($_SESSION['mesaj'], $_SESSION['mesaj_tipi']);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kişi Kayıt Sistemi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-container {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        textarea {
            height: 80px;
            resize: vertical;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .mesaj {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kişi Kayıt Sistemi</h1>
        
        <?php if (isset($mesaj)): ?>
            <div class="mesaj <?php echo $mesaj_tipi; ?>">
                <?php echo $mesaj; ?>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <h2>Yeni Kişi Ekle</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="adi">Adı:</label>
                    <input type="text" id="adi" name="adi" required>
                </div>
                
                <div class="form-group">
                    <label for="soyadi">Soyadı:</label>
                    <input type="text" id="soyadi" name="soyadi" required>
                </div>
                
                <div class="form-group">
                    <label for="telefon">Telefon Numarası:</label>
                    <input type="text" id="telefon" name="telefon" required>
                </div>
                
                <div class="form-group">
                    <label for="adres">Adres:</label>
                    <textarea id="adres" name="adres" required></textarea>
                </div>
                
                <button type="submit">Kaydet</button>
            </form>
        </div>
        
        <h2>Kayıtlı Kişiler</h2>
        <table>
            <thead>
                <tr>
                    <?php if (!empty($kayitlar)): ?>
                        <?php foreach (array_keys($kayitlar[0]) as $header): ?>
                            <th><?php echo strtoupper(str_replace('_', ' ', $header)); ?></th>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <th>ID NUMARASI</th>
                        <th>ADI</th>
                        <th>SOYADI</th>
                        <th>TELEFON NUMARASI</th>
                        <th>ADRES</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($kayitlar)): ?>
                    <?php foreach ($kayitlar as $kayit): ?>
                        <tr>
                            <?php foreach ($kayit as $value): ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Henüz kayıt bulunmamaktadır.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
