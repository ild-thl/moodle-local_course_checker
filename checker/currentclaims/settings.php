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
 * Configuration for the current-claims checker.
 *
 * @package    coursechecker_currentclaims
 * @copyright  2026 Technische Hochschule Lübeck
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings->add(new admin_setting_configtext(
        'coursechecker_currentclaims/maxresults',
        get_string('maxresults', 'coursechecker_currentclaims'),
        get_string('maxresults_desc', 'coursechecker_currentclaims'),
        25,
        PARAM_INT
    ));
    $settings->add(new admin_setting_configcheckbox(
        'coursechecker_currentclaims/enableai',
        get_string('enableai', 'coursechecker_currentclaims'),
        get_string('enableai_desc', 'coursechecker_currentclaims'),
        0
    ));
    $settings->add(new admin_setting_configtext(
        'coursechecker_currentclaims/maxclaims',
        get_string('maxclaims', 'coursechecker_currentclaims'),
        get_string('maxclaims_desc', 'coursechecker_currentclaims'),
        3,
        PARAM_INT
    ));
    $settings->add(new admin_setting_configselect(
        'coursechecker_currentclaims/aiprovider',
        get_string('aiprovider', 'coursechecker_currentclaims'),
        get_string('aiprovider_desc', 'coursechecker_currentclaims'),
        'gwdg',
        ['gwdg' => 'GWDG AcademicCloud', 'mylab' => 'TH Lübeck MyLab']
    ));
    $settings->add(new admin_setting_configtext(
        'coursechecker_currentclaims/aimodel',
        get_string('aimodel', 'coursechecker_currentclaims'),
        get_string('aimodel_desc', 'coursechecker_currentclaims'),
        '',
        PARAM_TEXT
    ));
    $settings->add(new admin_setting_configpasswordunmask(
        'coursechecker_currentclaims/gwdgapikey',
        get_string('gwdgapikey', 'coursechecker_currentclaims'),
        get_string('apikey_desc', 'coursechecker_currentclaims'),
        ''
    ));
    $settings->add(new admin_setting_configpasswordunmask(
        'coursechecker_currentclaims/mylabapikey',
        get_string('mylabapikey', 'coursechecker_currentclaims'),
        get_string('apikey_desc', 'coursechecker_currentclaims'),
        ''
    ));
    $settings->add(new admin_setting_configselect(
        'coursechecker_currentclaims/searchprovider',
        get_string('searchprovider', 'coursechecker_currentclaims'),
        get_string('searchprovider_desc', 'coursechecker_currentclaims'),
        'none',
        ['none' => 'Keine Websuche', 'openai' => 'OpenAI Web Search']
    ));
    $settings->add(new admin_setting_configtext(
        'coursechecker_currentclaims/maxwebclaims',
        get_string('maxwebclaims', 'coursechecker_currentclaims'),
        get_string('maxwebclaims_desc', 'coursechecker_currentclaims'),
        1,
        PARAM_INT
    ));
    $settings->add(new admin_setting_configpasswordunmask(
        'coursechecker_currentclaims/openaiapikey',
        get_string('openaiapikey', 'coursechecker_currentclaims'),
        get_string('apikey_desc', 'coursechecker_currentclaims'),
        ''
    ));
    $settings->add(new admin_setting_configtext(
        'coursechecker_currentclaims/openaiwebmodel',
        get_string('openaiwebmodel', 'coursechecker_currentclaims'),
        get_string('openaiwebmodel_desc', 'coursechecker_currentclaims'),
        'gpt-5.4-mini',
        PARAM_TEXT
    ));
    $settings->add(new admin_setting_configcheckbox(
        'coursechecker_currentclaims/diagnosticmode',
        get_string('diagnosticmode', 'coursechecker_currentclaims'),
        get_string('diagnosticmode_desc', 'coursechecker_currentclaims'),
        0
    ));
    $settings->add(new admin_setting_configtextarea(
        'coursechecker_currentclaims/trusteddomains',
        get_string('trusteddomains', 'coursechecker_currentclaims'),
        get_string('trusteddomains_desc', 'coursechecker_currentclaims'),
        '',
        PARAM_RAW
    ));
}
