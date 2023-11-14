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

namespace local_learningcompanions\event;

/**
 * The group_created event class.
 *
 * Das Projekt THISuccessAI (FBM202-EA-1690-07540) wird im Rahmen der Förderlinie „Hochschulen durch Digitalisierung stärken“ durch die Stiftung Innovation in der Hochschulehre gefördert.
 *
 * @package     local_learningcompanions
 * @category    event
 * @copyright   2023 ICON Vernetzte Kommunikation GmbH <spiros.tzanetatos@iconnewmedia.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class group_created extends \core\event\base {

    // For more information about the Events API please visit {@link https://docs.moodle.org/dev/Events_API}.
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'lc_groups';
    }

    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->data['objectid'])) {
            throw new \coding_exception('The \'objectid\' value must be set.');
        }

        if (!isset($this->data['userid'])) {
            throw new \coding_exception('The \'userid\' value must be set.');
        }

        if (!isset($this->data['other']['courseid'])) {
            throw new \coding_exception('The \'other[courseid]\' value must be set.');
        }

        if (!isset($this->data['other']['topics'])) {
            throw new \coding_exception('The \'other[topics]\' value must be set.');
        }
    }

    public static function get_name() {
        return get_string('event_group_created', 'local_learningcompanions');
    }

    public function get_description() {
        return "The user with id '$this->userid' created a group with id '$this->objectid'.";
    }

    public static function make(int $creatorId, int $groupId, array $topics = [], int $courseId = 0, int $cmId = 0) {
        $params = [
            'objectid' => $groupId,
            'userid' => $creatorId,
            'other' => [
                'topics' => $topics,
                'courseid' => $courseId,
            ]
        ];

        if ($cmId) {
            $params['contextid'] = $cmId;
        } else {
            $params['context'] = \context_system::instance();
        }

        return self::create($params);
    }
}
