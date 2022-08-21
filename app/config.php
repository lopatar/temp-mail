<?php
declare(strict_types=1);

namespace app;

abstract class config
{
	/* Mail configuration */
	const MAIL_DOMAIN = '<MAIL-DOMAIN>';

	/* RoundCube configuration */
	const ROUNDCUBE_LINK = '<ROUNDCUBE-LINK>';
	const ROUNDCUBE_USER_PARAM = '_user';

	/* DB configuration */
	const MYSQL_HOST = '<MYSQL-HOST>';
	const MYSQL_USER = '<MYSQL-USER>';
	const MYSQL_PASS = '<MYSQL-PASS>';
	const MYSQL_DB = '<MYSQL-DB>';
}