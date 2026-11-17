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

namespace coursechecker_currentclaims;

use context_course;
use context_module;
use core_course\cm_info;
use moodle_url;
use stdClass;

/**
 * Resolves locally collected source IDs to Moodle navigation and editing URLs.
 *
 * @package    coursechecker_currentclaims
 * @copyright  2026 Technische Hochschule Lübeck
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class location_links {
    /**
     * Resolve source references within the actual course of the persisted check.
     *
     * @param array $references Local source references, never external URLs.
     * @param int $checkid Persisted check ID.
     * @return array Template-compatible location records.
     */
    public static function for_report(array $references, int $checkid): array {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/course/lib.php');

        // Bind references to the course recorded by CourseChecker, not to report text.
        $sql = "SELECT c.course_id
                  FROM {local_course_checker_check} ch
                  JOIN {local_course_checker} c ON c.id = ch.checker_id
                 WHERE ch.id = :checkid";
        $courseid = (int)$DB->get_field_sql($sql, ['checkid' => $checkid]);
        $course = $courseid ? $DB->get_record('course', ['id' => $courseid]) : false;
        if (!$course || !can_access_course($course)) {
            return [];
        }

        $modinfo = get_fast_modinfo($course);
        $cms = $modinfo->get_cms();
        $coursecontext = context_course::instance($courseid);
        $caneditcourse = has_capability('moodle/course:update', $coursecontext);
        $viewlabel = get_string('display_location_view', 'coursechecker_currentclaims');
        $editlabel = get_string('display_location_edit', 'coursechecker_currentclaims');
        $result = [];
        foreach ($references as $reference) {
            if (!is_array($reference) || !isset($reference['label']) || !is_string($reference['label'])) {
                continue;
            }
            $row = ['label' => $reference['label'], 'viewlabel' => $viewlabel, 'editlabel' => $editlabel];
            $id = (int)($reference['id'] ?? 0);
            $type = $reference['type'] ?? '';
            if ($type === 'course' && $id === $courseid) {
                $row['viewurl'] = (new moodle_url('/course/view.php', ['id' => $courseid]))->out(false);
                if ($caneditcourse) {
                    $row['editurl'] = (new moodle_url('/course/edit.php', ['id' => $courseid]))->out(false);
                }
            } else if ($type === 'section') {
                $section = $modinfo->get_section_info_by_id($id, IGNORE_MISSING);
                if ($section && $section->uservisible) {
                    $url = course_get_url($course, $section);
                    if ($url) {
                        $row['viewurl'] = $url->out(false);
                    }
                    if ($caneditcourse) {
                        $row['editurl'] = (new moodle_url('/course/editsection.php', ['id' => $id]))->out(false);
                    }
                }
            } else if (in_array($type, ['module', 'book', 'lesson'], true) && isset($cms[$id])) {
                $cm = $cms[$id];
                if ($cm->uservisible && empty($cm->deletioninprogress)) {
                    $row += self::module_urls($course, $cm, $type, (int)($reference['itemid'] ?? 0));
                }
            }
            // Deleted or no longer accessible sources retain their label without links.
            $result[] = $row;
        }
        return $result;
    }

    /**
     * Build links to an existing course module or its specific child content.
     *
     * @param stdClass $course Course record.
     * @param cm_info $cm Visible course module in the report course.
     * @param string $type Source kind.
     * @param int $itemid Book chapter or lesson page ID, if applicable.
     * @return array Allowed view and edit URLs.
     */
    private static function module_urls(stdClass $course, cm_info $cm, string $type, int $itemid): array {
        global $DB;
        $context = context_module::instance($cm->id);
        $view = null;
        $edit = null;
        if ($type === 'book') {
            if ($cm->modname !== 'book' || !$itemid) {
                return [];
            }
            $chapter = $DB->get_record('book_chapters', ['id' => $itemid, 'bookid' => $cm->instance]);
            if (!$chapter) {
                return [];
            }
            if (
                has_capability('mod/book:read', $context) &&
                    (empty($chapter->hidden) || has_capability('mod/book:viewhiddenchapters', $context))
            ) {
                $view = new moodle_url('/mod/book/view.php', ['id' => $cm->id, 'chapterid' => $itemid]);
            }
            if (has_capability('mod/book:edit', $context)) {
                $edit = new moodle_url('/mod/book/edit.php', ['cmid' => $cm->id, 'id' => $itemid]);
            }
        } else if ($type === 'lesson') {
            if (
                $cm->modname !== 'lesson' || !$itemid ||
                    !$DB->record_exists('lesson_pages', ['id' => $itemid, 'lessonid' => $cm->instance])
            ) {
                return [];
            }
            // A learner's lesson flow must not be bypassed by a direct page link.
            if (has_capability('mod/lesson:edit', $context)) {
                $view = new moodle_url('/mod/lesson/edit.php', ['id' => $cm->id], 'lesson-' . $itemid);
                $edit = new moodle_url('/mod/lesson/editpage.php', ['id' => $cm->id, 'pageid' => $itemid, 'edit' => 1]);
            } else {
                $view = $cm->url;
            }
        } else {
            $view = $cm->url;
            if (!$view) {
                // Text and media areas have no standalone view page.
                $view = course_get_url($course, $cm->get_section_info());
                if ($view) {
                    $view->set_anchor('module-' . $cm->id);
                }
            }
            if (has_capability('moodle/course:manageactivities', $context)) {
                $edit = new moodle_url('/course/modedit.php', ['update' => $cm->id, 'return' => 0]);
            }
        }
        $urls = [];
        if ($view) {
            $urls['viewurl'] = $view->out(false);
        }
        if ($edit) {
            $urls['editurl'] = $edit->out(false);
        }
        return $urls;
    }
}
