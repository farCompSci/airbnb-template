<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fake Airbnb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
 
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
    //Setup
    include('src/functions.php');
    $db = dbConnect();
    $neighborhood = getNeighborhoods($db);
    $roomType = getRoomTypes($db);
    $numberGuests = getNumberOfGuests($db);
    ?>

    <div class="album py-5 bg-light">
        <div class="container">
        <h1>Search for Rentals in the Portland Area</h1>

            <form action="results.php" method="GET">

                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                    <label for="neighborhood" class="col-form-label">Neighborhood</label>
                    </div>

                    <div class="col-auto">
                        <select name="neighborhoodId">
                            <option selected>Select One</option>
                            <?php 
                                foreach($neighborhood as $row){ // the first is the array and the row is the element that is the subscripted
                                    $id = $row["id"];
                                    $name = $row["neighborhood"];
                                    echo "<option value=\"$id\">$name</option>";
                                }
                            ?>
                        </select>
                    </div>

                </div><!-- row -->

                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="RoomType" class="col-form-label">Room Type</label>
                    </div>

                    <div class="col-auto">
                    <select name="roomType">
                            <?php 
                                // var_dump($roomType);
                                foreach($roomType as $row){ // the first is the array and the row is the element that is the subscripted
                                    $type = $row["type"];
                                    $roomId = $row["id"];
                                    echo "<option value=\"$roomId\">$type</option>";
                                }
                            ?>
                        </select>
                    </div>

                </div>

                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="NumberOfGuests" class="col-form-label">Number of Guests</label>
                    </div>

                    <div class="col-auto">
                            <select name="noGuests">
                            <?php 
                                foreach($numberGuests as $row){ // the first is the array and the row is the element that is the subscripted
                                    $number = $row["accommodates"];
                                    echo "<option value=\"$number\">$number</option>";
                                }
                            ?>
                            </select>
                    </div>

                </div><!-- row -->

                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <input type="submit" id="submit" class="btn btn-primary" value="Submit">
                    </div>
                </div>
            
            </form>

        </div><!-- .container-->

    </div><!-- album-->

    </main>

    <footer class="text-muted py-5">
    <div class="container">

        <p class="mb-1">CS 293, Spring 2024</p>
        <p class="mb-1">Lewis & Clark College</p>
    </div><!-- .container-->
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    
</body>
</html>