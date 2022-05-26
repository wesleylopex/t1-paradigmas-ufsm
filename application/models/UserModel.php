<?php
class UserModel extends MY_Model {
	protected $table = 'users';
	protected $primary = 'id';
	protected $field_order = 'id';
	protected $type_order = 'desc';

	public function validate (string $email, string $password) {
		$email = antiInjection($email, true);
		$password = antiInjection($password, true);

		$user = $this->getRowWhere(['email' => $email]);

		if (!$user) {
			return false;
		}

		$isPasswordValid = compareHash($password, $user->password);

		if ($isPasswordValid) {
			return $user;
		}

		return false;
	}
}
