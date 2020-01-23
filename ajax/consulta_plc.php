<?php
session_start();

require_once("../php/conexion.php");
require_once dirname(__FILE__) . '/../Phpmodbus/ModbusMaster.php';

$ip = "192.168.200.206";

// Create Modbus object
$modbus = new ModbusMaster($ip, "TCP");

try 
{
    $consulta = "call  consulta_detalle_plc ('$ip')";
    $resultado = mysqli_query( conectar(), $consulta );
    while ($columna = mysqli_fetch_array( $resultado ))
    {
        echo "<section class='w-25 cajaplc p-4 mr-4 d-flex flex-column justify-content-center align-items-center'>";
        if($columna['log_suma'] == 1)
        {
            try {
                $result = $modbus->readMultipleRegisters(0, $columna['direccion'], 1);
            } catch (Exception $e) {
                printf("Exception: %s\n", $e);
                return array();
            }
            /* split into 1 word (2 byte) chunks */
            $result = array_chunk($result, 2);
            /* word results */
            $r = array();
            for ($i = 0; $i < sizeof($result); $i++) {
                $r[$i + $columna['direccion']] = PhpType::bytes2unsignedInt($result[$i]);
            }
            printf((int)$r);


            // $recData = $modbus->readMultipleRegisters(0, $columna['direccion'], 1);
            // //$recData[1] = $recData[1] / 1000;
            // echo "<h1 class='tituloplc'>".$columna['nombre']."</h1></br>";
            // echo  "<h1 class='valorplc'>".$recData[1]."</h1>";
        }
        else
        {
            $recData = $modbus->readMultipleRegisters(0, $columna['direccion'], 1);
            echo "<h1 class='tituloplc'>".$columna['nombre']."</h1></br>";
            echo  "<h1 class='valorplc'>".$recData[1]."</h1>";
        }
        echo "</section>";
    }
    
}
catch (Exception $e) {
    // Print error information if any
    echo $modbus;
    echo $e;
    exit;
}

?>