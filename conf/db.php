<?php
define ('DB_SERVER', '127.0.0.1');                                                          //Definiert [127.0.0.1] als DB_SERVER              
define ('DB_USER', 'ACC');                                                                  //Definiert [ACC] als DB_USER
define ('DB_PASSWORD', 'toor');                                                             //Definiert [toor] als DB_PASSWORD
define ('DB_DATABASE', 'wtc');                                                              //Definiert [wtf] als DB
$db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE,DB_USER,DB_PASSWORD);          //Speichert die Verbindung in der [$db] Variable
?>