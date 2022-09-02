<?php

namespace NK\TestProjectBantikov\Controllers;

use NK\TestProjectBantikov\Models\GLobRegion;
use NK\TestProjectBantikov\Models\Language;

class LanguageController
{
    public function getLangData(): array
    {
        $userLang = $this->getLanguage();
        $globalRegion = $this->getGlobalRegion($userLang);
        return [$userLang, $globalRegion];
    }

    private function getLanguage(): string
    {
        $userLang = $_GET['user_lang'] ?? Language::DEFAULT_LANG;
        if (!in_array($userLang, Language::$langDictionary, TRUE)) {
            echo 'Unsupported language typed. Please select russian, english or german language.<br><br>';
            $userLang = Language::DEFAULT_LANG;
        }
        return $userLang;
    }

    private function getGlobalRegion(string $userLang): object
    {
        $globRegionManager = new GLobRegion($userLang);
        $customGlobRegion = $_GET['glob_region'] ?? '-1';
        return $globRegionManager->getGlobRegionByName($customGlobRegion)
               ?? $globRegionManager->getDefaultGlobRegionByLang();
    }
}