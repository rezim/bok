<?php

class aclsController extends Controller
{
    function logout()
    {
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(), '', 0, '/');
        header("Location: " . SCIEZKA);
    }

    function login()
    {
        // sometimes we do not want to install https in dev env.
        // below allows to disable it in configuration
        if (!defined('DISABLE_HTTPS') || !DISABLE_HTTPS) {
            redirectToHTTPS();
        }
        if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {

            header("Location: /" . SCIEZKA);
            die();
        }
    }

    function passshow()
    {

        $p = new PassHash();
        echo($p->hash(HASLO_GENERATE));
        die();
    }

    function logowanie()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

            if (empty($_POST['login'])) {
                echo('Wpisz poprawny login');
                return;
                die();

            }
            if (empty($_POST['pass'])) {
                echo('Wpisz hasło');
                return;
                die();
            }

            $p = new PassHash();
            $pass = $p->hash($_POST['pass']);

            $dataAcl = $this->acl->getByLogin($_POST['login']);


            if (empty($dataAcl)) {
                echo('Brak takiego konta lub błędne hasło.');
                return;
                die();
            }

            if (!$p->check_password($dataAcl[0]['haslo'], $_POST['pass'])) {
                echo('Brak takiego konta lub błędne hasło.');
                return;
                die();
            }

            $config = new config();

            $appConfig = $config->getConfiguration()[0];

            $this->acl->refreshSession($dataAcl[0]['rowid'], $appConfig);

            echo(json_encode(array('status' => 1,
                'info' => 'Zalogowano pomyślnie')));
        } else {
            header("Location: " . SCIEZKA . "/starts/bladwywolania");
        }
    }

    function brakuprawnien()
    {
        $this->logInfo('acsl', 'brakuprawnien', json_encode(debug_backtrace()));
    }
}

define("PBKDF2_HASH_ALGORITHM", "sha256");
define("PBKDF2_ITERATIONS", 1300);
define("PBKDF2_SALT_BYTE_SIZE", 24);
define("PBKDF2_HASH_BYTE_SIZE", 24);

define("HASH_SECTIONS", 4);
define("HASH_ALGORITHM_INDEX", 0);
define("HASH_ITERATION_INDEX", 1);
define("HASH_SALT_INDEX", 2);
define("HASH_PBKDF2_INDEX", 3);

class PassHash
{

    function hash($password)
    {
        // format: algorithm:iterations:salt:hash
        // [TR]: mcrypt_create_iv was removed in PHP 7.2, we use alternative base64_encode, see
        // https://www.php.net/manual/en/function.random-bytes.php
        // $salt = base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));
        $salt = base64_encode(random_bytes(PBKDF2_SALT_BYTE_SIZE));

        return PBKDF2_HASH_ALGORITHM . ":" . PBKDF2_ITERATIONS . ":" . $salt . ":" .
            base64_encode(PassHash::pbkdf2(
                PBKDF2_HASH_ALGORITHM,
                $password,
                $salt,
                PBKDF2_ITERATIONS,
                PBKDF2_HASH_BYTE_SIZE,
                true
            ));
    }


    function check_password($correct_hash, $password)
    {
        $params = explode(":", $correct_hash);
        if (count($params) < HASH_SECTIONS)
            return false;
        $pbkdf2 = base64_decode($params[HASH_PBKDF2_INDEX]);
        return PassHash::slow_equals(
            $pbkdf2,
            PassHash::pbkdf2(
                $params[HASH_ALGORITHM_INDEX],
                $password,
                $params[HASH_SALT_INDEX],
                (int)$params[HASH_ITERATION_INDEX],
                strlen($pbkdf2),
                true
            )
        );
    }

    function slow_equals($a, $b)
    {
        $diff = strlen($a) ^ strlen($b);
        for ($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $diff === 0;
    }

    function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
    {
        $algorithm = strtolower($algorithm);
        if (!in_array($algorithm, hash_algos(), true))
            trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
        if ($count <= 0 || $key_length <= 0)
            trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);

        if (function_exists("hash_pbkdf2")) {
            // The output length is in NIBBLES (4-bits) if $raw_output is false!
            if (!$raw_output) {
                $key_length = $key_length * 2;
            }
            return hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output);
        }

        $hash_length = strlen(hash($algorithm, "", true));
        $block_count = ceil($key_length / $hash_length);

        $output = "";
        for ($i = 1; $i <= $block_count; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt . pack("N", $i);
            // first iteration
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < $count; $j++) {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }

        if ($raw_output)
            return substr($output, 0, $key_length);
        else
            return bin2hex(substr($output, 0, $key_length));
    }


}