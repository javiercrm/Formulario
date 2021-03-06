<?php

$mysql = mysqli_connect("localhost", "root", "", "pufosa");

$trabajos = mysqli_query($mysql, "select distinct Trabajo_ID, Funcion from trabajos");

$jefes = mysqli_query($mysql, "select distinct empleado_ID, Nombre, Apellido from empleados");

?>

<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Prueba de validación con JS</title>
	<link rel="stylesheet" href="styles.css">
	<script>
		
	function validar(){


 
		var nombre = document.getElementById('Nombre').value;
		var apellido = document.getElementById('Apellido').value;
		var usuario = document.getElementById('correo').value;

		var fecha = document.getElementById('FechaContrato').value;

		var ano = fecha.substr(0,4);
		var mes = fecha.substr(5,2);
		var dia = fecha.substr(8,2);


		var telefono = document.getElementById('telefono').value;
		var salario = parseFloat(document.getElementById('Salario').value);
		var contrasena = document.getElementById('contrasena').value;
		var repetirContrasena = document.getElementById('RepetirContrasena').value;

		var expregApellidoNombre = /[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,15}/;
		var expregUsuario = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[p]{1}[u]{1}[f]{1}[o]{1}[.]{1}[e]{1}[s]{1}/;
		var expregTelefono = /6|7 [0-9]{8}/;
		var expregContrasena = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,}/;

		var errores = 0;


		document.getElementById("MSGApellido").className = "MSG hide";
		document.getElementById("MSGNombre").className = "MSG hide";
		document.getElementById("MSGUsuario").className = "MSG hide";
		document.getElementById("MSGTelefono").className = "MSG hide";
		document.getElementById("MSGFecha").className = "MSG hide";
		document.getElementById("MSGSalario").className = "MSG hide";
		document.getElementById("MSGContrasena").className = "MSG hide";
		document.getElementById("MSGRepetirContrasena").className = "MSG hide";

		if(!expregApellidoNombre.test(apellido)){
			document.getElementById("MSGApellido").className = "MSG show";
			errores++;
		}

		if(!expregApellidoNombre.test(nombre)){
			document.getElementById("MSGNombre").className = "MSG show";
			errores++;
		}

		if(!expregUsuario.test(usuario)){
			document.getElementById("MSGUsuario").className = "MSG show";
			errores++;
		}

		if(!expregTelefono.test(telefono)){
			document.getElementById("MSGTelefono").className = "MSG show";
			errores++;
		}

		if(ano < 2000){
			document.getElementById("MSGFecha").className = "MSG show";
			errores++;
		}

		var fechaActual = new Date();
		var fechaComparar = new Date(ano, mes-1, dia);	

		if(fechaComparar > fechaActual){
			document.getElementById("MSGFecha").className = "MSG show";
			errores++;
		}

		if(salario < 858.55 || salario > 12000 || Number.isNaN(salario)){
			document.getElementById("MSGSalario").className = "MSG show";
			errores++;
		}

		if(!expregContrasena.test(contrasena)){
			document.getElementById("MSGContrasena").className = "MSG show";
			errores++;
		}

		if(repetirContrasena != contrasena){
			document.getElementById("MSGRepetirContrasena").className = "MSG show";
			errores++;
		}

		if(errores == 0){
			document.cookie = "Usuario="+usuario;
			document.cookie = "Contrasena="+contrasena;
			document.formulario1.submit();
		}
		
	}
 
	</script>
</head>
<body>
	<form id="formulario1" name="formulario1" action="login.html" onsubmit="return false">

		<p id="MSGApellido" class="MSG hide">Minimo 2 carateres y Maximo 15 y No se admiten Numeros</p>
		<label>Apellido (OBLIGATORIO)</label>
		<input type="text" id="Apellido" placeholder="Apellido">
		<br /><br />

		<p id="MSGNombre" class="MSG hide">Minimo 2 carateres y Maximo 15 y No se admiten Numeros</p>
		<label>Nombre (OBLIGATORIO)</label>
		<input type="text" id="Nombre" placeholder="Nombre">
		<br /><br />

		<p id="MSGUsuario" class="MSG hide">Email No Valido usuario@pufo.es</p>
		<label>Usuario (OBLIGATORIO)</label>
		<input id="correo" type="text" placeholder="correo@pufo.es">
		<br /><br />

		<label>Seleccione Trabajo (OPCIONAL)</label>
		<select id="Trabajo_ID">
			<?php
			while ($row = mysqli_fetch_array($trabajos)) {
				echo '<option value=' . $row['Trabajo_ID'] . '>' . strtoupper($row['Funcion']) . '</option>';
			}
			?>
		</select>
		<br /><br />

		<label>Seleccione Jefe (OPCIONAL)</label>
			<select class="form-control" id="Jefe_ID">
			<?php
			while ($row = mysqli_fetch_array($jefes)) {
				echo '<option value=' . $row['empleado_ID'] . '>' . strtoupper($row['Nombre']) . ' ' . strtoupper($row['Apellido']) . '</option>';
			}
			?>
		</select>
		<br /><br />

		<p id="MSGFecha" class="MSG hide">Fecha no valido Tiene que ser superior al año 1999 e inferior o igual a la fecha actual</p>
		<label>Fecha del contrato (OBLIGATORIO)</label>
		<input type="date" id="FechaContrato" placeholder="AAAA-MM-DD">
		<br /><br />

		<p id="MSGTelefono" class="MSG hide">Telefono no valido tiene que empezar por 6 o 7 y tener 9 numeros</p>
		<label>Telefono MoviL (OPCIONAL)</label>
		<input type="number" id="telefono" placeholder="xxxxxxxxx">
		<br /><br />

		<p id="MSGSalario" class="MSG hide">Minimo 858.55 y el Maximo 12000</p>
		<label>Salario (OBLIGATORIO)</label>
		<input type="text" id="Salario" placeholder="Salario">
		<br /><br />

		<p id="MSGContrasena" class="MSG hide">Minimo 8 caracteres, tine que contener Mayusculas, Minusculas, Numeros, Caracteres Especiales</p>
		<label>Contaseña (OBLIGATORIO)</label>
		<input type="password" id="contrasena">
		<br /><br />

		<p id="MSGRepetirContrasena" class="MSG hide">No Coincide</p>
		<label>Repetir Contraseña (OBLIGATORIO)</label>
		<input type="password" id="RepetirContrasena">
		<br /><br />
 
		<input type="submit" value="Submit" onclick="validar();">
 
	</form>
</body>
</html>