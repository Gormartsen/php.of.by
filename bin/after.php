<?php
/**
 * @file
 * This script file is executed on the Zen.ci platform for deploy.
 *
 */

$home = getenv('DOCROOT');
$deploy_dir = getenv('ZENCI_DEPLOY_DIR');
chdir($home);

// Success.
$data = array(
  'state' => 'success',
  'message' => 'deployed properly to ' . getenv('DOMAIN'),
  'summary' => 'Website URL http://' . getenv('DOMAIN'),
);
zenci_put_request($data);
exit(0);

/**
 * Submit a POST request to Zen.ci updating its current status.
 *
 * @param array $data
 *   An array of data to push to Zen.ci. Should include the following:
 *   - state: One of "error", "success", or "pending".
 *   - message: A string summary of the state.
 *   - summary: Optional. A longer description of the state.
 */
function zenci_put_request($data) {
  $token = getenv('ZENCI_API_TOKEN');
  $status_url = getenv('ZENCI_STATUS_URL');

  $data = json_encode($data);

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $status_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Note the PUT here.

  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_HEADER, true);

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Token: ' . $token,
      'Content-Length: ' . strlen($data)
  ));
  curl_exec($ch);
  curl_close($ch);
}
