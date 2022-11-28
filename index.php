<?php
require("function.php");
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <title>A super cool map</title>

    <link rel="stylesheet" href="node_modules/leaflet/dist/leaflet.css"/>
    <script src="node_modules/leaflet/dist/leaflet-src.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!--
    https://github.com/walmik/timer.jquery
    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timer.jquery/0.7.0/timer.jquery.js"></script>

    <!--
   Boodstrap
   -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
    <!--
   Main
   -->
    <link rel="stylesheet" href="css/style.css"/>


</head>

<body class="full-width">
<div class="wrapper">
    <div id="map"></div>

    <div class="infoPlacholder">
        <div id="timer"></div>
        <div id="kmLeft"><p>Tryk på piletasterne for at starte</p></div>
    </div>
    <!--
    NOT DONE FEATURE
    <button id="user" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        user
    </button>
    -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Usernames</th>
            <th scope="col">Antal Games</th>
            <th scope="col">Best Time</th>
            <th scope="col">Best Score</th>
        </tr>
        </thead>
        <tbody>
        <?php
        echo getUsers();
        ?>
        </tbody>
    </table>
    <!-- Modal -->
    <!--
 NOT DONE FEATURE
 <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Velkommen til GeoGame</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <p>Her har du mulighed for at skifte bruge, skriv det `ID` du vil skifter bruger til.</p>
                 <div class="input-group mb-3">
                     <span class="input-group-text" id="basic-addon1">@</span>
                     <input type="number" id="changeUser" class="form-control" placeholder="changeUser">
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button type="button" id="save_user" class="btn btn-primary" data-bs-dismiss="modal">Understood
                 </button>
             </div>
         </div>
     </div>
 </div>
 -->

    <script>


        // https://www.movable-type.co.uk/scripts/latlong.html
        // Nøreport
        $start_lat = 55.683781;
        $start_lon = 12.571596;

        // startCordinator
        yourCordiant_lat = 55.683781;
        yourCordiant_lon = 12.571596;

        // Næstved
        $nestved_lat = 55.232816;
        $nestved_lon = 11.767130;
        // Distance:	71.32 km

        $down_key = 40;
        $right_key = 39;
        $top_key = 38;
        $left_key = 37;

        $speed = 0.03;


        $("body").keydown(function (e) {
            // Checker om model er oppe
            $("#timer").timer();

            // TEST USER.
            username = 1;


            if (e.keyCode === $left_key) {
                yourCordiant_lon -= $speed;
                console.log(getDistanceFromLatLonInKm(yourCordiant_lat, yourCordiant_lon, $nestved_lat, $nestved_lon))

            } else if (e.keyCode === $right_key) {
                yourCordiant_lon += $speed;
                console.log(getDistanceFromLatLonInKm(yourCordiant_lat, yourCordiant_lon, $nestved_lat, $nestved_lon))
            } else if (e.keyCode === $top_key) {
                yourCordiant_lat += $speed;
                console.log(getDistanceFromLatLonInKm(yourCordiant_lat, yourCordiant_lon, $nestved_lat, $nestved_lon))
            } else if (e.keyCode === $down_key) {
                yourCordiant_lat -= $speed;
                console.log(getDistanceFromLatLonInKm(yourCordiant_lat, yourCordiant_lon, $nestved_lat, $nestved_lon))
            }
            if (getDistanceFromLatLonInKm(yourCordiant_lat, yourCordiant_lon, $nestved_lat, $nestved_lon) <= 0.5) {
                //leaves the display intact
                alert("Tillykke Users.ID = " + username + " og det tog " + $("#timer").data('seconds') + " Sekunder!")
                // BackToStart my friend.
                yourCordiant_lat = $start_lat;
                yourCordiant_lon = $start_lon;
                map.panTo(new L.LatLng(yourCordiant_lat, yourCordiant_lon));

                // post game to database.
                // I am not prod of this solution but okay...
                setTime = $("#timer").data('seconds');
                $("#timer").timer('remove');

                <?php
                $correntUser = "document.write(username)";
                $time = "document.write(setTime)";
                $score = rand(0,99);

                // STOPING HERE.
                saveGame($correntUser, $time, $score);
                ?>

            }
            map.panTo(new L.LatLng(yourCordiant_lat, yourCordiant_lon));
            var marker = L.marker([yourCordiant_lat, yourCordiant_lon]).addTo(map);
            $("#kmLeft p").replaceWith("<p>" + getDistanceFromLatLonInKm(yourCordiant_lat, yourCordiant_lon, $nestved_lat, $nestved_lon).toFixed(2) + " km til næstved</p>");

            // More time 
            // I would like to make a score system out of travel length vs fastes route
        });

    </script>

</div>

<script src="js/main.js"></script>

</body>
</html>