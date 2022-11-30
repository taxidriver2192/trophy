<?php
// https://github.com/dcblogdev/pdo-wrapper
// Haven't used this befor, but it is close to what i am using today at my work.
use Dcblogdev\PdoWrapper\Database;

$options = [
    //required
    'username' => 'root',
    'database' => 'leaderboard',
    //optional
    'password' => 'root',
    'type' => 'mysql',
    'charset' => 'utf8',
    'host' => 'localhost',
    'port' => '3309'
];
// m

require("src/Database.php");

// Funktion debugging.
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function setUser($id){
    // make a connection to mysql here
    global $options;
    $db = new Database($options);
    $currentUser = $db->getById('Users', 1);
    $currentUserLogin = $currentUser->id;
    echo $currentUserLogin;
    return($currentUser);
}

function getUsers()
{
    // make a connection to mysql here
    global $options;
    $db = new Database($options);
    $users = $db->rows("SELECT id, username FROM leaderboard.Users ORDER BY id DESC");
    $html = "";

    foreach ($users as $user) {
        $html .= "<tr>";
        $html .= "<td>$user->id</td>";
        $html .= "<td>$user->username</td>";

        $playedGamesUser = $db->count("SELECT Games.id FROM leaderboard.Games where user_id = $user->id");
        $html .= "<td>$playedGamesUser</td>";
        $BestGameUserID = $db->run("SELECT Games.user_id, Games.score, Games.time FROM leaderboard.Games where Games.user_id = $user->id order by score DESC LIMIT 1")->fetch();;
        //dd($BestGameID);
        //  $bestTimes = $db->rows("SELECT id, score, time FROM leaderboard.Game where id = $BestGameID");
        $html .= "<td>". $BestGameUserID['time']."</td>";
        $html .= "<td>". $BestGameUserID['score']."</td>";

        $html .= "</tr>";
    }
    //dd($html);
    return $html;
}



function saveGame($currentUser, $time, $score){

}


