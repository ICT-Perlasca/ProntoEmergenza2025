<?php
//create a class to contain all the global variables
namespace lib;

class Globals
{
    public static string $db = "pronto_emergenza";
    public static string $username = "root";
    public static string $password = "";
    public static string $host = "localhost";
    public static string $fileLog = "..\\logOperazioniFalliteDB.log";

    public static function getDSN(): string
    {
        return "mysql:host=" . Globals::$host . ";dbname=" . Globals::$db; //charset=utf8_general_ci";
    }

    
    public static function errorLog($message)
    {
        // Suggerimento: Memorizzare informazioni utili al fine di risalire all'origine dell'errore, cui le variabili e le costanti coinvolte
        $flog = fopen(Globals::$fileLog, "a");
        fwrite($flog, date("j-m-y;h-i-s") . ";" . $message . ";\n");
        fclose($flog);
    }
    /*
    public static function getRootDir(): string
    {
        return realpath($_SERVER["DOCUMENT_ROOT"]) . "..\\lib\\";
    }
    public static function parse_request_url(string $request_uri, string $request_method): array
    {
        $parsed_url = parse_url($request_uri);
        $path = $parsed_url["path"];
        $segments = explode('/', $path);
        array_shift($segments);
        $controller = "home";
        $action = "index";
        //echo "<pre>". var_dump($segments) . "</pre>";
        if (count($segments) > 1 && $segments[1])
            $controller = $segments[1];
        if (count($segments) > 2 && $segments[2])
            $action = $segments[2];
        if ($request_method == "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data["query"])) {
                $action = strtolower($data["action"]);
                $_POST["query"] = $data["query"];
                $controller = $segments[2];
            } else if (isset($_POST["action"])) {
                $action = strtolower($_POST["action"]);
                $controller = $segments[1];
            }
        }
        return [
            "controller" => $controller,
            "action" => $action
        ];
    }

    public static function autoload(string $class)
    {
        $files = array(
            $class . "php",
            str_replace('-', '/', $class) . ".php",
        );
        $app_folders = [
            "view",
            "model",
            "controller"
        ];
        $api_dir = Globals::getRootDir() . "\\api\\v1";
        $lib_dir = Globals::getRootDir() . "\\lib";
        foreach ($files as $file) {
            //$general_path = "$base_path/$file";
            //echo "general_path -> $general_path";
            foreach ($app_folders as $f) {
                $general_path = Globals::getRootDir() . "app\\" . $f . "\\" . $file;
                if (file_exists($general_path) && is_readable($general_path))
                    return $general_path;
            }
            $api_file = $api_dir . "\\" . $file;
            //echo "<br>api_file -> $api_file<br>";
            if (file_exists($api_file) && is_readable($api_file))
                return $api_file;

            $lib_file = $lib_dir . "\\" . $file;
            if (file_exists($lib_file) && is_readable($lib_file))
                return $lib_file;
        }
    }
        */
}