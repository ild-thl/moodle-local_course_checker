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
 * English language strings for the current-claims checker.
 *
 * @package    coursechecker_currentclaims
 * @copyright  2026 Technische Hochschule Lübeck
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['aierror'] = 'AI claim extraction failed or returned invalid JSON. Candidates are shown for manual review only.';
$string['aifinding'] = 'Locations: {$a->location}. | Original: "{$a->sentence}". | Claim: "{$a->claim}". ' .
    '| Preliminary assessment: {$a->status}. | Reason: {$a->reason}.';
$string['aimodel'] = 'AI model ID (optional)';
$string['aimodel_desc'] = 'Leave empty for GWDG deepseek-v4.1-flash-1017 or MyLab chat-fast. Adjust when model ' .
    'availability changes.';
$string['aiprovider'] = 'AI provider';
$string['aiprovider_desc'] = 'The selected model must be available from the provider.';
$string['aisummary'] = '{$a->total} distinct candidates; {$a->ai} extracted AI claims; {$a->searched} with allowlisted ' .
    'search hits. This is preliminary review, not definitive fact checking.';
$string['apikey_desc'] = 'Administrator API key. Do not add to source code or Git.';
$string['assessmentcounts'] = 'Provisional assessment states: {$a->assessed} assessed; {$a->partial} partly supported; ' .
    '{$a->unclear} unclear; {$a->notsearched} without web research.';
$string['configmissing'] = 'AI checking is enabled but provider, model or API key configuration is missing or invalid. ' .
    'Reverting to manual review.';
$string['correctionnotice'] = 'This wording is AI-generated. Check the cited original source before using it.';
$string['correctionproposal'] = 'Suggested correction';
$string['diagnosticlabel'] = 'Evidence diagnostics';
$string['diagnosticmode'] = 'Evidence diagnostic mode';
$string['diagnosticmode_desc'] = 'Enable temporarily for troubleshooting. ' .
    'Shows decision codes and yes/no checks in course results. ' .
    'No credentials or evidence excerpts. Disable after testing.';
$string['display_claim'] = 'Claim';
$string['display_location'] = 'Locations';
$string['display_original'] = 'Original text';
$string['display_parts'] = 'Individual checks';
$string['display_reason'] = 'Reason';
$string['display_status'] = 'Preliminary assessment';
$string['display_variants'] = 'Other wordings';
$string['enableai'] = 'Enable AI analysis and external search';
$string['enableai_desc'] = 'When enabled, selected editorial course text is sent to GWDG or MyLab. Extracted claims ' .
    'may be sent to OpenAI for web research. Obtain approval first.';
$string['evidencenotconfirmed'] = 'The external evidence is not clearly linked to the verdict, ' .
    'or temporal evidence is missing. No automatic confirmation.';
$string['findingmessage'] = 'Location: {$a->location}. Possible current claim: "{$a->sentence}". Verify manually against a ' .
    'reliable, dated external source.';
$string['findingtitle'] = 'Review currency of claim';
$string['gwdgapikey'] = 'GWDG API key';
$string['maxclaims'] = 'Maximum AI claims';
$string['maxclaims_desc'] = 'Only selected claims are checked by AI. Others are counted; ' .
    'a few high-priority ones are shown for manual review.';
$string['maxresults'] = 'Maximum candidate sentences';
$string['maxresults_desc'] = 'Collect at most this many distinct candidate sentences (1 to 100).';
$string['maxwebclaims'] = 'Maximum web-researched claims per check';
$string['maxwebclaims_desc'] = 'Research 1 to 3 extracted claims per course check. Default: 1. For OpenAI one built-in ' .
    'web tool call per claim is enforced.';
$string['mylabapikey'] = 'MyLab API key';
$string['nomatches'] = 'No candidate sentences with supported present-time markers found. Outdated statements may ' .
    'still be present.';
$string['noreason'] = 'Insufficient evidence in the returned snippets.';
$string['nosources'] = 'No allowlisted search hits available; the claim was NOT verified.';
$string['notsearchedconfig'] = 'Not checked: No enabled and validly configured web search provider is available.';
$string['notsearchedlimit'] = 'Not checked: The configured web research limit has been reached.';
$string['openaiapikey'] = 'OpenAI API key for web search';
$string['openaiwebmodel'] = 'OpenAI model for web search';
$string['openaiwebmodel_desc'] = 'Default: gpt-5.4-mini via OpenAI Responses API web_search.';
$string['pendingreview'] = 'Another {$a->total} candidates have not been verified by AI; ' .
    '{$a->shown} high-priority items are shown for manual review. ' .
    'Hidden candidates must not be treated as confirmed.';
$string['pluginname'] = 'Current claims';
$string['privacy:metadata'] = 'This subplugin does not separately store personal data. When enabled, selected editorial ' .
    'course texts are sent to the selected AI provider and derived search queries to a search ' .
    'service. Results are stored by the parent CourseChecker plugin.';
$string['privacy:metadata:ai_provider'] = 'Selected course texts are transmitted to the configured ' .
    'AI service when AI checking is enabled.';
$string['privacy:metadata:ai_provider:coursetext'] = 'Moodle editorial course text containing candidate current claims.';
$string['privacy:metadata:openai_search'] = 'With OpenAI web search enabled, extracted claims are sent to OpenAI Responses API.';
$string['privacy:metadata:openai_search:claim'] = 'Present-time factual claim and search query extracted from editorial course ' .
    'content.';
$string['researcherror'] = 'Web research failed; claim has not been verified';
$string['searchprovider'] = 'External web search provider';
$string['searchprovider_desc'] = 'None means AI extraction only, not fact checking. OpenAI uses the Responses API. Requests may cost money.';
$string['snippetnotice'] = 'This is based on search excerpts, not independently verified full source pages. Confirm ' .
    'sources and relevant dates manually.';
$string['sourcedate'] = 'Retrieved/recorded';
$string['sourcelabel'] = 'Search results:';
$string['sourcenotice'] = 'AI-assisted web research: please review the original sources and their dates manually.';
$string['status_hinweis_aktuell'] = 'AI indication of possibly current claim';
$string['status_hinweis_veraltet'] = 'AI indication of possibly outdated claim';
$string['status_teilweise'] = 'Partly supported / further review needed';
$string['status_unklar'] = 'Not verified / unclear';
$string['summary'] = '{$a} possible present-time claims collected for manual review. No automatic fact checking was performed.';
$string['trusteddomains'] = 'Trusted reference domains';
$string['trusteddomains_desc'] = 'Optional: one domain per line without https://, e.g. bundesregierung.de. ' .
    'Leave blank to allow public HTTPS sources from across the web. ' .
    'When populated, only these domains and their subdomains are permitted. ' .
    'Topic relevance checks remain enabled in both modes.';
