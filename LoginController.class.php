<?php 


class LoginController {

	private $dao;
	public $username;
	public $password;

	function __construct() {
		session_start();
		$this->dao = new UserDao();
		$this->username = new UserName($_POST['username']);
		$this->password = new Password($_POST['password']);
	}

	function init() {


		// exit;

		// ログインしているかどうか
		if ($this->isLogined()) {
			header('location: main.php');
			exit;
		}

		// ログインボタンを押したか
		if ($this->isLoginAction()) {

			// 入力値が正しいか
			if (!$this->username->isValid() || !$this->password->isValid()) {
				return;
			}

			// DBからユーザ取得
			// ...
			$users = $this->dao->findByUsernameAndPassword($this->username->__toString(), $this->password->__toString());

			// ユーザが有効か
			if (empty($users)) {
				$this->username->addErrorMessage("ユーザ名またはパスワードが間違っています。");
				return;
			}

			$user = $users[0];
			var_dump($user);

			$_SESSION['userId'] = $user['id'];
			header('location: main.php');
			exit;

		}
	}

	function isLogined() {
		$userId = $_SESSION['userId'];
		if (!$userId) return false;
		$users = $this->dao->findById($userId);
		if (empty($users)) return false;
		return true;
	}

	public function isLoginAction() {
		$action = $_GET['action'];
		return $action === 'login';
	}

	function isValidUserName($user) {
		return true;
	}

	function isValidPassword($password) {
		return false;
	}


}

abstract class Field {
	protected $value;
	protected $errorMessages;
	function __construct($value) {
		$this->value = StringUtil::nvl($value);
		$this->errorMessages = [];
	}
	abstract function isValid();
	function hasError() {
		return !empty($this->errorMessages);
	}

	function addErrorMessage($errorMessage) {
		$this->errorMessages[$errorMessage] = $errorMessage;
	}
	function getErrorMessages() {
		return $this->errorMessages;
	}
	function __toString() {
		return $this->value;
	}
}


class UserName extends Field {
	function isValid() {
		return preg_match('/^[a-zA-Z0-9]+$/u', $this->value);
	}
	function getErrorMessages() {
		if (!$this->isValid()) {
			$errorMessage = 'ユーザ名は半角英数字のみ使用可能です。';
			$this->errorMessages[$errorMessage] = $errorMessage;
		}
		return $this->errorMessages;
	}
}

class Password extends Field {
	function isValid() {
		return preg_match('/^[a-zA-Z0-9]{8,16}+$/u', $this->value);
	}
	function getErrorMessages() {
		if (!$this->isValid()) {
			$errorMessage = 'パスワードは半角英数字と記号(?!+#$)のみ使用可能です。';
			$this->errorMessages[$errorMessage] = $errorMessage;
		}
		return $this->errorMessages;
	}
}

class StringUtil {

	public static function nvl($val) {
		return $val === null ? '' : $val;
	}

}


class UserDao extends AbstractDao {

	function findByUsernameAndPassword($username, $password) {
		$result = [];
		try {
			// connect
			$db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $db->prepare('select id, username, password from users where username = :username and password = :password');
			$stmt->bindValue(':username', $username, PDO::PARAM_STR);
			$stmt->bindValue(':password', $password, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


			// disconnect
			$db = null;

		} catch (PDOException $e) {
			exit;
		}


		return $result;

	}

	function findById($userId) {
		$result = [];
		try {
			// connect
			$db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $db->prepare('select id, username, password from users where id = :id');
			$stmt->bindValue(':id', $userId, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// disconnect
			$db = null;

		} catch (PDOException $e) {
			$db->rollback();
			exit;
		}

		return $result;
	}

}

abstract class AbstractDao {

	protected $db;

	function __construct($foo = null) {
		define('DB_DATABASE', 'dotinstall_db');
		define('DB_USERNAME', 'dbuser');
		define('DB_PASSWORD', 'tange123');
		define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);
	}

}
