<?php
    session_start();
    include ('../../conexion.php');
    use PHPMailer\PHPMailer\PHPMailer;
    require '../../../vendor/autoload.php';

    $id_usuario = $_SESSION['id_user'];
    date_default_timezone_set("America/Santiago");
	$fecha = date("Y-m-d G:i:s");

    $consulta = "SELECT max(id_desviacion) as correlativo FROM desviaciones";
	$resultado = mysqli_query( conectar(), $consulta );
	if ($columna = mysqli_fetch_array( $resultado ))
	{ 
        $contador = $columna['correlativo'] + 1;
    }
    else
    {
        $contador = 1;
    }
    
    $query="INSERT INTO desviaciones (id_desviacion,fecha,id_area,id_producto,id_fase,id_personal,desviacion,id_estado,fec_registro,id_usuario_registro) values($contador,'$_POST[fecha0]',$_POST[area0],$_POST[producto0],$_POST[fase0],$_POST[detector0],'$_POST[desviacion0]',1,'$fecha',$id_usuario)";
    if (conectar()->query($query) === TRUE) 
    {
        //Crear una instancia de PHPMailer
        $mail = new PHPMailer();
        //Definir que vamos a usar SMTP
        $mail->IsSMTP();
        //Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
        // 0 = off (producción)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug  = 0;
        //Ahora definimos gmail como servidor que aloja nuestro SMTP
        $mail->Host       = 'smtp.gmail.com';
        //El puerto será el 587 ya que usamos encriptación TLS
        $mail->Port       = 465;
        //Definmos la seguridad como TLS
        $mail->SMTPSecure = 'ssl';
        //Tenemos que usar gmail autenticados, así que esto a TRUE
        $mail->SMTPAuth   = true;
        //Definimos la cuenta que vamos a usar. Dirección completa de la misma
        $mail->Username   = "cristianasenjotorres@gmail.com";
        //Introducimos nuestra contraseña de gmail
        $mail->Password   = "qkoemzfrnrnlxuto";
        //$mail->Password = "vnqrxxrxmplqhwct";
        //Definimos el remitente (dirección y, opcionalmente, nombre)
        $mail->SetFrom('cristianasenjotorres@gmail.com', 'Sistema Mantención');
        //Esta línea es por si queréis enviar copia a alguien (dirección y, opcionalmente, nombre)
        //$mail->AddReplyTo('replyto@correoquesea.com','El de la réplica');
        //Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
        $consulta = "CALL consulta_correos_area($_POST[area0])";
        $resultado = mysqli_query( conectar(), $consulta );
        while ($columna = mysqli_fetch_array( $resultado ))
        { 
            $mail->AddAddress($columna['email'], $columna['nombre']);
        }
        //Definimos el tema del email
        $mail->Subject = 'Sistema Mantención';
        //Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
        $mail->MsgHTML("<html> 
                            <head> 
                                <title>Sistema Mantención</title> 
                            </head> 
                            <body> 
                                <h1>Se registro una desviación a su departamento!</h1> 
                                <p> 
                                    <h2>N° AC: ".$contador."</h2> 
                                </p> 
                                <p> 
                                    <b>Descripción de la desviación:</b></br>
                                    <span>".$_POST['desviacion0']."</span>
                                </p> 
                                <p>
                                    Favor no responder este mensaje, Gracias!!.
                                </p>
                            </body> 
                        </html>");
        $mail->CharSet = 'UTF-8';
        if(!$mail->Send()) {
            $messages[] = "Desviación guardada satisfactoriamente.";
        } else {
            echo $mail->ErrorInfo;
        }  
    }

    else
    {
        $errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error(conectar());
    }
    

    if (isset($errors)){
			
    ?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong> 
                <?php
                    foreach ($errors as $error) {
                            echo $error;
                        }
                    ?>
        </div>
        <?php
        }
        if (isset($messages)){
            
            ?>
            <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>¡Bien hecho!</strong>
                    <?php
                        foreach ($messages as $message) {
                                echo $message;
                            }
                        ?>
            </div>
            <?php
        }
?>