<?php

    session_start();
    require_once "model/connection.php";
    require_once "model/usersModel.php";
    require_once "controller/usersController.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba técnica - Novasec</title>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- My styles -->
    <link rel="stylesheet" href="view/assets/css/style.css">
</head>
<body>
    
    <div class="container">
        <div class="actions">
            <h1 class="title">Gestión de reservas</h1>
        </div>

        <div class="container-form">
            <form action="index.php" method="POST" id="reservationForm" class="form-control">
                <div class="form-group">
                    <label for="startdate">Fecha de inicio</label>
                    <input type="date" class="form-control" name="startdate" id="startdate" aria-describedby="startdate">
                </div>
                <div class="form-group">
                    <label for="enddate">Fecha de finalización</label>
                    <input type="date" class="form-control" name="enddate" id="enddate" aria-describedby="enddate">
                    <small id="enddateHelp" class="form-text text-muted">Recuerde: La fecha de finalización no debe ser menor a la de inicio.</small>
                </div>
                <div class="form-group">
                    <label for="room_type">Tipo de habitación</label>
                    <select id="room_type" name="room_type" class="form-control">
                        <option value="1">Simple - Single</option>
                        <option value="2">Double - Doble</option>
                        <option value="3">Shared - Compartida</option>
                    </select>
                </div>                
            </form>

            <button id="btnVerify" type="submit" class="btn btn-primary">Verificar disponibilidad</button>    
            
        </div>

        <div class="container-reservation-2">
            <div class="actions">
                <h1 class="title">Cantidad de reservaciones por administrador</h1>
            </div>
            <table id="table_reservation" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Id del administrador</th>
                        <th scope="col">Número de reservaciones</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido </th>     
                    </tr>
                </thead>
            </table>
        </div>

        <div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="reservationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reservationModalLabel">Hay disponibilidad - Agrega la reservación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                        <form method="POST" id="reservationForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label  class="form-label float-left">Fecha de inicio</label>
                                <input class="form-control" id="startReservation" name="newReservation" type="date" disabled>
                            </div>
                            <div class="mb-3">
                                <label  class="form-label float-left">Fecha de finalización</label>
                                <input class="form-control" id="endReservation" name="endReservation" type="date" disabled>
                            </div>
                            <div class="mb-3">
                                <label  class="form-label float-left">Tipo de habitación</label>
                                <select id="roomReservation" name="roomReservation" class="form-control" disabled>
                                    <option value="1">Single - Simple</option>
                                    <option value="2">Double - Doble</option>
                                    <option value="3">Shared - Compartida</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label  class="form-label float-left">Administrador que realizará la reserva</label>
                                <select id="admin" name="admin" class="form-control">
                                    <option value="1">Jhon Doe</option>
                                    <option value="2">Jane Jackson</option>
                                    <option value="3">Alex Smith</option>
                                    <option value="4">Johana Roll</option>
                                </select>
                            </div>
                        </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnRegisterReservation">Registrar nueva reservación</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Js - JQuery -->
    <script src="view/assets/js/jquery-3.6.0.min.js"></script>
    <!-- Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- My scripts -->
    <script src="view/assets/js/main.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Js DataTABLES-->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
</body>
</html>