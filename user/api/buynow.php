<?php
    session_start();
    if (!isset($_SESSION['user_login'])) {
        header("location: ../index.php");
    }


    require_once 'connect_db.php';

    try {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $object = new stdClass();
            $amount = 0;
            $product = $_POST['product'];
            
            $username = $_SESSION['user_login'];

            $stmt = $db->prepare('SELECT id, price from sp_product order by id desc');
            if($stmt->execute()) {

                $queryproduct = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                     $items = array(
                         "id" => $id,
                         "price" => $price,
                     );
                     array_push( $queryproduct, $items );
                }

                for ($i = 0; $i < count($product); $i++) { 
                    for ($j = 0; $j < count($queryproduct); $j++) { 
                        if(intval($product[$i]['id']) == intval($queryproduct[$j]['id'])) {
                            $amount += intval($product[$i]['count']) * intval($queryproduct[$j]['price']);
                            $count = count($product);
                            break;
                        }
                    }
                }

                $shiping = 40 * $count;
                $vat = (($amount + $shiping) * 0.07);
                $netamount = $amount + $shiping + $vat;
                $transid = round(microtime(true) * 1000);
                $product = json_encode($product);
                $mil = time() * 1000;
                $updated_at = date("Y-m-d h:i:sa");


                $stmt = $db->prepare('INSERT INTO sp_transaction (transid, orderlist, amount, shipping, vat, netamount, operation, mil, updated_at, username) VALUES (?,?,?,?,?,?,?,?,?,?)');
                if($stmt->execute([
                    $transid, $product, $amount, $shiping, $vat, $netamount, 'PENDING', $mil, $updated_at, $username
                    ])) {
                        $object->RespCode = 200;
                        $object->RespMessage = 'success';
                        $object->Amount = new stdClass();
                        $object->Amount->Amount = $amount;
                        $object->Amount->Shipping = $shiping;
                        $object->Amount->Vat = $vat;
                        $object->Amount->Netamount = $netamount;
    
                        http_response_code(200);
                    }
                    else {
                        $object->RespCode = 300;
                        $object->Log = 0;
                        $object->RespMessage = 'bad : insert transaction fail';
                        http_response_code(300);
                    }
                }
                else {
                    $object->RespCode = 500;
                    $object->Log = 1;
                    $object->RespMessage = 'bad : cant get product';
                    http_response_code(500);
                }
                echo json_encode($object);
            }
            else {
                http_response_code(405);
            }
        } catch(PEOException $e) {
                http_response_code(500);
                echo $e->getMessage();
            }

?> 