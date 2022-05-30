<?php

    $option = (isset($_POST["option"])) ? $_POST["option"]: "";

    $startdate = (isset($_POST["startdate"])) ? $_POST["startdate"]: "";
    $enddate = (isset($_POST["enddate"])) ? $_POST["enddate"]: "";
    $room_type = (isset($_POST["room_type"])) ? intval($_POST["room_type"]): "";
    $admin_id = (isset($_POST["admin"])) ? intval($_POST["admin"]): "";

    


    switch($option) {

        case "getAvailability":
            
            $availability = new usersModel();
            $availability = $availability -> getAvailability($startdate, $enddate, $room_type);
            $data = array();
        
            while($result = $availability -> fetch(PDO::FETCH_ASSOC)) {
                $rows = array();
                $rows["reservation_id"] = $result["id"];
                $rows["rooms_type_id"] = $result["rooms_type_id"];
                $rows["startdate"] = $result["startdate"];
                $rows["enddate"] = $result["enddate"];
                $rows["num_of_rooms"] = $result["num_of_rooms"];
                $rows["num_of_reservations"] = $result["num_of_reservations"];
                $rows["available_rooms"] = $result["available_rooms"];
                $rows["delete"] = '<button type="button" id="btnDelete" data-id="'.$result["id"].'" class="btn btn-danger btn-xs delete">Eliminar</button>';
                $data[] = $rows;
            }
            if(empty($data)) {

                $message = "Hay disponibilidad";
                echo json_encode(array("status" => $message));
                exit();

            } else {
                $message = "Datos disponibles";
                echo json_encode(array("status" => $message, $data));
                exit();
            }
            
            
            break;
        
        case "insertReservation":

            $newReservation = new usersModel();      

            if ($newReservation -> insertReservation($room_type, $startdate, $enddate, $admin_id)) {

                $reservation_id = $newReservation -> getLastId();
                $reservation_id = $reservation_id -> fetch(PDO::FETCH_ASSOC);
                $reservation_id = intval($reservation_id["MAX(id)"]);
                
                if ($newReservation -> insertKeys($admin_id, $reservation_id)) {

                    $message = "Reservacion agregada correctamente";
                    echo json_encode(array("status" => $message));
                    exit();

                }
                else {
                    $message = "Un problema sucedio al insertar en la tabla reservation_user";
                    echo json_encode(array("status" => $message));
                    exit();
                }

            }
            else {

                $message = "No se pudo agregar la reservacion";
                echo json_encode(array("status" => $message));
                exit();

            }

            break;
        
        case "getReservations":
            $reservations = new usersModel();
            $reservations = $reservations -> getReservations();
            $data = array();
        
            while($result = $reservations -> fetch(PDO::FETCH_ASSOC)) {
                $rows = array();
                
                $rows["admin_id"] = $result["admin_id"];
                $rows["num_of_reservations"] = $result["num_of_reservations"];
                $rows["firstname"] = $result["firstname"];
                $rows["lastname"] = $result["lastname"];

                $data[] = $rows;
            }

            echo json_encode($data);
            exit();

            break;
    }
?>