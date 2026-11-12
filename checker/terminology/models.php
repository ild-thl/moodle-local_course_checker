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
// Model-IDs für die GWDG Chat-AI API. Nur für den lokalen Vergleich.
// Verfügbarkeit kann je nach API-Zugang/Änderungen bei GWDG abweichen.

/**
 * Defines available AI models for the GWDG and MyLab providers.
 *
 * @package    coursechecker_terminology
 * @copyright  2026 Technische Hochschule Lübeck
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
return [
    'deepseek-v4.1-flash-1017' => 'DeepSeek V4.1 Flash 1017 (bisheriger Test)',
    'deepseek-v4-flash-0731' => 'DeepSeek V4 Flash 0731',
    'qwen3-30b-a3b-instruct-2507' => 'Qwen3 30B A3B Instruct 2507',
    'qwen3.6-35b-a3b' => 'Qwen3.6 35B A3B',
    'mistral-medium-3.5-128b' => 'Mistral Medium 3.5 128B',
    'meta-llama-3.1-8b-instruct' => 'Llama 3.1 8B Instruct',
    'mylab-chat-fast' => 'MyLab – chat-fast (Gemma4-31B)',
];
