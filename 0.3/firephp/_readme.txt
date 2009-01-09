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

<hr />

h1. FirePHP

FirePHP enables you to print to your "Firebug":http://getfirebug.com Console using a simple PHP function call.

h3. What makes FirePHP different?

All data is sent via a set of X-FirePHP-Data response headers. This means that the debugging data will not interfere with the content on your page. Thus FirePHP is ideally suited for AJAX development where clean JSON or XML responses are required.

h3. Requirements

PHP: 5 | Firefox: 2, 3 | Firebug: "1.05, 1.1, 1.2":http://getfirebug.com

h3. QuickStart

"http://www.firephp.org/Wiki/Main/QuickStart":http://www.firephp.org/Wiki/Main/QuickStart

h3. Feedback & Help

If you have any feedback or require assistance you can participate in our discussion group at "http://forum.firephp.org":http://forum.firephp.org