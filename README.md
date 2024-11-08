# Moodle Custom Web Service Plugin: Certificate API

This Moodle plugin provides a custom web service API that enables retrieval of all certificates issued to a specific student. The plugin is designed to support the **mod_coursecertificate** plugin by Moodle Workplace, allowing users to access certificate data for a given student via their user ID.

> **Note:** This plugin requires the **mod_coursecertificate** plugin to be installed and configured on your Moodle site to function.

## Features

- **Retrieve Certificates**: Fetch all certificates associated with a specific student.
- **Seamless Integration**: Works directly with the **mod_coursecertificate** plugin.
- **REST and SOAP Support**: Supports both REST and SOAP APIs.

## Prerequisites

1. **mod_coursecertificate**: Ensure that the **mod_coursecertificate** plugin by Moodle Workplace is installed.
2. **Moodle Web Services**: Enable Web Services in Moodle.
3. **REST and SOAP API**: Enable both REST and SOAP protocols in Moodle.

## Installation

You can install the plugin in one of the following ways:

### Option 1: Install via Moodle Plugin Upload
1. Log in to your Moodle site as an admin.
2. Go to **Site Administration > Plugins > Install plugins**.
3. Upload the plugin `.zip` file.
4. Follow the prompts to complete the installation.

### Option 2: Manual Installation
1. Unzip the plugin package.
2. Place the folder in the `local/` directory of your Moodle installation.
3. Log in to Moodle as an admin and complete the installation steps.

## Configuration

1. **Enable Web Services**:
   - Go to **Site Administration > Advanced features** and enable **Web services**.

2. **Enable REST and SOAP protocols**:
   - Navigate to **Site Administration > Plugins > Web services > Manage protocols**.
   - Enable both **REST** and **SOAP** protocols.

3. **Generate an API Token**:
   - Go to **Site Administration > Server > Manage tokens**.
   - Create a new token for the plugin with the required permissions.

## Usage

To use this API, make a request to retrieve certificates for a specified student by user ID.

### Example API Request

Replace the placeholders with your Moodle site URL, token, and user ID:

```http
http://yourmoodlesite/moodle/webservice/rest/server.php?wstoken=yourtoken&wsfunction=local_certificate_api_get_certificate_url&moodlewsrestformat=json&userid=id

### Parameters

- **wstoken**: The token generated from the Moodle admin panel.
- **wsfunction**: The web service function name, which is `local_certificate_api_get_certificate_url`.
- **moodlewsrestformat**: The response format, typically `json`.
- **userid**: The ID of the user whose certificates you want to retrieve.

### Example Response

The API will return a JSON response with the URLs and details of the certificates for the specified user.

### Troubleshooting

- **Missing Certificates**: Ensure the user has certificates generated by the **mod_coursecertificate** plugin.
- **API Not Working**: Verify that web services, REST, and SOAP protocols are enabled and that the token has the required permissions.

### Contributing

If you’d like to contribute to this project, feel free to submit a pull request or open an issue to suggest new features or report bugs.

### License

This project is licensed under the [GPLv3 License](https://www.gnu.org/licenses/gpl-3.0.html).