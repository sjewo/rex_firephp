h1. 1. Sicherheitshinweise

h3. 1.1 Allgemein

Ist das Addon aktiv und FirePHP Funktions-Aufrufe im Code, sind die damit verschickten Daten prinzipiell auch für Dritte sichtbar. Zwar werden diese in den @X-FirePHP-Data@ Headern verschickt, und sind somit für normale Besucher einer Site unsichtbar, aber jedes Tools/Plugin zum Anzeigen von header Daten *wird* dies Daten anzeigen. User mit installierten Firebug/FirePHP sehen sie sowieso.

h3. 1.2 Funktions-Aufrufe aus Backend-Seiten

FirePHP unterscheidet nicht ob die Aufrufe aus dem Frontend oder dem Backend kommen, d.h. auch Aufrufe aus dem Backend werden im Frontend ausgegeben.

h3. 1.3 SESSION Mode vs. PERMANENT Mode

* Im SESSION Mode ist Firephp nur aktiv, so lange der User im Backend eingeloggt ist. *Dieser Modus sollte aus Sicherheitsgründen bevorzugt verwendet werden*
* Im PERMANENT Mode werden die Daten immer und unabhängig von einer user Sesssion ausgegeben.


h3. 1.4 Funktionsaufruf absichern

Der FirePHP Aufruf @fb()@ sollte möglichst nie ohne eine Absicherung gegen das Fehlen der Lib oder ein unbedachtes Deinstallieren des Addons verwendet werde. In den Kopfbereich jedes Templates, Moduls, Addons, oder wo auch immer @fb()@ aufgerufen wird folgende Dummy Funktion einfügen. Ohne eine solche Dummy Funktion kann es zu erheblichen Schwierigkeiten und evtl. totaler Nichterreichbarkeit von frontend *und* backend führen falls die FirePHP Library nicht eingebunden und somit die Funktion @fb()@ undefiniert ist.

bc. // Dummy Funktion
if (!function_exists('fb')) {
  function fb() {
    echo 'no FirePHP installed!';
  }
}

h3. 1.5 Worst case beheben

Sollte der GAU dennoch mal eingetreten sein, dann sollte folgendes Forgehen die Funktionalität der Seite wiederherstellen:

# Falls das Addon aus dem Addon-Verzeichnis gelöscht wurde: Per FTP wieder ins Verzeichnis hochladen.
# Sofern das Backend dann immer noch nicht aufrufbar ist: Die Datei @..redaxo/include/addons.inc.php@ im Editor öffenen, und den Status von FirePHP auf "installiert" setzen, indem man folgende Zeilen (sofern nicht vorhanden) in den Bereich zwischen den @// --- DYN@ comments einfügen, bzw. falls noch vorhanden, deren Wert auf '1' setzen:

bc. // --- DYN
...
$REX['ADDON']['install']['firephp'] = '1';
$REX['ADDON']['status']['firephp'] = '1';
...
// --- /DYN

Sollte auch das nicht helfen, bleibt als ultima ratio nur noch die @fb()@ Aufrufe per PhpMyAdmin (o.ä.) manuell aus der DB zu löschen.

h1. 2. Anwendungsbeispiele

Quelle: "http://code.google.com/p/firephp/":http://code.google.com/p/firephp/

bc.. <?php

fb('Hello World'); /* Defaults to FirePHP::LOG */

fb('Log message'  ,FirePHP::LOG);
fb('Info message' ,FirePHP::INFO);
fb('Warn message' ,FirePHP::WARN);
fb('Error message',FirePHP::ERROR);

fb('Message with label','Label',FirePHP::LOG);

fb(array('key1'=>'val1',
         'key2'=>array(array('v1','v2'),'v3')),
   'TestArray',FirePHP::LOG);


function test($Arg1) {
  throw new Exception('Test Exception');
}
try {
  test(array('Hello'=>'World'));
} catch(Exception $e) {
  /* Log exception including stack trace & variables */
  fb($e);
}

fb(array('2 SQL queries took 0.06 seconds',array(
   array('SQL Statement','Time','Result'),
   array('SELECT * FROM Foo','0.02',array('row1','row2')),
   array('SELECT * FROM Bar','0.04',array('row1','row2'))
  )),FirePHP::TABLE);
?>

p. Ausgabe der Beispiele in der Konsole:

 <img src="http://www.firephp.org/images/Screenshots/Sample1a.png" />