# testlogin

Anwendung am Beispiel eines Loginbereichs für eine fiktive Webseite:
Umsetzung mittels objektorientierter Programmierung unter Anwendung des MVC-Patterns, inkl. Datenbankkommunikation und Testing

## Installation

1. Projekt in `C:/XAMPP/htdocs` kopieren

2. `composer update`

3. Unter `src/Classes/DatabaseModel.php` kann die Datenbankverbindung konfiguriert werden.

4. Apache- und Mysql-Server starten

5. Die Datenbank mittels [datenbankschema.sql](datenbankschema.sql) erstellen

6. Projekt kann über "http://localhost:8080/testseite/index.php" aufgerufen werden.
