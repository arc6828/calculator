<?php
require __DIR__ . '/vendor/autoload.php';
/*
if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}
*/
/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


// Get the API client and construct the service object.
//echo "1";
$client = @getClient();

//echo "2";
$service = new Google_Service_Sheets($client);

//echo "3";
// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
$spreadsheetId = '1xZi10R9jftvP678yGTT33bfJHggzBWh1mogFzAYL2yw';
$range = 'Sheet1!A2:C';
$response = @$service->spreadsheets_values->get($spreadsheetId, $range);

//echo "4";
$values = $response->getValues();

//echo "5";
if (empty($values)) {
    //print "No data found.\n";
    
} else {
    //print "Name, Major:\n";
    $data = [];
    $count = 0;
    foreach ($values as $row) {
        // Print columns A and B, which correspond to indices 0 and 4.
        $data[] = [
            "number" => $row[0],
            "price" => $row[1],
            "operator" => $row[2],
        ];
        $count = $count+1;
        //if($count == 1000) break;
        //printf("%s, %s\n", $row[0], $row[1]);
        //$text = sprintf("%s, %s, %s<br />", $row[0], $row[1], $row[2]);
        //echo $text;
    }
    //$data = (object) $data;
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}
?>