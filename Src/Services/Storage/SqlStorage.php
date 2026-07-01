<?php
namespace ViaCep\Src\Services\Storage;

use PDO;
use PDOException;

class SqlStorage implements StorageProvider
{
    private ?PDO $pdo = null;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'] ?? null;
        $db   = $_ENV['DB_DATABASE'] ?? null;
        $user = $_ENV['DB_USERNAME'] ?? null;
        $pass = $_ENV['DB_PASSWORD'] ?? null;
        $driver = $_ENV['DB_DRIVER'] ?? 'mysql';

        if ($host && $db) {
            try {
                $dsn = "$driver:host=$host;dbname=$db;charset=utf8mb4";
                $this->pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                // PDO driver not available or connection failed, fallback will be used
                $this->pdo = null;
            }
        }
    }

    public function save(string $zipCode, array $data): bool
    {
        $sql = "INSERT INTO ceps (zip_code, place, neighborhood, city, state, created_at) " .
               "VALUES (:zipCode, :place, :neighborhood, :city, :state, NOW()) " .
               "ON DUPLICATE KEY UPDATE place = :place, neighborhood = :neighborhood, city = :city, state = :state;";

        if ($this->pdo) {
            try {
                $stmt = $this->pdo->prepare($sql);
                return $stmt->execute([
                    ':zipCode' => $zipCode,
                    ':place' => $data['place'] ?? '',
                    ':neighborhood' => $data['neighborhood'] ?? '',
                    ':city' => $data['city'] ?? '',
                    ':state' => $data['state'] ?? '',
                ]);
            } catch (PDOException $e) {
                // Connection or query error, fall through to fallback
            }
        }

        // Fallback: Registrar no log/dump de desenvolvimento
        $sqlDir = __DIR__ . "/../../../Sql";
        if (!is_dir($sqlDir)) {
            mkdir($sqlDir, 0777, true);
        }
        $fallbackFile = $sqlDir . "/saved_ceps.sql";
        $insertQuery = sprintf(
            "INSERT INTO ceps (zip_code, place, neighborhood, city, state, created_at) VALUES ('%s', '%s', '%s', '%s', '%s', NOW());\n",
            addslashes($zipCode),
            addslashes($data['place'] ?? ''),
            addslashes($data['neighborhood'] ?? ''),
            addslashes($data['city'] ?? ''),
            addslashes($data['state'] ?? '')
        );
        file_put_contents($fallbackFile, $insertQuery, FILE_APPEND);
        return true;
    }
}
