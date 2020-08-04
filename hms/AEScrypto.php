<?php
function encrypt($plaintext, $password,$name, $email) {
	$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hms";
$apikey =  'api:key-e415d6a5xxxxxxxxxa389d17xx0555ee';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
    $method = "AES-256-CBC";
    $key = uniqid();
    $iv = openssl_random_pseudo_bytes(16);

    $ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
    $hash = hash_hmac('sha256', $ciphertext . $iv, $key, true);

    // start the mail sending
				$subject1 = "Decryption Key";
				$message = 	"
				<html>
				<head>
				<title>Decryption Key</title>
				</head>
				<body>
				<h2>You are trying to view a record of yours.</h2>
				<p>please make use of the code below to decrypt your medical records:</p>
				<p>Decryption Key: ".$key."</p>
				<p>Please ensure you did not reload the request as the key will be destroyed once you reload the page.</p>
				</body>
				</html>
				";
				$tag ="Important";
				$replyto = 'mails@mails.com';

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD, $apikey);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_URL, 
					'https://api.mailgun.net/v2/www.esoftchurch.com/messages');
				curl_setopt($ch, CURLOPT_POSTFIELDS, 
					array('from' => 'Encrypted patien profile management system <admin@solomail.com>',
						'to' =>$name.' <'. $email.'>',
						'subject' => $subject1,
						'html' => $message,
						'text' => $message,
						'o:tracking'=>'yes',
						'o:tracking-clicks'=>'yes',
						'o:tracking-opens'=>'yes',
						'o:tag'=>$tag,
						'h:Reply-To'=>$replyto));
				$result = curl_exec($ch);
				curl_close($ch);
// mail sending ended
				if ($result) {
		$sql = " REPLACE INTO deckey VALUES (null, '$key', '$email',null)";

				if (mysqli_query($conn, $sql)) {
					 echo '<script>alert("decryption key has just been sent to your mail.")</script>';
				}else {
 				 var_dump("Error: " .  mysqli_error($conn));die;
						}
				}

    return $iv . $hash . $ciphertext;
}


function decrypt($ivHashCiphertext, $password) {
    $method = "AES-256-CBC";
    $iv = substr($ivHashCiphertext, 0, 16);
    $hash = substr($ivHashCiphertext, 16, 32);
    $ciphertext = substr($ivHashCiphertext, 48);
    $key = hash('sha256', $password, true);

    if (!hash_equals(hash_hmac('sha256', $ciphertext . $iv, $key, true), $hash)) return null;

    return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
}



// echo $encrypted = encrypt('Plaintext string.', 'password'); // this yields a binary string

// echo decrypt($encrypted, 'password');
// decrypt($encrypted, 'wrong password') === null
?>