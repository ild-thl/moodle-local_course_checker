# Fall 10 – Gegenwartsbezogene Aussagen (Prototyp 0.3.0)

**Stand: 14.11.2026.** Prototyp zur menschlichen Aktualitätsprüfung von Moodle-Kursinhalten.

## Funktionsweise

- Regelbasierte Vorauswahl von Textstellen mit gegenwartsbezogenen Signalwörtern.
- KI-Extraktion überprüfbarer Behauptungen über GWDG oder MyLab, wie in v0.2.
- Optional externer Recherche-Anbieter: **Keine**, **OpenAI Web Search**.
- Mit OpenAI wird die Responses API `https://api.openai.com/v1/responses` verwendet: `web_search`, `tool_choice=required`, `max_tool_calls=1`, `store=false`; `filters.allowed_domains` nur bei ausgefüllter Domainliste.
- Die OpenAI-Recherche muss einen abgeschlossenen `web_search_call` enthalten. Die gezeigten Quellen stammen ausschließlich aus tatsächlichen `url_citation`-Annotationen und müssen entweder auf die optionale Admin-Allowlist passen oder bei leerer Liste eine öffentliche HTTPS-Domain haben. Eine Modellantwort oder eine frei behauptete URL allein zählt nicht als Quelle.
- Maximal 1 extern recherchierter KI-Prüffall pro Durchlauf in der Standardeinstellung (einstellbar 1–3). Weiteren Behauptungen wird keine externe Überprüfung attestiert.
- Die Ergebnisse sind Hinweise, **keine abschließende Verifikation**. Quellen stets manuell kontrollieren. Originalseiten werden vom Moodle-Plugin nicht selbst abgerufen.

## Installieren / Upgrade

1. ZIP im Wurzelordner `local/course_checker` entpacken, vorhandene `checker/currentclaims/` Dateien überschreiben.
2. Moodle Website-Administration / Benachrichtigungen öffnen; Subplugin-Upgrade auf Version `2026111402` durchführen.
3. **Gegenwartsbezogene Aussagen** konfigurieren. Die bestehenden GWDG-/MyLab-Schlüssel bleiben bestehen, wenn die Installation im gleichen Moodle-DB-Stand erfolgt.
4. `KI-Analyse und externe Suche aktivieren` muss bewusst aktiviert bleiben; die Werte `searchprovider=none` und `maxwebclaims=1` verhindern automatische externe Web-Kosten nach dem Upgrade.
5. Unter **Anbieter für externe Websuche** OpenAI auswählen; OpenAI API-Key als Administratoreinstellung setzen, das Modell `gpt-5.4-mini` belassen; optionale Domainliste prüfen (leer = Websuche ohne Domainbegrenzung).
6. Ein einziges öffentliches Beispiel als Testinhalt verwenden, CourseChecker erneut starten. API-Aufrufe kosten Geld; `max_tool_calls=1` limitiert die integrierten Tool-Aufrufe je Recherche, aber Modell-Tokens werden zusätzlich berechnet.
7. Codecheck: `$(composer global config bin-dir --absolute)/phpcs --standard=moodle checker/currentclaims` und `find checker/currentclaims -name '*.php' -exec php -l {} \;`.

## Hinweise zu Kosten und Datenschutz

- Ohne OpenAI API-Key / bei HTTP-Fehlern werden keine offenen Behauptungen als überprüft ausgegeben. Fehler werden angezeigt, nie der Schlüssel.
- Guthaben selbst und ausgeschaltetes Auto-Reload begrenzen zusätzliche Zahlungen, sind aber keine absolute Garantie gegen Verbrauchsüberhang; Limits und Kosten im OpenAI-Dashboard prüfen.
- Bereits ein Neustart des CourseCheckers kann erneut kostenpflichtige Recherche starten. Kein Cache in dieser Version.
- Bei OpenAI wird nur die **extrahierte Behauptung** und die von der KI vorgeschlagene Suchanfrage übertragen, nicht das gesamte Kursmaterial. An GWDG/MyLab werden ausgewählte Original-Kurstexte zur Extraktion gesendet.
- Für vertrauliche oder personenbezogene Kursinhalte erst nach Datenschutzfreigabe verwenden.
- Nur redaktionelle Kursinhalte, keine Nutzerbeiträge/H5P-Dateien/Quizfragen/PDFs.

## Korrekturvorschlag bei veralteten Aussagen

- Bei einer als möglicherweise veraltet eingestuften Aussage kann die Webrecherche einen **Korrekturvorschlag** samt zugehöriger Quelle zurückgeben.
- Der Vorschlag wird nur angezeigt, wenn die Quelle aus den vom Anbieter übermittelten, zulässigen Webquellen stammt.
- Die Korrektur ist ausdrücklich **KI-generiert und manuell anhand der Originalquelle zu prüfen**. Ein passender Quellenlink beweist allein nicht, dass der Ersatzsatz korrekt ist.
- Ohne hinreichende Quellenzuordnung oder bei Status »unklar« erscheint kein Ersatzsatz.
- Kein Datenbank-Upgrade vorgesehen; `version.php` bleibt auf `2026111402` / `0.3.0`.

## Bekannte Einschränkungen

- Signalwortbasierte Vorauswahl kann Aussagen übersehen.
- Web-Tool-Ergebnisse und Quellen-Zitate garantieren keine korrekte Interpretation oder Aktualität des Quellinhalts.
- Recherche synchron im Ad-hoc-Task mit bis zu 95 Sekunden Timeout je OpenAI-Anfrage; bei großen Kursen für spätere Version auf asynchrone Teilaufträge umstellen.
- Langfristig: dedizierte Quellen-Fetch-Schicht, robustere Aktualitätsbewertung, Kostenmonitoring, Cache und automatisierte Integrationstests.
- Copyright-Angabe vor Veröffentlichung teamintern prüfen.


### Auswahl und Hinweise (Fall 10a/10b)

Die relevanteren Kandidaten werden vor der begrenzten KI-Anfrage sortiert. Nach einer erfolgreichen KI-Antwort werden nur maximal vier hoch priorisierte, nicht verifizierte Kandidaten separat als manuelle Hinweise gezeigt. Die Zusammenfassung nennt die übrigen nicht KI-verifizierten Kandidaten. Ausgeblendete Kandidaten gelten **nicht** als geprüft. Das konfigurierte Websuchlimit bleibt unverändert.

## Optionale Referenz-Domains

- **Leer**: OpenAI darf Quellen aus dem gesamten Web liefern. Es gelten weiterhin HTTPS-Prüfung, Provider-Quellenbindung und die thematische Quellenprüfung. Eine fremde Domain ist nicht automatisch ein Beleg.
- **Ausgefüllt**: Nur Quellen aus diesen Domains und ihren Subdomains werden berücksichtigt. Bei OpenAI wird `filters.allowed_domains` gesetzt.
- **Bestehende Installationen**: Bereits gespeicherte Domains bleiben bei diesem Code-Update erhalten. Für unbeschränkte Suche das Feld in den Administratoreinstellungen vollständig leeren und speichern.
- Die Zahl externer Suchanfragen (`maxwebclaims`) und die notwendige manuelle Quellenkontrolle bleiben unverändert.

### Aktualisierende Korrektur von Amtsinhabern (Fall 10d)

Bei gegenwartsbezogenen Aussagen über Amtsträger soll die Webrecherche den
aktuellen Amtsinhaber aus offiziellen aktuellen Quellen ermitteln und die
Informationsabsicht des Kursinhalts erhalten. Rein historische Umformulierungen
(z. B. „war von ... bis ...“) werden für solche Aussagen nicht als vollständige
Korrektur übernommen. Bei unzureichenden Belegen bleibt der Korrekturvorschlag
leer. Die validierte Anbieter-Quellen-URL ist weiterhin Pflicht; die abschließende
fachliche Prüfung liegt bei den Lehrenden. Das Websuchlimit bleibt unverändert.

### Zielgerichtete Recherche und Quellenreihenfolge (Fall 10c, 15.11.2026)

- OpenAI erhält jetzt einen zum Aussage-Typ passenden Rechercheplan: Projektstatus und
  Konsortialpartner, aktuelle Amtsträger oder offizielle Versionsinformationen.
- Die OpenAI-Websuche nutzt `search_context_size=medium` statt `low`. Das kann die
  Kosten pro Recherche verändern; `max_tool_calls=1` und `maxwebclaims` bleiben erhalten.
- Statt der ersten drei Quellen werden bis zu 24 vom Anbieter gemeldete URLs zunächst
  auf Themenbezug geprüft. Danach werden höchstens drei Quellen bevorzugt, darunter
  vom Modell tatsächlich genannte Beleg- und Korrekturquellen.
- Diese Rangfolge ist **keine** automatische inhaltliche Prüfung der verlinkten
  Dokumente. Quellenzuordnung und manuelle Fachprüfung bleiben erforderlich.
- Ein dauerhaftes Quellen-Caching ist noch nicht enthalten, damit veraltete
  Cacheinhalte nicht fälschlich als aktuell gelten. Dafür wäre eine getrennte
  Cache-Konzeption inklusive Ablaufzeit und Revalidierung erforderlich.
- Keine Änderungen an Pluginversion, Datenbankstruktur oder Suchlimit.

### Prüfung von Projektpartnerschaften (Stand: November 2026)

Die OpenAI-Webrecherche fordert bei Projektpartnerschaften einen kurzen, der angegebenen
Quelle zugeordneten **BELEGAUSZUG**. Vor einer vorläufigen positiven oder veralteten
Bewertung kontrolliert die Software, ob dieser Text den konkreten Projektnamen,
die Organisation und einen Hinweis auf die Partnerbeziehung enthält. Bei einer
historisch beendeten Partnerschaft muss die Belegstelle außerdem eine Jahresangabe
enthalten. Allgemeine Seiten derselben Organisation ohne projektbezogene Hinweise
werden aus der Suchtrefferanzeige ausgeschlossen.

**Grenze:** Der Auszug stammt aus der Modellantwort. Die Software ruft keine beliebigen
Quellseiten ab und prüft das Zitat deshalb nicht wortgetreu gegen den Originalinhalt.
Daher bleiben die Ergebnisse ausdrücklich vorläufig und müssen vor Änderungen am
Kurs anhand der verlinkten Primärquelle manuell kontrolliert werden. Eine erfolglose
Recherche ist kein Nachweis, dass die Partnerschaft niemals bestanden hat.

Die Konfiguration für optionale Domains und das Websuchlimit bleiben erhalten.

### Getrennte Quellen für Projektpartnerschaft und Projektlaufzeit (15.11.2026)

Wenn eine Quelle den konkreten Partner im Projekt benennt und eine zweite Quelle
**dasselbe Projekt** mit einem abgeschlossenen Zeitraum dokumentiert, können
beide Belege gemeinsam für eine **vorläufige** Veraltungsbewertung verwendet
werden. Die Modellantwort nennt dazu `BELEGQUELLE` / `BELEGAUSZUG` für die
Partnerschaft und optional `ZEITQUELLE` / `ZEITAUSZUG` für den Projektzeitraum.
Beide URLs müssen zu tatsächlich vom Suchanbieter gemeldeten Quellen gehören.
Die Quellenpriorisierung erhält beide passenden Belege. Für eine daraus
abgeleitete historische Korrektur wird die zweite URL zusätzlich als
`KORREKTURQUELLE2` zugeordnet.

Die Software behandelt die Projektlaufzeit ausdrücklich **nicht** als Beleg
für eine lückenlose Partnerdauer. Ein Nachfolgeprojekt ohne eigenen Beleg darf
nicht als aktuelle Beteiligung ausgegeben werden. Nur abgelaufene Projektzeiträume
werden als abgeschlossene Zeiträume herangezogen. Fehlt ein erforderlicher
Beleg, bleibt der Status `unklar` und die Korrektur leer.

Die Belegauszüge werden weiterhin **nicht** durch das Plugin direkt von den
Originalseiten geladen; diese Stufe validiert Modellangaben und URLs, nicht den
Quellentext gegen die Originalwebseite. Abschließende manuelle Kontrolle bleibt
notwendig. `maxwebclaims`, Domaineinstellungen und die Plugin-Version bleiben
unverändert.

### Präzisere Projektquellensuche (15.11.2026)

- Eine gegenwartsbezogene Projektpartnerschaft löst jetzt eine gezielte Suchanweisung
  mit dem **konkreten Projektnamen und der in der Aussage genannten Organisation** aus.
- Wenn der Anbieter zusätzlich einen Suchauszug (`snippet`/`description`) liefert,
  wird dieser bei der Vorauswahl und Rangfolge berücksichtigt. Ein Projekt kann
  auf einer allgemeinen Startseite stehen, ohne im Titel oder der URL zu erscheinen.
- **Wichtig:** Ein Projektbegriff im Suchauszug macht eine URL nur zum *Kandidaten*.
  Für einen positiven/veralteten Befund gelten weiterhin die bestehenden Anforderungen
  an explizite Partner-, Zeit- und Quellenbelege; die Zitate werden nicht
  selbstständig gegen die Originalseiten geprüft.
- Falls die Websuche weiterhin nur fachfremde Webseiten liefert, bleibt das Ergebnis
  korrekt als `unklar` gekennzeichnet. Es werden keine Quellen erfunden und
  keine zusätzlichen Webtool-Aufrufe außerhalb des Suchlimits ausgeführt.
- Keine Änderung an Plugin-Version, API-Konfiguration oder Datenbank.

### Historische Projektbelege bei widersprüchlicher KI-Bewertung (15.11.2026)

Wenn die KI `STATUS: hinweis_aktuell` mit `ZEITBEZUG: historisch_belegt`
kombiniert, darf dies nicht als aktuell bestätigt werden. Der Checker kann
stattdessen **vorläufig** `hinweis_veraltet` ausgeben, aber ausschließlich,
wenn die Originalaussage ausdrücklich die Gegenwart behauptet, eine
zugeordnete Suchquelle die konkrete Organisation als Projektpartner benennt
und eine zugeordnete Suchquelle das **gleiche** Projekt mit einem bereits
abgeschlossenen Zeitraum belegt. Partner- und Zeitbeleg dürfen aus zwei
verschiedenen Quellen stammen.

Bei dieser eng begrenzten Fallkonstellation wird die Korrektur aus dem
normalisierten Kurssatz und den belegten Projektjahren erzeugt. Sie sagt nur,
dass die Organisation **am Projekt beteiligt war**, und nennt die
**Projektlaufzeit getrennt**. Es wird weder die gesamte Projektlaufzeit als
Partnerdauer ausgegeben noch ein Nachfolgeprojekt ohne eigenen Nachweis
angenommen. Für die Diagnose erscheint `HISTORICAL_RECLASSIFIED`.

Fehlen konkrete Partner- oder Zeitbelege, ist die Projektidentität unklar,
liegt das Projektende nicht vor dem aktuellen Jahr oder enthält die
Originalaussage keinen expliziten Gegenwartsbezug, bleibt es bei `unklar`
(`HISTORICAL_NOT_CURRENT` beziehungsweise dem bisherigen Belegfehler).
Die KI-Belegauszüge werden weiterhin nicht unabhängig vom Plugin gegen die
Originalwebseiten abgeglichen; die manuelle Kontrolle ist notwendig.


### Erweiterte Quellen-Diagnose (bei `diagnosticmode = 1`)

Bei `SOURCE_OR_TIME_BASIS` werden zusätzlich zu den bisherigen Ja/Nein-Werten
Quellenzahlen je Filterstufe (`provider_sources`, `topic_sources`, `project_sources`,
`selected_sources`), die Existenz der Modell-Belegfelder und die Zugehörigkeit der
Modell-Partner-URL zu jeder Filterstufe angezeigt. Die Diagnose gibt weder
Zugangsschlüssel noch Originaltexte noch konkrete interne Beleg-URLs aus.

Die Web-Antwort akzeptiert als Begründungsfeld `BEGRUENDUNG` oder `BEGRÜNDUNG`.
Diese Parser-Erweiterung ersetzt keinen fehlenden Partner- oder Zeitbeleg.

### Sinngleiche Aussagen und lesbare Ergebnisdarstellung (15.11.2026)

- Vorsichtige Deduplizierung **innerhalb eines Prüflaufs**: Gegenwartsadverbien
  (z. B. „aktuell“) und die Wortstellung „Ist X Bundeskanzler“/„X ist
  Bundeskanzler“ werden bei ansonsten identischer Aussage zusammengeführt.
  Alle Fundstellen und abweichenden Originalformulierungen bleiben erhalten.
- Unterschiedliche Personen, Ämter, Zeitangaben, Ortsbezüge und negierte oder
  historische Formulierungen werden nicht anhand allgemeiner Textähnlichkeit
  zusammengeführt. Ohne sichere Äquivalenz bleibt es bei getrennten Befunden.
- Bestehende Suche, Quellenprüfung und Websuchlimit bleiben unverändert;
  es gibt **keinen dauerhaften Cache** und keine Verwendung veralteter Ergebnisse.
- Für eine übersichtliche Ausgabe enthält der gespeicherte Meldungstext eine
  begrenzte, kodierte Struktur mit Anzeigedaten. Der bisherige Klartext bleibt als Fallback.
- Die Moodle-Ergebnisvorlage `templates/check_result.mustache` wird **nicht**
  automatisch überschrieben. Ein einmaliger, reversibler UI-Patch nutzt den
  bestehenden Mustache-Mechanismus des übergeordneten CourseCheckers:

  ```bash
  python3 checker/currentclaims/tools/apply_report_ui.py
  ```

  Das Skript prüft ein exaktes Template-Muster, erstellt vor Änderungen eine
  Sicherung `templates/check_result.mustache.before-currentclaims-ui.bak` und
  lässt andere Checker unangetastet. Falls das lokale Template abweicht,
  bricht es ab, statt eine unbekannte Vorlage zu überschreiben.
  Zum Rücksetzen:

  ```bash
  python3 checker/currentclaims/tools/apply_report_ui.py --restore
  ```

- Originalaussagen, KI-Texte und URLs werden in der neuen Vorlage ausschließlich
  mit Mustache `{{...}}` (HTML-Escaping) ausgegeben, nie als ungefiltertes HTML.
- Die Version `2026111402` und Release `0.3.0` bleiben erhalten.


## Strukturierte Ergebnisansicht (THL und FFHS)

Der Eltern-Checker speichert Resultate standardmäßig nur als Text. Die Erweiterung
übergibt die strukturierten Felder daher über eine begrenzte, Base64-kodierte
JSON-Markierung im gespeicherten Warnungstext. Der optionale Adapter im
Ergebnis-Exporter entfernt die Markierung vor der Anzeige und stellt die Felder
für `check_result.mustache` bereit. Alle Textwerte werden durch Mustache escaped;
Quellenlinks werden zusätzlich auf HTTPS beschränkt. Ohne den Adapter kann die
Markierung im Warnungstext sichtbar werden; daher zunächst den UI-Patch
aktivieren und anschließend einen neuen Check-Lauf ausführen.

    python3 checker/currentclaims/tools/apply_report_ui.py --dry-run
    python3 checker/currentclaims/tools/apply_report_ui.py

Vor einem Test den Moodle-Cache leeren. Ein Patch kann mit `--restore`
rückgängig gemacht werden, solange die beiden übergeordneten Dateien
nicht nachträglich verändert wurden. Die Originaldateien liegen unter
`*.before-currentclaims-v2.bak`. Die Plugin-Version bleibt 2026111402.


## Vollständige Quellenlinks / Diagnosemodus beenden

Wenn die strukturierte Ergebnisansicht bereits installiert wurde, kann sie
aktualisiert werden, ohne die beiden Originaldateien oder deren Sicherungen
neu zu erstellen:

    python3 checker/currentclaims/tools/apply_report_ui.py --update-links --dry-run
    python3 checker/currentclaims/tools/apply_report_ui.py --update-links

In `check_result.mustache` werden Quellentitel und die vollständige,
anklickbare HTTPS-URL getrennt angezeigt. Mustache escaped die Angaben;
der bestehende HTTPS-Filter bleibt unverändert. Bereits gespeicherte
strukturierte Berichte benötigen keinen neuen KI-Aufruf, die geänderte
Ansicht wird aber erst nach Cache-Leerung sichtbar.

Der Diagnosemodus ist eine Moodle-Konfiguration und wird durch das Entpacken
der ZIP nicht automatisch überschrieben. Nach der Entwicklung mit
`set_config('diagnosticmode', 0, 'coursechecker_currentclaims')` deaktivieren;
dann neue Prüfläufe erstellen, damit der Diagnosehinweis in neuen Ergebnissen
fehlt. Die Plugin-Version bleibt bei 2026111402.


## Teilbewertungen zusammengesetzter Aussagen (Qualitätsprüfung)

- Aussagen, die **Sprachanzahl und Versionsnummer** gleichzeitig nennen, werden
  vorsichtig in zwei überprüfbare Teilaussagen zerlegt. Jede Teilaussage braucht
  einen eigenen, der Websuche zugeordneten URL-Beleg und einen passenden kurzen
  Suchauszug. Eine bloße Versionsquelle belegt keine Sprachanzahl.
- Kann nur eine der beiden Angaben durch zugeordnete Suchbelege gestützt werden,
  lautet der Gesamtstatus **„Teilweise belegt / weitere Prüfung nötig“**.
  Ohne hinreichende Einzelbelege bleibt die Aussage „Nicht verifiziert / unklar“.
  Dieses Verfahren ist ein KI-gestützter Recherchehinweis und ersetzt keine
  unabhängige Prüfung des Originalseiteninhalts.
- Ein Korrekturvorschlag für gegenwartsbezogene Amtsfunktionen muss einen
  konkreten neuen Personennamen enthalten. Aussagen wie „andere Personen
  haben das Amt“ werden nicht als fertige Ersatzformulierung angezeigt.
- Die Kurszusammenfassung unterscheidet nun vorläufige Bewertungen, teilweise
  belegte und unklare Aussagen sowie nicht recherchierte Behauptungen.
- Bei einer bereits installierten strukturierten Ergebnisansicht die neue
  Darstellung der **Teilbewertungen** ohne Verlust bestehender Sicherungen
  aktivieren:

  ```bash
  python3 checker/currentclaims/tools/apply_report_ui.py --update-quality --dry-run
  python3 checker/currentclaims/tools/apply_report_ui.py --update-quality
  ```

  Anschließend Moodle-Caches leeren und Fall 10 erneut ausführen, um die
  zusätzlichen strukturierten Daten in den neuen Prüfergebnissen zu erhalten.
  Die bisherige Quelle-/Korrekturansicht und die Rücksetzfunktion bleiben erhalten.
  Version und Release bleiben bei `2026111402` / `0.3.0`.

## Qualitätsprüfung für zeitabhängige Aussagen (15.11.2026)

- Für gegenwartsbezogene Ämter fragt die Websuche ausdrücklich nach einer neuesten offiziellen Wahl oder Präsidiumsmitteilung und vergleicht sie mit älteren Übersichten.
- Bei der Auswahl der maximal drei angezeigten Quellen werden **explizit datierte Wahl-/Präsidiumsmeldungen desselben Herausgebers** höher gewichtet. Das ist nur ein Suchsignal und kein eigenständiger Nachweis über die tatsächlichen Amtsinhaber.
- Wenn eine neuere, datierte offizielle Meldung desselben Herausgebers in den ausgewählten Quellen liegt, wird ein Korrekturvorschlag, der ausschließlich eine ältere oder undatierte Seite zitiert, vorsichtshalber nicht übernommen. Die eigentliche Belegprüfung bleibt aktiv.
- Bei Creative-Commons-Aussagen mit einer Sprachanzahl und einer Version darf eine **explizite Textstelle** in einem vom Suchanbieter gelieferten Auszug der offiziellen Lizenzübersicht die Version 4.0 als Teilbeleg stützen, auch wenn die KI eine vollständige TEILBEFUNDE-Zeile ausgelassen hat. Die URL allein genügt nicht. Die Zahl der offiziellen Sprachfassungen bleibt davon unabhängig und wird nicht automatisch bestätigt.
- Recherchen bleiben vorläufig: Der Checker lädt die Originalseiten **nicht unabhängig zur Zitatprüfung** herunter. Veröffentlichungsdaten werden nur aus eindeutigen Suchmetadaten gelesen; das in der Oberfläche gezeigte Abrufdatum ist **kein** Veröffentlichungsdatum. Bei unzureichender Evidenz bleibt der Status unklar.
- Die Ausgabe- und Mustache-Vorlage bleiben unverändert. Die Versionsnummer bleibt `2026111402`, Release `0.3.0`.

### Abschlussprüfung: aktuelle Vizepräsidiums-Korrekturen (15.11.2026)

Bei **gegenwartsbezogenen Aussagen über Vizepräsidentinnen und Vizepräsidenten**
reicht ein beliebiger neuer Name in `KORREKTUR` nicht mehr. Die Modellantwort
muss ein neues Feld `KORREKTURAUSZUG` mit einem kurzen, quellenbezogenen Auszug
liefern. Dieser muss eine aktuell bekleidete Vizepräsidiumsrolle und mindestens
einen konkreten neuen Namen benennen. Die in `KORREKTURQUELLE` genannte URL muss
vom Suchanbieter geliefert worden sein und eine erkennbar aktuelle Wahl- oder
Präsidiumsmeldung betreffen. Die bisherige Prüfung gegen **neuere** offizielle
Wahlquellen bleibt bestehen. Alte oder undatierte Quellen sowie unbelegte
Korrekturformulierungen werden zurückgewiesen, **ohne** einen nachvollziehbaren
Veraltungshinweis zu entfernen.

Weder Name noch Institution werden fest kodiert. Diese Prüfung ist absichtlich
vorsichtig: Eine zulässige Modell-Belegstelle beweist ohne echten Abruf des
Originaltextes noch nicht, dass das Zitat korrekt ist. Der Ersatztext bleibt
KI-generiert und muss vor einer Kursänderung kontrolliert werden. Die übrigen
Prüfungen (Merkel, JOINTLY, Creative-Commons-Teilbewertung) bleiben unverändert.

Quellen in der Ergebnisansicht werden als HTTPS-Links ausgegeben. Im Feld
"Abruf/Angabe" steht der Recherchetag und **nicht** das Publikationsdatum.
Ein schreibgeschützter Anzeigen-Check ist enthalten:

```bash
python3 checker/currentclaims/tools/check_report_links.py
```

Die reproduzierbaren Szenarien und die Installationstests stehen in
`TESTPLAN_FALL10.md`; der isolierte BDVT-Regressionstest läuft mit
`php /Pfad/zum/externen/fall10_regressionstest_standalone.php` (mit `FALL10_CHECKER_FILE` auf die lokale `checker.php`).
Plugin-Version und Release bleiben **2026111402 / 0.3.0**.


### Quellenanzeige und Teilbelege

Identische vollständige Quell-URLs werden in der Ergebnisansicht nur einmal
angezeigt. Unterschiedliche Unterseiten derselben Domain bleiben getrennt und
erhalten bei fehlendem Seitentitel eine unterscheidbare Pfadbeschriftung.
Die anklickbare URL bleibt vollständig erhalten.

Für kombinierte Creative-Commons-Aussagen wird ein Teilbeleg zur Lizenzversion
auch dann berücksichtigt, wenn das Modell ihn nicht korrekt in `TEILBEFUNDE`
eingetragen hat, **sofern** ein konkreter Suchauszug einer offiziellen
Creative-Commons-Quelle ausdrücklich die passende Version und Lizenz nennt.
Ohne diesen Textauszug bleibt der Teil unbestätigt. Die Sprachanzahl wird
weiterhin separat geprüft.

### Lokale Offline-Replay-Tests (Fall 10)

Für die Diagnose nichtdeterministischer Webrecherchen kann ein Administrator die
standardmäßig deaktivierte Einstellung `replaycapture` **kurzzeitig** auf `1`
setzen. Nur abgeschlossene OpenAI-Webrecherchen erhalten dann eine private,
beschränkte JSON-Aufzeichnung in
`$CFG->dataroot/coursechecker_currentclaims_replay/`. Enthalten sind die
normalisierte Behauptung, vom Anbieter genannte Quellen und die strukturierte
KI-Antwort, **keine** HTTP-Header, API-Schlüssel oder vollständigen HTTP-Antworten.
Die Aufzeichnungen können Kursinhalte und Zitate enthalten: Nur Testkurse ohne
sensible Daten verwenden; niemals veröffentlichen oder in Git aufnehmen.

Ein separates Offline-Testpaket `fall10-testtools` (nicht Bestandteil dieses
Moodle-Subplugins) wiederholt mit diesen JSONs die PHP-Themenfilterung,
Quellenpriorisierung, Belegprüfung und Teilbewertungen ohne Webzugriff. Dadurch
lassen sich Unterschiede in KI-Antworten von Regressionen in der PHP-Logik
unterscheiden. Nach dem Test `replaycapture` auf `0` setzen und Aufzeichnungen
löschen. Die normale Bewertung und das konfigurierte Suchlimit bleiben unverändert.


## Direkte Weiterleitung zu Fundstellen (17.11.2026)

Die Ergebnisansicht wurde um direkte Links zu den betroffenen Kursinhalten erweitert. Dadurch müssen Lehrkräfte nicht mehr selbst nach den gefundenen Aussagen im Kurs suchen.

Für jede Fundstelle stehen zwei Möglichkeiten zur Verfügung:

- **Zur Fundstelle:** Öffnet den entsprechenden Kursinhalt.
- **Inhalt bearbeiten:** Öffnet direkt die zugehörige Bearbeitungsseite, sofern die erforderlichen Moodle-Berechtigungen vorhanden sind.

Wenn dieselbe Aussage an mehreren Stellen im Kurs vorkommt, werden alle Fundstellen einzeln mit ihren jeweiligen Links angezeigt.

Unterstützt werden Kursbeschreibungen, Kursabschnitte, Aktivitäten, Text- und Medienfelder, Buchkapitel und Lektionsseiten.

Die Links werden anhand der internen Moodle-IDs erzeugt. Hierfür sind keine zusätzlichen KI-Anfragen erforderlich. Die Kursinhalte werden weiterhin nicht automatisch verändert.

Die Plugin-Version und die bisherige KI-Logik bleiben unverändert.