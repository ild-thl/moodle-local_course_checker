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
 * Privacy metadata and data request interfaces for the current claims checker.
 *
 * @package    coursechecker_currentclaims
 * @copyright  2026 Technische Hochschule Lübeck
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace coursechecker_currentclaims\privacy;

use context;
use core_privacy\local\metadata\collection;
use core_privacy\local\metadata\provider as metadata_provider;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\core_userlist_provider;
use core_privacy\local\request\plugin\provider as request_provider;
use core_privacy\local\request\userlist;

/**
 * Describe optional transmissions to external services.
 *
 * This subplugin has no own user-data tables. Its result rows belong to the
 * parent CourseChecker. Moodle course content may nevertheless include personal
 * data, so externally transmitted text and queries must be disclosed.
 */
class provider implements core_userlist_provider, metadata_provider, request_provider {
    /**
     * Add privacy information about external data transmissions.
     *
     * @param collection $collection Initialised metadata collection.
     * @return collection Updated metadata collection.
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_external_location_link('ai_provider', [
            'coursetext' => 'privacy:metadata:ai_provider:coursetext',
        ], 'privacy:metadata:ai_provider');
        $collection->add_external_location_link('openai_search', [
            'claim' => 'privacy:metadata:openai_search:claim',
        ], 'privacy:metadata:openai_search');
        return $collection;
    }

    /**
     * No user-specific records are held by this subplugin.
     *
     * @param int $userid Requested user ID.
     * @return contextlist Empty list of contexts.
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        return new contextlist();
    }

    /**
     * User result data is owned by the parent CourseChecker plugin.
     *
     * @param approved_contextlist $contextlist Approved contexts.
     * @return void
     */
    public static function export_user_data(approved_contextlist $contextlist): void {
        // No own records to export.
    }

    /**
     * There are no own user data records to delete.
     *
     * @param context $context Context to be cleared.
     * @return void
     */
    public static function delete_data_for_all_users_in_context(context $context): void {
        // No own records to remove.
    }

    /**
     * There are no own user data records to delete.
     *
     * @param approved_contextlist $contextlist Approved contexts.
     * @return void
     */
    public static function delete_data_for_user(approved_contextlist $contextlist): void {
        // No own records to remove.
    }

    /**
     * No user identifiers are recorded by this subplugin.
     *
     * @param userlist $userlist User list to populate.
     * @return void
     */
    public static function get_users_in_context(userlist $userlist): void {
        // No own users to list.
    }

    /**
     * Nothing to delete because this subplugin does not maintain user records.
     *
     * @param approved_userlist $userlist Approved user list.
     * @return void
     */
    public static function delete_data_for_users(approved_userlist $userlist): void {
        // No own records to remove.
    }
}
