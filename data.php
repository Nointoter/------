<?php
header('Content-Type: application/json');

// Подключение к базе данных
$dsn = 'mysql:host=localhost;dbname=pharmacy;charset=utf8';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Подключение не удалось: ' . $e->getMessage()]);
    exit;
}

// Функции для получения данных
function getSalesByProduct($pdo, $startDate, $endDate) {
    $sql = "
        SELECT 
            ds.idpos AS product_code,
            t.shortname AS product_name,
            SUM(ds.kol) AS total_quantity,
            SUM(ds.summa_sale - ds.discount) AS total_retail_sum
        FROM 
            dok_sost ds
        JOIN 
            tovar t ON ds.idpos = t.idpos
        JOIN 
            dok d ON ds.id_ndok = d.id_ndok
        WHERE 
            d.dd BETWEEN :start_date AND :end_date
        GROUP BY 
            ds.idpos, t.shortname
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':start_date' => $startDate,
        ':end_date' => $endDate,
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSalesByGroupAndDay($pdo, $groupId) {
    $sql = "
        SELECT 
            a.name AS pharmacy_name,
            d.dd AS sale_date,
            SUM(ds.kol) AS total_quantity,
            SUM(ds.summa) AS total_cost_sum,
            SUM(ds.summa_sale) AS total_retail_sum,
            SUM(ds.discount) AS total_discount
        FROM 
            dok_sost ds
        JOIN 
            dok d ON ds.id_ndok = d.id_ndok
        JOIN 
            apt a ON d.apteka = a.idapt
        JOIN 
            dbsgroupkeys gk ON ds.idpos = gk.id_line
        WHERE 
            gk.id_gr = :group_id
        GROUP BY 
            a.name, d.dd
        ORDER BY 
            a.name, d.dd
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':group_id' => $groupId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMarkupByPharmacyAndGroup($pdo) {
    $sql = "
        SELECT 
            a.name AS pharmacy_name,
            g.name_gr AS group_name,
            SUM(ds.summa_sale - ds.discount - ds.summa) / SUM(ds.summa) AS markup
        FROM 
            dok_sost ds
        JOIN 
            dok d ON ds.id_ndok = d.id_ndok
        JOIN 
            apt a ON d.apteka = a.idapt
        JOIN 
            dbsgroupkeys gk ON ds.idpos = gk.id_line
        JOIN 
            dbsgroups g ON gk.id_gr = g.id_gr
        GROUP BY 
            a.name, g.name_gr
    ";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Обработка запросов
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'salesByProduct':
        $startDate = '2024-01-01'; // Укажите дату начала
        $endDate = '2024-01-31';   // Укажите дату окончания
        $data = getSalesByProduct($pdo, $startDate, $endDate);
        break;

    case 'salesByGroup':
        $groupId = 10; // Укажите идентификатор группы
        $data = getSalesByGroupAndDay($pdo, $groupId);
        break;

    case 'markupByPharmacy':
        $data = getMarkupByPharmacyAndGroup($pdo);
        break;

    default:
        $data = ['error' => 'Неизвестное действие'];
}

echo json_encode($data);
