<?php

date_default_timezone_set("Asia/Novosibirsk"); 
$delay = array(
    'time_for_order_taken' => 30,
    'time_from_order_taken' => 40,
    'time_from_items_taken' => 30,
    'time_from_chain_order_taken' => 30,
    'time_from_first_chain' => 30,
    'time_for_chain' => 20,
);

$mysqli = new mysqli("localhost", "partum_user", "PoS0SiXui1337", "partum_db");
$mysqli->set_charset("utf8");

function getSQLphone($phone)
{
    if(  preg_match( '/^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/', $phone,  $matches ) )
    {
        return '+' . $matches[1] . ' (' .$matches[2] . ') ' .$matches[3] . '-' . $matches[4] . '-'.$matches[5];
    }else exit("hack!");
}
    
function get_name_by_phone($phone,$mysqli)
{
    $phone = getSQLphone($phone);
    $sql = $mysqli->query("SELECT name FROM `users` WHERE phone='" . $phone. "'");
    return $sql->fetch_assoc()["name"];
}

function get_orders($mysqli)
{
    $sql = $mysqli->query("SELECT orders.*,users.organisation FROM `orders` INNER JOIN `users` ON orders.institution_id=users.id WHERE (`status`='to_do' OR `status`='order_taken') AND `delivery_time`>='".date("Y-m-d H:i:s")."'");
    //echo $mysqli->error;
    header('Content-Type: application/json');
    return json_encode($sql->fetch_all());
}

function get_order_by_phone($phone,$mysqli)
{
    $phone = getSQLphone($phone);
    //$sql = $mysqli->query("SELECT id FROM `users` WHERE phone='" . $phone. "'");

    //$sql = $mysqli->query("SELECT * FROM `orders` WHERE courier_id=".$sql->fetch_assoc()["id"]." ORDER BY id DESC LIMIT 1;");
    $sql = $mysqli->query("SELECT orders.* FROM `orders` INNER JOIN `users` ON orders.courier_id=users.id WHERE users.phone='".$phone."' ORDER BY id DESC LIMIT 1;");

    $order = $sql->fetch_assoc();
    
    if ($order['status'] == 'order_taken'
            &&
            (time() - strtotime($order['delivery_time'])) >= (60 * $delay['time_from_items_taken'])) {
            $order["late"] = 1;
    }
    else {
        $order["late"] = 0;
    }
    header('Content-Type: application/json');
    return json_encode($order);
}

if($_GET['e']=="orders")
{
    echo (get_orders($mysqli));
}
elseif($_GET['e']=="order")
{
    echo (get_order_by_phone($_GET['phone'],$mysqli));
}
else
{
    echo (get_name_by_phone($_GET['phone'],$mysqli));
}
?>