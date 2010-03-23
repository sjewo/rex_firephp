h1. 1. Sicherheitshinweise

h3. Datensicherheit

Ist das Addon aktiviert und aktive ??fb()?? Aufrufe im Code, sind die damit verschickten Daten prinzipiell auch für Dritte sichtbar. Zwar werden diese in den ??X-FirePHP-Data?? Headern verschickt, und sind somit für normale Besucher einer Site unsichtbar, aber jedes Tools/Plugin zum Anzeigen von header Daten *wird* dies Daten anzeigen. User mit installierten Firebug sehen sie sowieso.

h3. Funktionsaufruf

Der FirePHP Aufruf ??fb()?? sollte möglichst nie ohne eine Absicherung gegen das Fehlen der Lib oder ein unbedachtes Deinstallieren des Addons verwendet werde. In den Kopfbereich jedes Templates, Moduls, Addons, oder wo auch immer ??fb()?? aufgerufen wird folgende Dummy Funktion einfügen:

bc. if (!function_exists('fb')) {
  function fb() {
    echo 'no FirePHP installed!';
  }
}

Ohne diese Dummy Funktion kann es zu erheblichen Schwierigkeiten und evtl. totaler Nichterreichbarkeit von frontend *und* backend führen falls die FirePHP Library nicht eingebunden und somit die Funktion ??fb()?? undefiniert ist. Sollte dieser Fall einmal eingetreten sein, dann müßen die ??fb()?? Aufrufe manuell aus der DB gelöscht werden.

 <hr />

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