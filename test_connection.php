<?php
require_once 'config.php';

echo "<h2>Veritabanı Bağlantı Testi</h2>";

try {
    echo "<p style='color: green;'>✓ Veritabanı bağlantısı başarılı!</p>";
    
    // Mevcut veritabanlarını listele
    $sql = "SHOW DATABASES";
    $stmt = $conn->query($sql);
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h3>Mevcut Veritabanları:</h3>";
    foreach ($databases as $db) {
        echo "- " . $db . "<br>";
    }
    
    // project veritabanında tabloları listele
    echo "<h3>Project Veritabanındaki Tablolar:</h3>";
    $sql = "SHOW TABLES";
    $stmt = $conn->query($sql);
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "<p style='color: red;'>❌ Project veritabanında hiç tablo yok!</p>";
        echo "<p>Lütfen create_table.sql dosyasını çalıştırın.</p>";
    } else {
        foreach ($tables as $table) {
            echo "- " . $table . "<br>";
        }
        
        // PROJECT tablosunu kontrol et
        if (in_array('PROJECT', $tables)) {
            echo "<h3>PROJECT Tablosu Yapısı:</h3>";
            $sql = "DESCRIBE PROJECT";
            $stmt = $conn->query($sql);
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Sütun</th><th>Tip</th><th>Null</th><th>Key</th></tr>";
            foreach ($columns as $col) {
                echo "<tr>";
                echo "<td>" . $col['Field'] . "</td>";
                echo "<td>" . $col['Type'] . "</td>";
                echo "<td>" . $col['Null'] . "</td>";
                echo "<td>" . $col['Key'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'>❌ PROJECT tablosu bulunamadı!</p>";
        }
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>❌ Hata: " . $e->getMessage() . "</p>";
}
?>

<p><a href="index.php">Ana Sayfaya Dön</a></p>
