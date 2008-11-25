h1. FirePHP Addon v0.3

FirePHP enables you to print to your "Firebug":http://getfirebug.com Console using a simple PHP function call.

h4. What makes FirePHP different?

All data is sent via a set of X-FirePHP-Data response headers. This means that the debugging data will not interfere with the content on your page. Thus FirePHP is ideally suited for AJAX development where clean JSON or XML responses are required.

h4. Requirements

PHP: 5 | Firefox: 2, 3 | Firebug: "1.05, 1.1, 1.2":http://getfirebug.com

h4. QuickStart

"http://www.firephp.org/Wiki/Main/QuickStart":http://www.firephp.org/Wiki/Main/QuickStart

h4. Feedback & Help

If you have any feedback or require assistance you can participate in our discussion group at "http://forum.firephp.org":http://forum.firephp.org

<hr />

h3. Sicherheitshinweis zum Funktionsaufruf

Der FirePHP Aufruf ??fb()?? sollte möglichst nie ohne eine Absicherung gegen das Fehlen der Lib oder ein unbedachtes Deinstallieren des Addons verwendet werde. In den Kopfbereich jedes Templates, Moduls, Addons, oder wo auch immer ??fb()?? aufgerufen wird folgende Dummy Funktion einfügen:

bc. if (!function_exists('fb')) {
	function fb() {
		echo 'no FirePHP installed!';
	}
}

*Ohne* diese Dummy Funktion kann es - je nach Kontext in welchem der ??fb()?? Aufruf steht - zu erheblichen Schwierigkeiten und evtl. totaler Nichterreichbarkeit von frontend *und* backend führen. Sollte dieser Fall einmal eingetreten sein, dann müßen die ??fb()?? Aufrufe manuell aus der DB gelöscht werden.

<hr />

Addon Hilfe | "Addon Changelog":?page=addon&amp;spage=help&amp;addonname=firephp&amp;mode=changelog | "FirePHP Lib Changelog":?page=addon&amp;spage=help&amp;addonname=firephp&amp;mode=libchangelog | "FirePHP Readme":?page=addon&amp;spage=help&amp;addonname=firephp&amp;mode=libreadme | "FirePHP License":?page=addon&amp;spage=help&amp;addonname=firephp&amp;mode=liblicense 