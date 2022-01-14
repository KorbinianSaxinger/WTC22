<!DOCTYPE html>                                                         <!-- HTML Template von VSC -->
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCommerce Agentur Hamburg</title>                            <!-- Selber Anzeigename wie https://www.webconia.de --> 
    <link rel="stylesheet" href="includes/index.css">                   <!-- Stylesheet für die index.php -->
</head>
<body>   
<?php 
    include("includes/header.php");                                     //Header eingebunden (header includes nav)
    include("conf/db.php");                                             //DB-Config eingebunden (connection + variable für abfragen im code)
        echo"<div id='bghc'></div>";                                    //Leeres div für das Hintergrundbild (hafencity)

        //↓↓↓ HTML in PHP (  echo"<'HTML'>";  wollte PHP nicht mehrfach öffnen und schließen) ↓↓↓    
        echo"                                                           
            <h1>HERZLICH WILLKOMMEN BEI WEBCONIA</h1>                   
    <div class='anmeldung'>
                    <h2>Diesjährige webconia Technology Conference</h2>
                    <br>
                    <p>
                    Wir möchten sie als Kunde zur diesjährigen
                    webconia Technology Conference einladen,<br>
                    um daran teil zu nehmen, müssten Sie bitte dieses Anmeldeformular ausfüllen.
                    </p>
                    <br>

                    <h2>Anmeldung zur WTC2022</h2>
                    <p>Ihre Daten dienen lediglich zur Planung der Terminfreigabe.</p>";   
        //↑↑↑ Überschrift, WTC Ankündigung + Überschrift,info Anmeldung zur WTC2022 ↑↑↑            

        if(isset($_POST['absenden'])){                                  //Folgender Code wird ausgeführt wenn absenden gedrückt wird
            $vorname = $_POST['vorname'];                               //Text aus Eingabefeldern in Variablen speichern 
            $nachname = $_POST['nachname']; 
            $email = $_POST['email']; 
            $firma = $_POST['firma']; 

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {                                //Überprüfen ob email dem Schema xx@xx.xx entspricht
                echo"<fieldset id='fset1'>Bitte eine gültige E-mail eingeben.</fieldset>";  //Fehlermeldung wenn nicht ↑↑
            }else{                                                                          //Code geht weiter wenn doch ↑↑

                if($vorname != "" && $nachname != "" && $email != "" && $firma != ""){      //wenn jedes Feld ausgefüllt ist folgenden Code ausführen
                    
                    $statement = $db->prepare("SELECT * FROM anmeldungen2022 WHERE email = ?");   //SQL-Abfrage ob E-Mail schon in DB vorhanden
                    $statement->execute(array($email));                                           //E-Mail aus Eingabefeld zum prüfen nutzen
                    $mailVorhanden = $statement->rowCount();                                      //Anzahl gefundener Einträge in variable speichern
                    if($mailVorhanden >=1){                                                       //Wenn E-Mail schon vorhanden Fehler!!
                        echo "<fieldset id='fset1'>E-Mail schon vorhanden.</fieldset>";           //Fehlermeldung
                    }else if($mailVorhanden ==0){                                                 //Wenn kein Eintrag mit der E-Mail vorhanden Code weiter ausführen            
                        try {                                                                     //versuche Code auszuführen
                        $sql = "INSERT INTO anmeldungen2022 VALUES(:id,:vorname,:nachname,:email,:firma)";  //SQL-Befehl Eingegebene Daten in Datenbank übertragen
                        $run = $db->prepare($sql);                                                          //SQL-Befehl vorbereiten
                        $run->execute([                                                                     //SQL-Befehl ausführen mit Values aus Eingabefeldern(gespeicherte variablen)
                            ':id' => 0,
                            ':vorname' => $vorname,
                            ':nachname' => $nachname,
                            ':email' => $email,
                            ':firma' => $firma
                            ]);  
                            echo "<fieldset id='fset2'>Vielen Dank für die Teilnahme $vorname</fieldset>";  //Wenn alles geklappt hat Positive mitteilung                  
                        }catch (PDOException $e) {                                                          //Wenn nicht weird eine Fehlermeldung mit dem entsprechenden Fehler angezeigt
                            print "Error!: " . $e->getMessage() . "<br/>";
                            die();
                        }
                    
                }}else{
                        echo"<fieldset id='fset1'>Bitte alle Felder ausfüllen.</fieldset>";                 //Wenn nicht alle Felder mindestens 2 und email mindestens 5 Buchstaben haben FEHLER!!!
                    }}
        }       
        //↓↓↓ Form mit Eingabefeldern wieder HTML in PHP
        echo"<div id='bg2'></div>
        <fieldset id='fset0'>
            <legend>Anmeldung</legend>
                <form method='post'>    
                    Vorname: <br>
                        <input type='text' name='vorname' minlength='2' placeholder='Vorname'><br>
                    Nachname: <br>
                        <input type='text' name='nachname' minlength='2' placeholder='Nachname'><br>
                    E-mail: <br>
                        <input type='text' name='email' minlength='5' placeholder='E-Mail'><br>
                    Firma: <br>
                        <input type='text' name='firma' minlength='2' placeholder='Firma'><br><br>
                        <input type='submit' name='absenden' placeholder='Absenden'><br>
                </form>
        </fieldset>
    </div>";
        //↑↑↑ Eingabe Vorname, Nachname, E-mail, Firma  mit Placeholder und minlength

    $statement = $db->prepare("SELECT * FROM anmeldungen2022");                                         //Extra SQL-Abfrage um die Anzahl der Anmeldungen zu zählen
    $statement->execute(array());                                                           
    $mailVorhanden = $statement->rowCount();
    if($mailVorhanden == 0){                                                                            
        echo "<fieldset id='fsetCount'>Es sind keine Personen angemeldet.</fieldset>";                  //Ausgabe wenn  0 Einträge vorhanden
    }
    if($mailVorhanden == 1){
        echo "<fieldset id='fsetCount'>Es ist schon eine Person angemeldet.</fieldset>";                //Ausgabe wenn 1 Eintrag vorhanden
    }
    if($mailVorhanden > 1){
        echo "<fieldset id='fsetCount'>Es sind schon $mailVorhanden Personen angemeldet.</fieldset>";   //Ausgabe wenn mehr als 1 Eintrag gefunden
        }

        include("includes/footer.php");                                                                 //Einbinden footer(Bild Anzahl: Jahre, Erfahrung, Projekte)
?>
</body>
</html>

