$(document).ready(function() {


    let table_reservation = $('#table_reservation').DataTable({
        "ajax": {
            "url": "http://localhost/novasec/index.php",
            "method": "POST",
            "data": { option: "getReservations" },
            "dataSrc": ""
        },
        "columns": [
            { "data": "admin_id" },
            { "data": "num_of_reservations" },
            { "data": "firstname" },
            { "data": "lastname" },
        ]
    });


    /* Llamado a las funciones. */
    checkAvailability();
    insertReservation();

});


/*
    Verificar la disponibilidad dada una fecha de inicio,
    fecha de finalización y un tipo de habitación.
*/
function checkAvailability() {

    $(document).on("click", "#btnVerify", function() {

        let startdate = $.trim($("#startdate").val());
        let enddate = $.trim($("#enddate").val());
        let room_type = $.trim($("#room_type").val());

        if (startdate === "" || enddate === "" || room_type === "") {
            emptyFieldsOr("No deje ningún campo sin llenar.");
        } else {
            if (startdate > enddate) {
                emptyFieldsOr("La fecha de inicio no puede ser mayor a la fecha de finalización.");
            } else {

                $.ajax({
                    url: "http://localhost/novasec/index.php",
                    method: "POST",
                    data: { startdate: startdate, enddate: enddate, room_type: room_type, option: "getAvailability" },
                    dataType: "JSON",
                    success: function(response) {
                        //console.log(response.status);

                        if (response.status === "Hay disponibilidad") {
                            $("#startReservation").val(startdate);
                            $("#endReservation").val(enddate);
                            $("#roomReservation").val(room_type);

                            $("#reservationModal").modal("show");

                            goodNews("Enhorabuena!", "No se encontraron habitaciones ocupadas en el rango de fecha y tipo de habitación seleccionados.");
	          
                        } else if (response.status === "Datos disponibles") {
                            // console.log(response[0][0]["available_rooms"]);

                            // response = $.parseJSON(response);
                            // console.table(response);
                            // Se convierte a entero el número de habitaciones disponibles.
                            let available_rooms = (response[0][0]["available_rooms"] - 0);
                            // console.log("Available: ", available_rooms, "Tipo: ", typeof(available_rooms))
                            if (available_rooms === 0) {
                                emptyFieldsOr("Lo sentimos, no hay habitaciones disponibles para el rango y tipo de habitación seleccionados.");
                            } else {
                                $("#startReservation").val(startdate);
                                $("#endReservation").val(enddate);
                                $("#roomReservation").val(room_type);
                                $("#reservationModal").modal("show");
	              goodNews("Enhorabuena!", ( "Hay: " + available_rooms + " habitación (es) disponibles para el rango de fechas y tipo de habitación seleccionados."));
                            }

                        }
                    },
                    errof: function(r) {
                        console.log("Se ha presentado un error:", r);
                    }
                });
            }
        }
    });

}


function insertReservation() {
    $(document).on("click", "#btnRegisterReservation", function() {

        let startReservation = $.trim($("#startReservation").val());
        let endReservation = $.trim($("#endReservation").val());
        let roomReservation = $.trim($("#roomReservation").val());
        let admin = $.trim($("#admin").val());

        if (startReservation === "" || endReservation === "" || roomReservation === "" || admin === "") {
            emptyFieldsOr("No deje ningún campo vacío.");
        } else {
            $.ajax({
                url: "http://localhost/novasec/index.php",
                method: "POST",
                data: { startdate: startReservation, enddate: endReservation, room_type: roomReservation, admin: admin, option: "insertReservation" },
                dataType: "JSON",
                success: function(response) {
                    console.table(response);

                    if (response.status === "Reservacion agregada correctamente") {
                        goodNews("Muy bien", "Agregaste una reservación correctamente.");
                        $("form").trigger("reset");
                        $("#reservationModal").modal("hide");
                        $('#table_reservation').DataTable().ajax.reload();
                    } else if (response.status === "Un problema sucedio al insertar en la tabla reservation_user") {
                        emptyFieldsOr("Un problema sucedió al insertar los datos en la tabla 'reservation_user'.");
                    } else if (response.status === "No se pudo agregar la reservacion") {
                        emptyFieldsOr("No se pudo agregar la reservación.");
                    }
                }
            });
        }
    });

}


/*
MENSAJES EMERGENTES
*/
function emptyFieldsOr(message) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: message
    })
}

function goodNews(title, msg) {
    Swal.fire({
        icon: 'success',
        title: title,
        text: msg
    });
}