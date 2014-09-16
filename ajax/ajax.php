<?php
	if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
	   die();
	}

	$from = 'pablo@pablocarrillo.net';
	$subject = 'Mensaje de la página web';


	$name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
	$email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
	$message = isset($_POST["message"]) ? trim($_POST["message"]) : "";

	$response = '';
	$error = false;
	

	if (!$message){
		$error = true;
		$response = 'El campo de mensaje esta vacio..';
	}


	$pattern = "^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$^";
	if(!preg_match_all($pattern, $email, $out)) {
		$error = true;
		$response = 'Por favor, introduce un email valido.';
	}
	if (!$email){
		$error = true;
		$response = 'Por favor, introduce un email.';
	}

	if (!$name){
		$error = true;
		$response = 'Por favor, introduce un nombre.';
	}

	if (!$error){

 		$headers = "From: ".$name." <".$email.">\r\nReply-To: ".$from."";

		//send the email
		$sent = mail($from,$subject,$message,$headers); 
		
		if ($sent){
			$response = 'Mensaje enviado, muchas gracias.';
		}else{
			$response = 'El mensaje no ha sido enviado debido a un error interno, por favor, ponte en contacto a través de correo electrónico.';
		}
	}


	$data = array(
		'response' => $response,
		'error' => $error
	);

	header('Content-Type: application/json');

	echo json_encode($data);
?>