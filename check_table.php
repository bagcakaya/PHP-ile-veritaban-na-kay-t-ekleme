<?php
require_once 'config.php';

echo "<h2>Veritabanı Tablo Yapısı</h2>";

try {
    // Mevcut tabloları listele
    $sql = "SHOW TABLES";
    $stmt = $conn->query($sql);
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h3>Mevcut Tablolar:</h3>";
    foreach ($tables as $table) {
        echo "- " . $table . "<br>";
    }
    
    if (in_array('PROJECT', $tables)) {
        echo "<h3>PROJECT Tablosu Sütunları:</h3>";
        
        // PROJECT tablosunun yapısını göster
        $sql = "DESCRIBE PROJECT";
        $stmt = $conn->query($sql);
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Sütun Adı</th><th>Tip</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . $column['Field'] . "</td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . $column['Key'] . "</td>";
            echo "<td>" . $column['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Örnek veri göster
        echo "<h3>Örnek Veriler:</h3>";
        $sql = "SELECT * FROM PROJECT LIMIT 5";
        $stmt = $conn->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($data)) {
            echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
            $headers = array_keys($data[0]);
            echo "<tr>";
            foreach ($headers as $header) {
                echo "<th>" . $header . "</th>";
            }
            echo "</tr>";
            
            foreach ($data as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Tabloda veri bulunamadı.";
        }
        
    } else {
        echo "<p style='color: red;'>PROJECT tablosu bulunamadı!</p>";
        echo "<p>Lütfen önce create_table.sql dosyasını çalıştırın.</p>";
    }
    
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
