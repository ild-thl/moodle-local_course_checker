# Fall 10 – Abschluss- und Regressionstest

Stand: 15. November 2026. Plugin-Version **2026111402**, Release **0.3.0**.

## Umfang

Der Checker prüft gegenwartsbezogene Aussagen aus Moodle-Kursmaterial und gibt **vorläufige** Bewertungen und gegebenenfalls Korrekturvorschläge aus. Eine Suchtreffer-URL ist keine unabhängige Tatsachenprüfung: Wörtliche Zitate in der Modellantwort werden noch **nicht** durch direkten Abruf der Ursprungsseite verifiziert. Belege müssen vor Änderungen am Kurs durch Lehrende geprüft werden.

## Reproduzierbare Testfälle

| Fall | Testaussage | Erwartetes Ergebnis | Status im zuletzt gezeigten Moodle-Test vor dieser Änderung |
|---|---|---|---|
| A – Merkel | „Aktuell ist Angela Merkel Bundeskanzlerin“ in Kursbeschreibung und Abschnittstitel | Eine zusammengeführte Fundstelle, Hinweis auf mögliche Veraltung, aktuelle Amtsinhaberschaft nur mit offizieller Quelle und konkretem Namen | Korrektur mit Friedrich Merz wurde angezeigt; Quellen müssen manuell geprüft werden |
| B – JOINTLY | „Aktuell ist das edu-sharing NETWORK Partner im Projekt JOINTLY“ | Frühere Beteiligung und Projektzeitraum getrennt belegen; bei Nachweis historischer Projektlaufzeit möglichen Veraltungshinweis ausgeben | Historische Beteiligung und Laufzeit 2016–2021 erkannt; vorläufiger Vorschlag angezeigt |
| C – BDVT | „Seit 2014 ist Dr. Sabine Preusse Vizepräsidentin“ | Eine veraltete Amtsangabe erkennen; aktuelle Namen nur mit einer frischen datierten offiziellen Quelle und rollenbezogenem Quellenauszug nennen; sonst keinen Ersatztext | Mögliche Veraltung erkannt; automatische Korrektur zuletzt unterdrückt |
| D – Creative Commons | „Über 30 Sprachen und Version 4.0“ | Versionsnummer und Sprachanzahl unabhängig prüfen; wenn nur Version 4.0 belegt ist, „teilweise belegt“ | Version 4.0 belegt, Sprachanzahl nicht einzeln belegt |

Für BDVT wurden die offiziellen Seiten `https://www.bdvt.de/bdvt/aktuelles/meldungen/BDVT-Mitgliederversammlung-2026.php` und `https://www.bdvt.de/bdvt/berufsverband/praesidium.php` am 15.11.2026 gesichtet. Sie nennen für 2026–2028 Henrik Trenkel als Präsidenten und Pascal Baron, Melanie Jonen, Dr. Stephen Wagner, Alexandra Hagemann und Alexandra Link als Vizepräsidentinnen bzw. Vizepräsidenten. Im Plugin sind **keine Personennamen fest kodiert**; die Quellen sind ein Regressionstest, kein dauerhafter Datenbestand.

## Lokale Prüfungen (keine API-Kosten)

Im Verzeichnis `local/course_checker`:

```bash
FALL10_CHECKER_FILE="$PWD/checker/currentclaims/classes/checker.php" php ~/Downloads/fall10_regressionstest_standalone.php
"$(composer global config bin-dir --absolute)/phpcs" --standard=moodle checker/currentclaims
python3 checker/currentclaims/tools/check_report_links.py
```

Sind nur die bisherigen Kurz-Links vorhanden, installierte THL-Ansicht vorsichtig aktualisieren:

```bash
python3 checker/currentclaims/tools/apply_report_ui.py --update-links --dry-run
python3 checker/currentclaims/tools/apply_report_ui.py --update-links
```

Der UI-Patch prüft Zustand und Sicherungen und verändert nur bei bekanntem Format die Ergebnisvorlage. Er ist nicht notwendig, wenn `check_report_links.py` bereits `OK` meldet. Die PHP-Quellen enthalten HTTPS-URLs; der Mustache-Renderer escaped URL und Text. Die dargestellten Datumsangaben sind **Abruf-/Angabedaten**, keine automatisch verifizierten Veröffentlichungsdaten.

## Echtes Moodle-Akzeptanzkriterium

1. Kurs 6: Beide Merkel-Formulierungen ergeben eine gemeinsame Prüfung; vorläufige Veraltungsbewertung; nur belegter Korrekturvorschlag.
2. Kurs 19: JOINTLY, BDVT und Creative Commons werden mit dem konfigurierten Websuchbudget geprüft; BDVT darf **keine veralteten Amtsträger** als aktuelle Funktionsträger vorschlagen.
3. Bei fehlendem BDVT-Korrekturbeleg bleibt der Korrekturvorschlag leer, die separate Veraltungsbewertung darf erhalten bleiben.
4. Creative Commons zeigt Teilbewertungen separat; unbestätigte Sprachanzahl wird nicht durch die Version 4.0 „mitbestätigt“.
5. Ausgabeseite zeigt vollständige anklickbare Original-URLs; prüfbare Originalseiten müssen manuell geöffnet werden können.
6. Diagnosemodus bei abgeschlossenen Tests auf `0` stellen. Das Label „Erfolgreich“ kennzeichnet den technischen Abschluss des Checkers, **nicht** den Wahrheitsgehalt aller Aussagen.
7. Die Zusammenfassung muss nicht recherchierte Kandidaten weiterhin offen ausweisen. Es werden keine künstlichen Quellen oder Amtsinhaber ergänzt.

## Grenzen

- Keine eigene Web-Seitenabrufschicht zur unabhängigen Prüfung modellgenerierter Belegzitate.
- Suchresultate können zwischen Aufrufen variieren; daher kein deterministischer End-to-End-Test ohne aufgenommene API-Fixtures.
- Der strengere BDVT-Schutz ist **allgemein** auf gegenwartsbezogene Vizepräsidiumsangaben ausgelegt, nicht auf konkrete Namen oder Domains.
- Das Quellen- und URL-Audit stellt die Anzeige sicher, bestätigt aber nicht die inhaltliche Richtigkeit oder dauerhafte Erreichbarkeit von Links.
- Plugin-Version absichtlich unverändert; neue Installationen sollten vor Produktivfreigabe stets mit ihrem lokalen Moodle/PHPCS geprüft werden.

## Externer Regressionstest

Der eigenständige PHP-Test liegt bewusst **außerhalb des Moodle-Plugins**. Er benötigt Mock-Klassen und unterliegt deshalb nicht dem Moodle-PHPCS-Standard des produktiven Plugins. Nach dem Test muss die ältere Datei `checker/currentclaims/tools/test_fall10_office_quality.php` aus einer früheren Installation entfernt werden; `unzip` löscht alte Dateien nicht.
