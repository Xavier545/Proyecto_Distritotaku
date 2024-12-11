<?php
function sweetalert(){
    if(isset($alert) && $alert == true){
        echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...!',
                  text: 'El usuario ya existe',
                  })
              </script>";
      }else{
        echo "<script>
                Swal.fire({
                  icon: 'success',
                  title: 'Bien Hecho!',
                  text: 'Te has registrado correctamente',
                  })
              </script>";
  
              
      }
}?>