<?php

// set the reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

// // Database access credentials
// define('DB_NAME', 'rent_a_car');
// define('DB_PORT', 3306);
// define('DB_USER', 'root');
// define('DB_PASSWORD', 'root');
// define('DB_HOST', '127.0.0.1'); // localhost

// // JWT Secret 

// define('JWT_Secret', 'd;Tef?mM5V_n*L(-{*L@.0&21rxN}C');

class Config {
    public static function DB_NAME() {
        return Config::get_env("DB_NAME", "rent_a_car");
    }
    public static function DB_PORT() {
        return Config::get_env("DB_PORT", 3306);
    }
    public static function DB_USER() {
        return Config::get_env("DB_USER", 'root');
    }
    public static function DB_PASSWORD() {
        return Config::get_env("DB_PASSWORD", '');
    }
    public static function DB_HOST() {
        return Config::get_env("DB_HOST", '127.0.0.1');
    }
    public static function JWT_SECRET() {
        return Config::get_env("DB_HOST", 'd;Tef?mM5V_n*L(-{*L@.0&21rxN}C');
    }
    // SMTP Configuration
    public static function SMTP_HOST() {
        return Config::get_env("SMTP_HOST", 'smtp.eu.mailgun.org');
    }
    public static function SMTP_USERNAME() {
        return Config::get_env("SMTP_USERNAME", 'postmaster@mg.mustafaajan.tech');
    }
    public static function SMTP_PASSWORD() {
        return Config::get_env("SMTP_PASSWORD", 'b77b36a621846334929fc626bf9d2c26-32a0fef1-2fe868ff');
    }
    public static function SMTP_PORT() {
        return Config::get_env("SMTP_PORT", 465);
    }
    public static function SMTP_ENCRYPTION() {
        return Config::get_env("SMTP_ENCRYPTION", 'tls');
    }

    public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name]) != "" ? $_ENV[$name] : $default;
    }
}