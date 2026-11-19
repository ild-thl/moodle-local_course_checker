<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * German language strings for the current-claims checker.
 *
 * @package    coursechecker_currentclaims
 * @copyright  2026 Technische Hochschule Lübeck
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['aierror'] = 'Die KI-Extraktion ist fehlgeschlagen oder lieferte keine gültige JSON-Antwort. Kandidaten ' .
    'werden nur zur manuellen Prüfung angezeigt.';
$string['aifinding'] = 'Fundstellen: {$a->location}. | Original: "{$a->sentence}". | Aussage: "{$a->claim}". ' .
    '| Vorläufige Bewertung: {$a->status}. | Begründung: {$a->reason}.';
$string['aimodel'] = 'KI-Modell-ID (optional)';
$string['aimodel_desc'] = 'Leer bedeutet GWDG deepseek-v4.1-flash-1017 bzw. MyLab chat-fast. Bei Änderungen der ' .
    'Modellverfügbarkeit bitte anpassen.';
$string['aiprovider'] = 'KI-Anbieter';
$string['aiprovider_desc'] = 'Das ausgewählte Modell muss beim Anbieter zugänglich sein.';
$string['aisummary'] = '{$a->total} unterschiedliche Kandidatensätze; {$a->ai} KI-extrahierte Behauptungen; ' .
    '{$a->searched} davon mit gefilterten Websuchtreffern. Dies ist eine vorläufige, keine ' .
    'abschließende Faktenprüfung.';
$string['apikey_desc'] = 'Administrativer API-Schlüssel. Nicht in Code oder Git speichern.';
$string['assessmentcounts'] = 'Vorläufige Bewertungsstände: {$a->assessed} bewertet; {$a->partial} teilweise belegt; ' .
    '{$a->unclear} unklar; {$a->notsearched} ohne Webrecherche.';
$string['configmissing'] = 'Die KI-Prüfung ist aktiviert, aber KI-Anbieter, Modell oder API-Schlüssel ist nicht gültig ' .
    'konfiguriert. Es bleibt bei einer manuellen Prüfung.';
$string['correctionnotice'] = 'Diese Formulierung ist KI-generiert. Bitte vor der Übernahme die angegebene Originalquelle prüfen.';
$string['correctionproposal'] = 'Korrekturvorschlag';
$string['diagnosticlabel'] = 'Quellen-Diagnose';
$string['diagnosticmode'] = 'Diagnosemodus für Quellenprüfung';
$string['diagnosticmode_desc'] = 'Nur vorübergehend für Fehlersuche einschalten. ' .
    'Zeigt Entscheidungscodes und Ja/Nein-Prüfschritte im Kursergebnis. ' .
    'Keine Zugangsdaten oder Belegtexte. Nach dem Test wieder deaktivieren.';
$string['display_claim'] = 'Aussage';
$string['display_location'] = 'Fundstellen';
$string['display_original'] = 'Originaltext';
$string['display_parts'] = 'Teilbewertungen';
$string['display_reason'] = 'Begründung';
$string['display_status'] = 'Vorläufige Bewertung';
$string['display_variants'] = 'Weitere Formulierungen';
$string['enableai'] = 'KI-Analyse und externe Suche aktivieren';
$string['enableai_desc'] = 'Achtung: Redaktionelle Kurstexte werden an GWDG oder MyLab übertragen. Je nach ' .
    'Konfiguration werden extrahierte Behauptungen zur Webrecherche an OpenAI ' .
    'gesendet. Nur mit entsprechender Freigabe aktivieren.';
$string['evidencenotconfirmed'] = 'Die externe Quelle ist nicht eindeutig mit der Bewertung verknüpft ' .
    'oder der zeitliche Beleg fehlt. Keine automatische Bestätigung.';
$string['findingmessage'] = 'Fundstelle: {$a->location}. Mögliche gegenwartsbezogene Aussage: "{$a->sentence}". Bitte ' .
    'anhand einer zuverlässigen, datierten externen Quelle manuell überprüfen.';
$string['findingtitle'] = 'Aktualität der Aussage prüfen';
$string['gwdgapikey'] = 'GWDG API-Schlüssel';
$string['maxclaims'] = 'Maximale KI-Prüffälle';
$string['maxclaims_desc'] = 'Maximal ausgewählte Aussagen werden durch die KI analysiert. ' .
    'Weitere Kandidaten werden gezählt; nur wenige besonders relevante Kandidaten erscheinen als manuelle Hinweise.';
$string['maxresults'] = 'Maximale Anzahl Kandidatensätze';
$string['maxresults_desc'] = 'Maximal gesammelte unterschiedliche Kandidatensätze (1 bis 100).';
$string['maxwebclaims'] = 'Maximale Web-Recherchen pro Prüflauf';
$string['maxwebclaims_desc'] = '1 bis 3 extrahierte Aussagen pro Kursprüfung extern recherchieren; Standard: 1. Bei ' .
    'OpenAI ist zusätzlich ein Web-Tool-Aufruf pro Aussage begrenzt.';
$string['mylabapikey'] = 'MyLab API-Schlüssel';
$string['nomatches'] = 'Keine Kandidatensätze mit den unterstützten Gegenwarts-Signalwörtern gefunden. Es können ' .
    'trotzdem veraltete Aussagen vorhanden sein.';
$string['noreason'] = 'Kein ausreichend belastbarer Beleg aus den Suchauszügen.';
$string['nosources'] = 'Keine zugelassenen externen Suchtreffer; die Aussage wurde NICHT überprüft.';
$string['notsearchedconfig'] = 'Nicht geprüft: Es steht kein aktivierter und gültig konfigurierter Websuchanbieter zur Verfügung.';
$string['notsearchedlimit'] = 'Nicht geprüft: Das konfigurierte Limit für Web-Recherchen wurde erreicht.';
$string['openaiapikey'] = 'OpenAI API-Schlüssel für Websuche';
$string['openaiwebmodel'] = 'OpenAI-Modell für Websuche';
$string['openaiwebmodel_desc'] = 'Standard: gpt-5.4-mini; über die OpenAI Responses API mit web_search.';
$string['pendingreview'] = 'Weitere {$a->total} Kandidaten wurden nicht durch die KI verifiziert; ' .
    'davon {$a->shown} als besonders relevant zur manuellen Prüfung angezeigt. ' .
    'Nicht angezeigte Kandidaten sind keine bestätigten Aussagen.';
$string['pluginname'] = 'Gegenwartsbezogene Aussagen';
$string['privacy:metadata'] = 'Das Subplugin speichert keine eigenen personenbezogenen Daten. Bei aktivierter KI werden ' .
    'ausgewählte redaktionelle Kurstexte an einen konfigurierten KI-Anbieter und daraus abgeleitete ' .
    'Suchanfragen an einen Suchanbieter übertragen. Die Prüfergebnisse werden vom übergeordneten ' .
    'CourseChecker verwaltet.';
$string['privacy:metadata:ai_provider'] = 'Bei aktivierter KI-Analyse werden ausgewählte ' .
    'Kurstexte an den konfigurierten KI-Anbieter übermittelt.';
$string['privacy:metadata:ai_provider:coursetext'] = 'Moodle-Kurstexte mit möglichen zeitbezogenen Aussagen.';
$string['privacy:metadata:openai_search'] = 'Bei aktivierter OpenAI-Websuche werden extrahierte Aussagen an die OpenAI ' .
    'Responses API übertragen.';
$string['privacy:metadata:openai_search:claim'] = 'Aus dem Kurs extrahierte gegenwartsbezogene Tatsachenbehauptung und ' .
    'Suchanfrage.';
$string['researcherror'] = 'Web-Recherche fehlgeschlagen; Aussage nicht verifiziert';
$string['searchprovider'] = 'Anbieter für externe Websuche';
$string['searchprovider_desc'] = 'Keine Websuche bedeutet nur KI-Extraktion ohne Faktenbewertung. OpenAI verwendet die ' .
    'Responses API. Externe Anfragen kosten ggf. Geld.';
$string['snippetnotice'] = 'Die Bewertung beruht nur auf Suchauszügen, nicht auf vollständig geprüften Quelltexten. ' .
    'Quellen und Zeitbezug manuell kontrollieren.';
$string['sourcedate'] = 'Abruf/Angabe';
$string['sourcelabel'] = 'Gefundene Referenzen (Suchtreffer):';
$string['sourcenotice'] = 'KI-gestützte Recherche: Quelle und zeitliche Gültigkeit bitte manuell anhand der Originalseite prüfen.';
$string['status_hinweis_aktuell'] = 'KI-Hinweis auf mögliche Aktualität';
$string['status_hinweis_veraltet'] = 'KI-Hinweis auf mögliche Veraltung';
$string['status_teilweise'] = 'Teilweise belegt / weitere Prüfung nötig';
$string['status_unklar'] = 'Nicht verifiziert / unklar';
$string['summary'] = '{$a} mögliche gegenwartsbezogene Aussagen zur manuellen Prüfung gesammelt. Keine automatische Faktenprüfung.';
$string['trusteddomains'] = 'Zugelassene Referenz-Domains';
$string['trusteddomains_desc'] = 'Optional: Pro Zeile eine Domain ohne https://, z. B. bundesregierung.de. ' .
    'Leer lassen erlaubt öffentliche HTTPS-Quellen aus dem gesamten Web. ' .
    'Mit Einträgen werden nur diese Domains und ihre Subdomains berücksichtigt. ' .
    'Die thematische Quellenprüfung bleibt in beiden Fällen aktiv.';
