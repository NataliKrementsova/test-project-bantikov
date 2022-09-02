<?php

namespace NK\TestProjectBantikov\Models;

use NK\TestProjectBantikov\DB\MySQL;

class GLobRegion
{
    private MySQL $mySQLManager;
    private string $userLang;

    private const DEFAULT_GLOB_REGION = 'Европа';
    private array $defaultGlobRegionByLang;

    public function __construct($userLang)
    {
        $this->mySQLManager = new MySQL();
        $this->userLang = $userLang;
        $this->defaultGlobRegionByLang = [
            Language::RUSSIAN => 'Европа',
            Language::ENGLISH => 'Europe',
            Language::GERMAN => 'Europe',
        ];
    }

    /**
     * @param string $globRegion
     * @return object|null
     */
    public function getGlobRegionByName(string $globRegion)
    {
        $globalRegionPattern = '%' . sprintf('%s', $this->mySQLManager->escape($globRegion)) . '%';
        $result = $this->mySQLManager->execute(
            sprintf(
                'SELECT `id`, `gr_name_%1$s` as name FROM `glob_region` WHERE `gr_name_%1$s` like \'%2$s\'',
                $this->userLang,
                $globalRegionPattern
            )
        );
        return $this->mySQLManager->fetchObject($result);
    }

    public function getDefaultGlobRegionByLang(): object
    {
        if (isset($_GET['user_lang'])) {
            echo 'The result is shown for default continent: ' . $this->defaultGlobRegionByLang[$this->userLang] .
                 ' in '
                 . $this->userLang . ' language' . '<br><br> ';
        }
        $defaultGlobRegion = $this->defaultGlobRegionByLang[$this->userLang] ?? self::DEFAULT_GLOB_REGION;
        return $this->getGlobRegionByName($defaultGlobRegion);
    }
}
