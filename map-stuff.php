<?
$lat1 = "55.677855";
$lon1 = "12.569008";
$lat2 = "55.677922";
$lon2 = "12.571465";
$lat3 = "55.677069";
$lon3 = "12.571208";
$lat4 = "55.677057";
$lon4 = "12.568837";

$str = '{ "type": "FeatureCollection",
            "features": [
                { "type": "Feature",
                    "geometry": {
                        "type": "Polygon",
                        "coordinates": [
                            [ 
                                ['.$lat1.', '.$lon1.'],
                                ['.$lat2.', '.$lon2.'],
                                ['.$lat3.', '.$lon3.'],
                                ['.$lat4.', '.$lon4.']
                            ]
                        ]

                    },
                    "properties": {
                        "prop0": "value0",
                        "prop1": {"this": "that"}
                    }
                }
            ]
        }';




function ownGeoJson($str) {
    return "JSON.parse(".json_encode($str).");";
}


