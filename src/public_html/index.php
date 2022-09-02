<?php

require_once '../../vendor/autoload.php';

use NK\TestProjectBantikov\Controllers\LanguageController;
use NK\TestProjectBantikov\Models\CityList;


$langManager = new LanguageController();
[$selectedLang, $globRegion] = $langManager->getLangData();

$ListManager = new CityList($selectedLang, $globRegion->id);
$result = $ListManager->getCities();

$loader = new \Twig\Loader\FilesystemLoader('../views/');
$twig = new \Twig\Environment($loader);
$template = $twig->load('city_list.html');
echo $template->render([
    'GlobRegion' => $globRegion->name,
    'cityList' => $result,
    'emptyInfo' => $result
        ? ''
        : sprintf('No results found for \'%s\'', $globRegion->name)
]);
