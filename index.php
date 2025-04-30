<?php
$route = isset($_GET['route']) ? trim($_GET['route'], "/") : 'home';
$pageFile = "./pages/{$route}.php";

if (file_exists($pageFile)) {
    include $pageFile;
} else {
    http_response_code(404);
    include "./pages/underConstruction.php";
}
?>