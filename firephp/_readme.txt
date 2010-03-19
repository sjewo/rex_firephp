h1. Sicherheitshinweise

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