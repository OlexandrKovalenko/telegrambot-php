<?php


namespace App\Database;

use PDO;

class Region
{
    private PDO $query;

    public function __construct()
    {
        $db = new DBConnect();
        $this->query = $db->connect();
    }

    function getActiveCities()
    {
        $allActiveCitiesQuery = "SELECT located_city.city, located_city.city_slug, located_region.region, located_region.region_slug FROM  located_city, located_region 
        WHERE located_region.is_active = TRUE AND located_city.is_active = TRUE and located_city.region_id = located_region.id";
        $stmt = $this->query->prepare($allActiveCitiesQuery);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    function getUserRegion($id)
    {
        $userRegion = "SELECT located_region.region,located_city.city, located_region.is_active 
        FROM located_region join located_city on located_city.region_id = located_region.id 
        join user on user.located_city_id = located_city.id where user.id = :id";

        $stmt = $this->query->prepare($userRegion);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    //private $userCity = "SELECT located_city.city, located_city.is_active FROM located_city
     //   JOIN USER ON USER.located_city_id = located_city.id WHERE USER.id = 1";
}