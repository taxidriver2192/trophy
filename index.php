<?php
require("function.php");
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <title>A super cool map</title>

    <link rel="stylesheet" href="node_modules/leaflet/dist/leaflet.css"/>
    <script src="node_modules/leaflet/dist/leaflet-src.js"></script>

    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timer.jquery/0.7.0/timer.jquery.js"></script>

    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="src/css/style.css"/>

</head>

<body class="full-width">
<div class="container-fluid">
    <div class="infoPlacholder">
        <div id="timer">0 sec</div>
        <div id="kmLeft"><p>Tryk på piletasterne for at starte</p></div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div id="map"></div>
        </div>
        <div class="col-lg-4 navigation">
            <div class="content">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Leaderboard
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#login"
                                type="button" role="tab" aria-controls="profile" aria-selected="false">Login
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                type="button" role="tab" aria-controls="contact" aria-selected="false">Opret Bruger
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#debug"
                                type="button" role="tab" aria-controls="contact" aria-selected="false">debug
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
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
                    </div>
                    <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="profile-tab">

                        <div class="container">
                            <form>
                                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Email address</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                    <label for="floatingPassword">Password</label>
                                </div>

                                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                                <p class="mt-5 mb-3 text-muted">© 2017–2022</p>
                            </form>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="debug" role="tabpanel" aria-labelledby="contact-tab">
                        <h2>Debug after finish game</h2>
                        <div class="log" id="log"></div></div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                </div>
            </div>
        </div>
    </div>

    <script>

        user_id = 1

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
                alert("Tillykke Users.ID = " + user_id + " og det tog " + $("#timer").data('seconds') + " Sekunder!")
                // BackToStart my friend.
                yourCordiant_lat = $start_lat;
                yourCordiant_lon = $start_lon;
                map.panTo(new L.LatLng(yourCordiant_lat, yourCordiant_lon));

                // post game to database.
                // I am not prod of this solution but okay...
                setTime = $("#timer").data('seconds');
                $("#timer").timer('remove');

                var request = $.ajax({
                    url: "uploadGame.php",
                    method: "POST",
                    data: {
                        'user_id': user_id,
                        'time': setTime
                    },
                    dataType: "html"
                });

                request.done(function (msg) {
                    $("#log").html(msg);
                });

                request.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });

            }

            var tomatoIcon = L.icon({
                iconUrl: 'src/img/tomato.png',
                iconSize: [32, 32],
            });

            map.panTo(new L.LatLng(yourCordiant_lat, yourCordiant_lon));
            L.marker([yourCordiant_lat, yourCordiant_lon], {icon: tomatoIcon}).addTo(map);

            // L.marker([yourCordiant_lat, yourCordiant_lon]).addTo(map);
            $("#kmLeft p").replaceWith("<p>" + getDistanceFromLatLonInKm(yourCordiant_lat, yourCordiant_lon, $nestved_lat, $nestved_lon).toFixed(2) + " km til næstved</p>");
        });


    </script>

</div>


<script src="src/js/main.js"></script>

</body>
</html>