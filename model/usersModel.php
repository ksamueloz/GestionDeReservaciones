<?php

    require_once "connection.php";

    class usersModel extends Connection {

        public function getAvailability($startdate, $enddate, $rooms_type_id) {

            $sql = "SELECT reservation.id AS 'id', rooms_type_id, startdate, enddate, rooms_type.nof AS 'num_of_rooms', COUNT(rooms_type_id) as 'num_of_reservations',
            (SELECT num_of_rooms - COUNT(rooms_type_id)) AS 'available_rooms'
            FROM reservation 
            INNER JOIN rooms_type ON reservation.rooms_type_id = rooms_type.id
            WHERE startdate = :startdate 
            AND enddate = :enddate
            AND rooms_type_id = :rooms_type_id
            GROUP BY reservation.rooms_type_id;";

            $stament = $this -> connect() -> prepare($sql);
            $stament -> bindParam(":startdate", $startdate);
            $stament -> bindParam(":enddate", $enddate);
            $stament -> bindParam(":rooms_type_id", $rooms_type_id);
            $stament -> execute();
            return $stament;

        }

        public function getLastId() {
            $sql = "SELECT MAX(id) FROM reservation;";

            $stament = $this -> connect() -> prepare($sql);
            $stament -> execute();

            return $stament;
        }

        public function insertReservation($rooms_type_id, $startdate, $enddate, $admin_id) {
            $sql = "INSERT INTO reservation (rooms_type_id, startdate, enddate, admin_id) 
            VALUES (:rooms_type_id, :startdate, :enddate, :admin_id);";

            $stament = $this -> connect() -> prepare($sql);

            $stament -> bindParam(":rooms_type_id", $rooms_type_id);
            $stament -> bindParam(":startdate", $startdate);
            $stament -> bindParam(":enddate", $enddate);
            $stament -> bindParam(":admin_id", $admin_id);
            
            $stament -> execute();
            $results = $stament -> rowCount();
                
            if($results > 0) {
                return true;
            }
            return false;
        }

        public function insertKeys($user_id, $reservation_id) {
            $sql = "INSERT INTO reservation_user (user_id, reservation_id) VALUES (:user_id, :reservation_id);";
            $stament = $this -> connect() -> prepare($sql);

            $stament -> bindParam(":user_id", $user_id);
            $stament -> bindParam(":reservation_id", $reservation_id);
            
            $stament -> execute();
            $results = $stament -> rowCount();
                
            if($results > 0) {
                return true;
            }
            return false;
        }

        public function getReservations() {
            $sql = "SELECT 
            reservation.admin_id, COUNT(reservation.id) as 'num_of_reservations', 
            user.firstname, user.lastname
            FROM user
            INNER JOIN reservation_user ON reservation_user.user_id = user.id
            INNER JOIN reservation ON reservation.id = reservation_user.reservation_id
            
            GROUP BY reservation.admin_id, user.firstname";

            $stament = $this -> connect() -> prepare($sql);
            $stament -> execute();

            return $stament;
        }
    }
?>