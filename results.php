<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">


        <title>Fake Airbnb Results</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <!-- Bootstrap core CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet">
        <link rel="icon" href="images/house-heart-fill.svg">
        <link rel="mask-icon" href="images/house-heart-fill.svg" color="#000000">   
    </head>
  <body>
    
    <header>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                <h4 class="text-white">About</h4>
                <p class="text-muted">Fake Airbnb. Data c/o http://insideairbnb.com/get-the-data/</p>
                </div>
            </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
            <a href="index.php" class="navbar-brand d-flex align-items-center">
                <i class="bi bi-house-heart-fill my-2"></i>    
                <strong> Fake Airbnb</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            </div>
        </div>
        
    </header>

    <main>

    <?php 
        include('src/functions.php');
        $db = dbConnect();
        $neighborhood = getNeighborhoods($db);
        $roomType = getRoomTypes($db);
        $numberGuests = getNumberOfGuests($db);
    ?>

        <div class="container">

            <?php
                $neighborhoodId = $_GET['neighborhoodId'];
                $roomType = $_GET['roomType'];
                $accomodates = $_GET['noGuests'];


            $h1_count = getResultCount($db,$neighborhoodId,$roomType[0],$accomodates); 
            $h1_display = $h1_count[0]["count(*)"]; // This contains the count of results, for reference
            if ($h1_display == 0){
                echo "<h1>Results (0)</h1>";
            }
            else{
                echo "<h1>Results ($h1_display)</h1>";
            }
            // Global Neighborhood Name Location
            $neighborhoodName = "";

            // Getting and Setting the Neighborhood Name
            if (isset($_GET['neighborhoodId']) && $_GET['neighborhoodId']!="Select One"){
                $response = getNeighborhoodsById($db,$neighborhoodId);
                $name = $response[0]["neighborhood"];
                echo "<p><span><strong>Neighborhood</strong></span>: $name</p>";
                $neighborhoodName = $name;
            }

            // Global roomType Name Location
            $pickedRoomType = "";

            // Getting and setting the Room Type ID
            if (isset($_GET['roomType']) && $_GET['roomType']!="Select One"){
                $new_response = getRoomTypeById($db,$roomType[0]);
                $name = $new_response[0]['type'];
                echo "<p><span><strong>Room Type</strong></span>: $name</p>";
                $pickedRoomType = $name;
            }

            // Global Value for Number of Guests
            $accomodates = ""; 

            // Getting the number of guests
            if (isset($_GET['noGuests'])){
                $accom = $_GET['noGuests'];
                echo "<p><span><strong>Accommodates</strong></span>: $accom</p>";

            }

            $card_info = createCards($db,$neighborhoodId,$roomType[0],$accom);

            ?>
            

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                            <?php
                                for ($i=0;$i<$h1_display;$i++){
                                    echo "<div class=col>";
                                    echo "<div class=\"card shadow-sm\">";

                                    $imgC = $card_info[$i]['pictureUrl'];
                                    echo "<img src=\"$imgC\">";
                                    
                                    echo "<div class=\"card-body\">";
                                    $nameN = $card_info[$i]['neighborhood'];
                                    echo "<h5 class=\"card-title\">$nameN</h5>";

                                    $nameL = $card_info[$i]['name'];
                                    $typeR = $card_info[$i]['type'];
                                    echo "<p class=\"card-text\">$nameL<br>$typeR</p>";

                                    $accomodatesN = $card_info[$i]["accommodates"];
                                    echo "<p class=\"card-text\">Accommodates $accomodatesN</p>";

                                    $rating = $card_info[$i]["rating"];

                                    $rating_par1= "<p class=\"card-text align-bottom\">";
                                    $rating_par2= "<i class=\"bi bi-star-fill\"></i><span class=\"\"> $rating </span>";
                                    $rating_par3= "</p>";
                                    echo $rating_par1.$rating_par2.$rating_par3;

                                    $priceL = $card_info[$i]["price"];
                                    $idL = $card_info[$i]["id"];
                                    echo "<div class=\"d-flex justify-content-between align-items-center\">
                                        <div class=\"btn-group\">
                                            <button type=\"button\" id=\"$idL\" class=\"btn btn-sm btn-outline-secondary viewListing\" data-bs-toggle=\"modal\" data-bs-target=\"#fakeAirbnbnModal\">View</button>
                                        </div>
                                        
                                        <small class=\"text-muted\">\$$priceL</small>

                                    </div>
                                    </div>
                                    </div>
                                    </div>";
                                }
                                
                            ?>

            




        </div><!-- .container-->


    </main>

    <footer class="text-muted py-5">
        <div class="container">

            <p class="mb-1">CS 293, Spring 2024</p>
            <p class="mb-1">Lewis & Clark College</p>
        </div>
    </footer>
    <!-- modal-->
    <div class="modal fade modal-lg" id="fakeAirbnbnModal" tabindex="-1" aria-labelledby="fakeAirbnbnModalLabel" aria-modal="true" role="dialog" >
      <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Private Rooftop Flat~ 14 Guests ~ 94 WalkScore</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-image">
                    <img src="https://a0.muscache.com/pictures/miso/Hosting-816145492959772426/original/0dc00636-64de-4101-a65e-0ea83b974d83.jpeg" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <p>Hosford-Abernethy</p><p>$731.00 / night</p><p>Accommodates 14</p><p><i class="bi bi-star-fill"></i> 5.00</p><p>Hosted by Bob</p><p>Amenities: Air conditioning, Bathtub, Bed linens, Body soap, Carbon monoxide alarm, Cleaning products, Clothing storage, Coffee, Coffee maker: Keurig coffee machine, Conditioner, Cooking basics, Dedicated workspace, Dishes and silverware, Dishwasher, Dryer, Essentials, Fire extinguisher, First aid kit, Free street parking, Freezer, Hair dryer, Hangers, Heating, Hot water, Hot water kettle, Iron, Kitchen, Laundromat nearby, Long term stays allowed, Luggage dropoff allowed, Microwave, Outdoor dining area, Outdoor furniture, Oven, Pack ’n play/Travel crib, Private entrance, Private patio or balcony, Refrigerator, Room-darkening shades, Self check-in, Shampoo, Shower gel, Smart lock, Smoke alarm, Stove, TV, Toaster, Washer, Wifi, Wine glasses</p><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        
    <script src="js/script.js"></script>

  </body>
</html>



