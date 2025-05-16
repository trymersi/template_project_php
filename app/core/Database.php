<?php
namespace core;

/**
 * Database Class
 * 
 * Class untuk menangani koneksi dan operasi database
 * Menggunakan PDO untuk keamanan dan fleksibilitas
 */
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $dbh; // database handler
    private $stmt;
    private $error;
    
    /**
     * Constructor
     * Buat koneksi database menggunakan PDO
     */
    public function __construct()
    {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8mb4';
        
        // Set options PDO
        $options = [
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false
        ];
        
        // Buat instance PDO
        try {
            $this->dbh = new \PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            echo 'Database Error: ' . $this->error;
        }
    }
    
    /**
     * Prepare statement dengan query
     * 
     * @param string $sql SQL query
     * @return void
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }
    
    /**
     * Bind nilai ke prepared statement
     * 
     * @param string $param Parameter dalam statement
     * @param mixed $value Nilai yang akan di-bind
     * @param mixed $type Tipe data (opsional)
     * @return void
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }
        
        $this->stmt->bindValue($param, $value, $type);
    }
    
    /**
     * Execute prepared statement
     * 
     * @return bool True jika berhasil, false jika gagal
     */
    public function execute()
    {
        return $this->stmt->execute();
    }
    
    /**
     * Ambil semua hasil query sebagai array asosiatif
     * 
     * @return array Hasil query
     */
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }
    
    /**
     * Ambil satu baris hasil query
     * 
     * @return array Satu baris hasil query
     */
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch();
    }
    
    /**
     * Hitung jumlah baris yang terpengaruh oleh query
     * 
     * @return int Jumlah baris
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
    
    /**
     * Get last insert ID
     * 
     * @return int ID dari baris terakhir yang diinsert
     */
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }
    
    /**
     * Begin transaction
     * 
     * @return bool True jika berhasil, false jika gagal
     */
    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }
    
    /**
     * Commit transaction
     * 
     * @return bool True jika berhasil, false jika gagal
     */
    public function commit()
    {
        return $this->dbh->commit();
    }
    
    /**
     * Rollback transaction
     * 
     * @return bool True jika berhasil, false jika gagal
     */
    public function rollBack()
    {
        return $this->dbh->rollBack();
    }
} 