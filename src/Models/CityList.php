<?php

namespace NK\TestProjectBantikov\Models;

use NK\TestProjectBantikov\DB\MySQL;

class CityList
{
    private MySQL $mySQLManager;
    private string $userLang;
    private int $globRegionId;

    public function __construct(string $lang, int $globRegionId)
    {
        $this->userLang = $lang;
        $this->globRegionId = $globRegionId;
        $this->mySQLManager = new MySQL();
    }

    public function getCities(): array
    {
        $data = $this->mySQLManager->execute($this->buildSql());
        $list = [];
        while ($row = $this->mySQLManager->fetchArray($data)) {
            $list = $this->fillCountryList($row);
        }
        return $list;
    }

    private function buildSQL(): string
    {
        return sprintf(
            'SELECT co.c_name_%1$s as country, co.c_descr_%1$s as countryDescr,
	            IF (
	                ci.c_region_id != 0, 
	                re.r_name_%1$s,
	                \'0\'
	            ) 
	            as region, re.r_descr_%1$s as regionDescr,
                ci.c_name_%1$s as city, ci.c_descr_%1$s as cityDescr
            FROM `city` ci
                JOIN `country` co ON ci.c_country_id = co.id
                LEFT JOIN `region` re ON ci.c_region_id = re.id
            WHERE co.glob_region_id = %2$d
            ORDER BY ci.c_name_%1$s',
            $this->userLang,
            $this->globRegionId
        );
    }

    private function fillCountryList(array $row): array
    {
        static $list = [];
        $list[$row['country']]['countryDescr'] = $row['countryDescr'];
        $list[$row['country']]['regions'][$row['region']]['regionDescr'] = $row['regionDescr'];
        $list[$row['country']]['regions'][$row['region']]['cities'][$row['city']]['cityDescr'] = $row['cityDescr'];
        return $list;
    }
}