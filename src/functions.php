<?php

// Neighborhood Functions

function getNeighborhoods($db){
    try {
        $stmt = $db->prepare("select * from neighborhoods order by neighborhood ;");   
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    
    }
    catch (Exception $e) {
        echo $e;
    }
    
} 

function getNeighborhoodsById($db,$id){
    try{
        $stmt = $db->prepare("select neighborhood from neighborhoods where id=$id;");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    catch(Exception $e){
        echo $e;
    }
}

//RoomType Functions
function getRoomTypes($db){
    try {
        $stmt = $db->prepare("select * from roomTypes order by type ;");   
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    
    }
    catch (Exception $e) {
        echo $e;
    }
    
} 

function getRoomTypeById($db,$id){
    try{
        $stmt = $db->prepare("select type from roomTypes where id=$id order by type asc limit 20;");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    catch(Exception $e){
        echo $e;
    }
}


// Number of Guests / Accomodates functions
function getNumberOfGuests($db){
    try {
        $stmt = $db->prepare("select distinct accommodates from listings where accommodates > 0 order by accommodates asc;");   
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    
    }
    catch (Exception $e) {
        echo $e;
    }
    
} 


// Counting the results
function getResultCount($db,$neighborhoodId,$roomTypeId,$accommodates){
    try{
        $stmt = $db->prepare("select count(*) 
        from listings inner join neighborhoods on listings.neighborhoodId=neighborhoods.id 
        inner join roomTypes on listings.roomTypeId = roomTypes.id 
        where listings.accommodates=$accommodates and roomTypes.id=$roomTypeId and neighborhoods.id=$neighborhoodId
        limit 20;
        ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    catch (Exception $e){
        echo $e;
    }
}

// Creating the Cards
function createCards($db, $neighborhoodId, $roomTypeId, $accommodates){
    $stmt = $db->prepare("select *
    from listings 
    inner join neighborhoods on listings.neighborhoodId=neighborhoods.id 
    inner join roomTypes on listings.roomTypeId = roomTypes.id 
    inner join hosts on hosts.id = listings.hostId 
    where listings.roomTypeId=$roomTypeId and accommodates=$accommodates and neighborhoodId=$neighborhoodId
    limit 20;");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($rows);
    return $rows;
}

// Get Amenities
function getAmenities($db,$accommodates,$extId){
    $stmt = $db->prepare("select amenity from amenities
    join listingAmenities on amenities.id=listingAmenities.amenityID
    join listings on listings.id=listingAmenities.listingID
    where listings.accommodates=$accommodates and extId=$extId;");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

define("SERVER", "localhost");
define("PORT", "3306");
define("USERNAME", "fakeAirbnbUser");
define("PASSWORD", "apples11Million!");
define("DATABASE", "fakeAirbnb");


function dbConnect(){
    /* defined in config/config.php */
    /*** connection credentials *******/
    $servername = SERVER;
    $username = USERNAME;
    $password = PASSWORD;
    $database = DATABASE;
    $dbport = PORT;
    /****** connect to database **************/

    try {
        $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4;port=$dbport", $username, $password);
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }
    return $db;
}



?>