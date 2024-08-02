<?php
require_once 'connect_db.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $object = new stdClass();
        
        // Prepare SQL statement to fetch product weights
        $stmt = $db->prepare('SELECT id, weight FROM sp_product ORDER BY id DESC');

        if ($stmt->execute()) {
            $object->Result = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $object->Result[$row['id']] = $row['weight']; // Map product ID to weight
            }
            $object->RespCode = 200;
            $object->RespMessage = 'Success';
            http_response_code(200);
        } else {
            $object->RespCode = 500;
            $object->RespMessage = 'SQL execution error';
            http_response_code(500);
        }

        echo json_encode($object);
    } else {
        http_response_code(405);
        echo json_encode(['RespCode' => 405, 'RespMessage' => 'Method Not Allowed']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['RespCode' => 500, 'RespMessage' => $e->getMessage()]);
}
?>