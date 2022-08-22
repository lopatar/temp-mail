<?php
declare(strict_types=1);

use app\models\mail_account;

$account = mail_account::generate();
?>
<body>
	<h1>Temp mail</h1>
	<p><b>Username: </b> <?= $account->get_email_address() ?></p>
	<p><b>Password: </b> <?= $account->password ?></p>
	<p><b>Expires: </b> <?= $account->get_expires_string() ?></p>
	<a href="<?= $account->get_roundcube_link() ?>" target="_blank"><button>Redirect to RoundCube</button></a>
	<p><b>Please wait up to 2 minutes for the account to be created!</b></p>
</body>
</html>
