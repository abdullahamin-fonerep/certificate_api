<?php
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/externallib.php");

class local_certificate_api_external extends external_api {

    // Define the parameters for the web service function.
    public static function get_certificate_url_parameters() {
        return new external_function_parameters(
            array(
                'userid' => new external_value(PARAM_INT, 'ID of the user')
            )
        );
    }

    // The main function that checks the certificate and returns the URLs.
    public static function get_certificate_url($userid) {
        global $DB, $CFG;

        // Validate the parameters.
        $params = self::validate_parameters(self::get_certificate_url_parameters(), array('userid' => $userid));

        // Check if the user exists.
        if (!$DB->record_exists('user', array('id' => $params['userid']))) {
            throw new invalid_parameter_exception('Invalid user ID');
        }

        // Look for all certificate issues for the user.
        $certificates = $DB->get_records('tool_certificate_issues', array('userid' => $params['userid']));

        if (!$certificates) {
            // If no certificates were found, return an error message.
            return array('status' => 'error', 'message' => 'The user has not completed any courses yet.');
        }

        // Retrieve the user's last access from the mdl_user table.
        $user = $DB->get_record('user', array('id' => $params['userid']), 'lastaccess');

        if (!$user) {
            throw new invalid_parameter_exception('User data not found.');
        }

        $lastaccess = $user->lastaccess;

        // Initialize an array to store the generated URLs.
        $urls = array();

        // Loop through all the certificates and generate URLs.
        foreach ($certificates as $certificate) {
            $code = $certificate->code;

            // Generate the URL for each certificate PDF.
            $url = new moodle_url('/pluginfile.php/1/tool_certificate/issues/' . $lastaccess . '/' . $code . '.pdf');

            // Add the URL to the list of URLs.
            $urls[] = $url->out(false);
        }

        // Return structured array (which will be automatically converted to JSON by Moodle's web service).
        return array(
            'status' => 'success',
            'certificate_urls' => $urls // Return the array of URLs.
        );
    }

    // Define the return type of the web service function.
    public static function get_certificate_url_returns() {
        return new external_single_structure(
            array(
                'status' => new external_value(PARAM_TEXT, 'Status of the request'),
                'certificate_urls' => new external_multiple_structure( // Use external_multiple_structure for multiple URLs.
                    new external_value(PARAM_URL, 'The URL of a certificate')
                ),
            )
        );
    }
}