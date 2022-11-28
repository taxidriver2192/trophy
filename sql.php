<?php
// Haven't uses this so moth.
// This is here where I will store the SQL.


//create table
//    $db->raw("CREATE TABLE demo (id int auto_increment primary key, name varchar(255))");

//use PDO directly
//    $db->getPdo()->query('Select username FROM users')->fetchAll();

//use run to query and chain methods
//    $db->run("SELECT * FROM users")->fetch();
//    $db->run("SELECT * FROM users WHERE id = ?", [$id])->fetch();
//select using array instead of object
//   $db->run("SELECT * FROM users")->fetch(PDO::FETCH_ASSOC);

//get by id
//    $db->getById('users', 2);

//get all rows
//    $db->rows("SELECT title FROM posts");
//get all rows with placeholders
//    $db->rows("SELECT title FROM posts WHERE user_id = ?", [$user_id]);

//get single row
//    $db->row("SELECT title FROM posts");
//get single row with placeholders
//    $db->row("SELECT title FROM posts WHERE user_id = ?", [$user_id]);

//count
//    $db->count("SELECT id FROM posts");
//    $db->count("SELECT id FROM posts WHERE category_id = ?", [$category_id]);

//insert
//    $id = $db->insert('users', ['username' => 'Dave', 'role' => 'Admin']);

//last inserted id
//    $db->lastInsertId()();
//update
//    $db->update('users', ['role' => 'Editor'], ['id' => 3]);

//delete from table with a where claus and a limit of 1 record
//    $db->delete('posts', ['type_id' => 'draft'], $limit = 1);

//delete from table with a where claus and a limit of 10 record
//    $db->delete('posts', ['type_id' => 'draft'], $limit = 10);

//delete all from table with a where claus and a limit of 10 record
//    $db->delete('posts', ['type_id' => 'draft'], null);

//delete all from table
//    $db->deleteAll('posts');

//delete by id from table
//    $db->deleteById('posts', 2);

//delete by ids from table
//    $db->deleteById('posts', '2,4,7');

//truncate table
//    $db->truncate('posts');

//    $users = $db->run("SELECT firstName, lastName, username FROM leaderboard.Users ORDER BY id DESC")->fetchAll();
//    foreach ($users as $user) {
//        echo "
//            <tr>
    //                <td>$user->firstName</td>
    //                <td>$user->lastName</td>
    //                <td>$user->username</td>
    //            </tr>
//        ";
//    }