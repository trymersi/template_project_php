<?php
try {
    $conn = new PDO('mysql:host=localhost;dbname=db_inventory', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Periksa pengaturan yang ada
    $stmt = $conn->query('SELECT * FROM pengaturan');
    $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Data Pengaturan Yang Ada:</h2>";
    echo "<pre>";
    print_r($settings);
    echo "</pre>";
    
    // Jika belum ada data, tambahkan data default
    if (empty($settings)) {
        echo "<h2>Menambahkan Data Pengaturan Default:</h2>";
        
        $defaultSettings = [
            ['kode' => 'nama_situs', 'nilai' => 'Template Project PHP'],
            ['kode' => 'tagline', 'nilai' => 'Aplikasi Web Dengan Template EduAdmin'],
            ['kode' => 'deskripsi', 'nilai' => 'Template project PHP dengan MVC dan template EduAdmin'],
            ['kode' => 'email_admin', 'nilai' => 'admin@example.com'],
            ['kode' => 'alamat', 'nilai' => 'Jl. Contoh No. 123, Kota Contoh'],
            ['kode' => 'telepon', 'nilai' => '08123456789'],
            ['kode' => 'footer_text', 'nilai' => 'Copyright &copy; 2023. All rights reserved.'],
            ['kode' => 'logo_path', 'nilai' => 'assets/images/logo.png'],
            ['kode' => 'favicon_path', 'nilai' => 'assets/images/favicon.ico']
        ];
        
        $sql = "INSERT INTO pengaturan (kode, nilai) VALUES (:kode, :nilai)";
        $stmt = $conn->prepare($sql);
        
        foreach ($defaultSettings as $setting) {
            $stmt->execute([
                ':kode' => $setting['kode'],
                ':nilai' => $setting['nilai']
            ]);
            echo "Menambahkan pengaturan: " . $setting['kode'] . " = " . $setting['nilai'] . "<br>";
        }
        
        echo "<h2>Data Pengaturan Setelah Ditambahkan:</h2>";
        $stmt = $conn->query('SELECT * FROM pengaturan');
        $newSettings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        print_r($newSettings);
        echo "</pre>";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
} 