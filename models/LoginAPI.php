<?php
namespace app\models;

use app\models\User;
use voboghure\phpmvc\Model;

class LoginAPI extends Model {
	public string $email    = '';
	public string $password = '';

	public function rules(): array{
		return [
			'email'    => [self::RULE_REQUIRED, self::RULE_EMAIL],
			'password' => [self::RULE_REQUIRED],
		];
	}

	public function login() {
		$user = User::findOne( ['email' => $this->email] );
		if (  ! $user ) {
			$this->addError( 'email', 'User does not exist' );

			return false;
		}
		if (  ! password_verify( $this->password, $user->password ) ) {
			$this->addError( 'email', 'Incorrect password' );

			return false;
		}

		return $user;
	}

}