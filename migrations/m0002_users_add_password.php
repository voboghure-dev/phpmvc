<?php

use voboghure\phpmvc\Application;

class m0002_users_add_password {
	public function up() {
		$db = Application::$app->db;
		$db->pdo->exec("ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL;");
	}

	public function down() {
		$db = Application::$app->db;
		$db->pdo->exec("ALTER TABLE users DROP COLUMN password;");
	}
}