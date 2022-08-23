<?php
declare(strict_types=1);

namespace app;

abstract class config
{
	/* HTTP basic auth configuration */
	const AUTH_ENABLED = false;
	const AUTH_USERS = [
		['<AUTH-USERNAME>', '<AUTH-PASSWORD>']
	];

	/* Mail configuration */
	const MAIL_DOMAIN = '<MAIL-DOMAIN>';
	const MAIL_ACCOUNT_EXPIRES = 3600; //seconds

	/* RoundCube configuration */
	const ROUNDCUBE_LINK = '<ROUNDCUBE-LINK>';
	const ROUNDCUBE_USER_PARAM = '_user';

	/* DB configuration */
	const MYSQL_HOST = '<MYSQL-HOST>';
	const MYSQL_USER = '<MYSQL-USER>';
	const MYSQL_PASS = '<MYSQL-PASS>';
	const MYSQL_DB = '<MYSQL-DB>';
}