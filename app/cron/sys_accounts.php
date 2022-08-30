<?php
declare(strict_types=1);

use app\config;
use app\database\connection;
use app\models\mail_account;

require_once __DIR__ . '/../../vendor/autoload.php';

connection::init(config::MYSQL_HOST, config::MYSQL_USER, config::MYSQL_PASS, config::MYSQL_DB);

$accounts = mail_account::get_all();

foreach ($accounts as $account) {
	if ($account->is_expired()) {
		$account->delete();
		continue;
	}

	$account->create_system_user();
}