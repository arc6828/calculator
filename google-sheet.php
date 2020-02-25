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
echo "1";
$client = getClient();

echo "2";
$service = new Google_Service_Sheets($client);

echo "3";
// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
$spreadsheetId = '1xZi10R9jftvP678yGTT33bfJHggzBWh1mogFzAYL2yw';
$range = 'Sheet1!A2:C';
$response = @$service->spreadsheets_values->get($spreadsheetId, $range);

echo "4";
$values = $response->getValues();

echo "5";
if (empty($values)) {
    //print "No data found.\n";
} else {
    //print "Name, Major:\n";
    $data = [];
    $count = 0;
    foreach ($values as $row) {
        // Print columns A and B, which correspond to indices 0 and 4.
        $data[] = (object)[
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
}
?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hello, world!</title>
        
    <link href='https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css' />

  </head>
  <body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <div class="container">
        <h1>Phone Number</h1>
        <table class="table table-sm"  id="table" style="width:100%">
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Price</th>
                    <th>Operator</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $row) { ?>
                <tr>
                    <td><?=$row->number?></td>
                    <td><?=$row->price?></td>
                    <td><?=$row->operator?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
            
        <script >
            $(document).ready(function() {
                $('#table').DataTable({
                    //deferRender: true,
                });
            } );

        </script>

    </div>
    
    
  </body>
</html>