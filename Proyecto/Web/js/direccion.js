function validarFormulario() {
    const direccion = document.getElementById("direccion").value;
    const ciudad = document.getElementById("ciudad").value;
    const codigoPostal = document.getElementById("codigoPostal").value;

    // Validación básica
    if (direccion === "" || ciudad === "" || codigoPostal === "") {
        alert("Por favor, completa todos los campos.");
        return false;
    }

    // Validar que el código postal sea un número
    const regexCodigoPostal = /^\d{5}$/; // Ejemplo para códigos postales de 5 dígitos
    if (!regexCodigoPostal.test(codigoPostal)) {
        alert("El código postal debe ser un número de 5 dígitos.");
        return false;
    }

    // Si todo está bien
    alert("Dirección válida.");
    return true;
}