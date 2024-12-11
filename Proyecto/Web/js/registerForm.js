function registerForm(){
    $("#registerForm").on("submit", function (e) {
        e.preventDefault(); // Evitar recarga de página

        $.ajax({
            url: "register_handler.php",
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                const res = JSON.parse(response);
                if (res.status === "success") {
                    alert(res.message);
                    window.location.href = "login.html"; // Redirigir si es exitoso
                } else {
                    alert(res.message);
                }
            },
            error: function () {
                alert("Error en la conexión con el servidor.");
            }
        });
    });
}