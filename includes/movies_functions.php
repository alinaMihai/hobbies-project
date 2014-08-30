<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function getUserFilms($user_id) {
    global $connection;
    // query: select the books of the user
    $query = "SELECT *";
    $query .= "FROM users_films ";
    $query .= "WHERE `User`= ? ";
    $stmt = $connection->prepare($query);
    $user_films_array = $stmt->execute(array($user_id));
    confirm_query($user_films_array);
    $user_films = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($user_films as &$user_film) {

        $query = "SELECT * ";
        $query .= "FROM user_film_images ";
        $query .= "WHERE `UserFilm`= ? ";
        $query .= "LIMIT 1";
        $stmt = $connection->prepare($query);
        $film_image = $stmt->execute(array($user_film["Film"]));
        confirm_query($film_image);
        $user_film["image_url"] = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return $user_films;
}

function getImageUrl($imageId) {
    global $connection;

    $query = "SELECT Link ";
    $query .= "FROM images ";
    $query .= "WHERE `#I`= ? ";
    $stmt = $connection->prepare($query);
    $row = $stmt->execute(array($imageId));
    confirm_query($row);
    $image_url = $stmt->fetch(PDO::FETCH_ASSOC);
    return $image_url['Link'];
}


function displayFilmRating() {
    
}

function findFilmInfoByType($userId, $filmType) {
    global $connection;
    //select Film Name, Type, Rating, Review, Watched
    $query = "Select `#F`, Name, Type, Rating, Review, Watched ";
    $query .="From film_info ";
    $query .="INNER JOIN films ON  `#FI` = InfoFilm ";
    $query .="INNER JOIN film_type ON FilmType =  `#FT` ";
    $query .="INNER JOIN users_films ON  `#F` = Film ";
    $query .="WHERE users_films.`User` =? AND `Type`=? ";
    $query .="ORDER BY Type";
    $stmt = $connection->prepare($query);
    $film_info_result = $stmt->execute(array($userId, $filmType));
    confirm_query($film_info_result);
    $film_info_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $film_info_array;
}

function findWishListFilmInfoByType($user_id, $wishlist_film_type) {
    global $connection;
    //select wishlist film Name, Image, Comments, Priority
    $query = "Select `#FW`, Name, Image, Comments, Priority ";
    $query .="From film_wishlist ";
    $query .="INNER JOIN films ON  Film = `#F` ";
    $query .="INNER JOIN film_info ON InfoFilm =  `#FI` ";
    $query .="INNER JOIN film_type ON FilmType =  `#FT` ";
    $query .="WHERE User =? AND `Type`=? ";
    $query .="ORDER BY Type";
    $stmt = $connection->prepare($query);
    $wishlist_film_info_result = $stmt->execute(array($user_id, $wishlist_film_type));
    confirm_query($wishlist_film_info_result);
    $wishlist_film_info_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $wishlist_film_info_array;
}

function findUserFilmTypes($user_id) {
    global $connection;
    //select Film Name, Type, Rating, Review, Watched, isOnWishlist 
    $query = "Select DISTINCT Type ";
    $query .="From film_info ";
    $query .="INNER JOIN films ON  `#FI` = InfoFilm ";
    $query .="INNER JOIN film_type ON FilmType =  `#FT` ";
    $query .="INNER JOIN users_films ON  `#F` = Film ";
    $query .="WHERE users_films.`User` =?";
    $stmt = $connection->prepare($query);
    $film_types = $stmt->execute(array($user_id));
    confirm_query($film_types);
    $film_types_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $film_types_array;
}

function renderFilmsBoxes($user_id) {
    $user_films_types = findUserFilmTypes($user_id);
    $film_wishlist_types = findWishlistFilmsType($user_id);
    $all_film_types_array = array_unique(array_merge($user_films_types, $film_wishlist_types), SORT_REGULAR);

    $output = "";
    foreach ($all_film_types_array as $uf_type) {
        $output .="<h1>" . htmlentities(ucfirst($uf_type['Type'])) . "</h1>";
        $user_films_by_type = findFilmInfoByType($user_id, $uf_type['Type']);
        $wishlist_films_by_type = findWishListFilmInfoByType($user_id, $uf_type['Type']);
        //merge the two arrays of films user films and on wishlist
        $all_films_info_by_type_array = array_unique(array_merge($user_films_by_type, $wishlist_films_by_type), SORT_REGULAR);
        $output .=createFilmsBoxes($all_films_info_by_type_array);
    }

    return $output;
}

function createFilmsBoxes($all_films_info_array) {
    $output = "<div class='uk-grid' data-uk-grid-match=\"{target:'.uk-panel'}\" data-uk-grid-margin>";
    $index = 0; // make three by three rows;
    foreach ($all_films_info_array as $film) {
        //keep the grid to a 3 columns count
        if ($index > 2) {
            $output .="</div>";
            $output .= "<div class='uk-grid' data-uk-grid-match=\"{target:'.uk-panel'}\" data-uk-grid-margin>";
            $index = 0;
        }
        $output .="<div class='uk-width-1-3' style='width: 350px; '>";
        $output .="<div class='uk-panel uk-panel-box'>";
        $output .=renderFilmPreviewBox($film);
        $output .="</div>"; // close the panel box
        $output .="</div>"; //close the grid box
        $index++;
    }
    $output .= "</div>"; // close the grid	
    return $output;
}

function findWishlistFilmsType($user_id) {
    global $connection;
    //select Film Name, Type, Rating, Review, Watched, isOnWishlist 
    $query = "SELECT DISTINCT Type ";
    $query .="FROM film_wishlist ";
    $query .="INNER JOIN films ON  Film = `#F` ";
    $query .="INNER JOIN film_info ON InfoFilm =  `#FI` ";
    $query .="INNER JOIN film_type ON FilmType =  `#FT` ";
    $query .="WHERE User =? ";
    $query .="ORDER BY Type";
    $stmt = $connection->prepare($query);
    $film_wishlist_types = $stmt->execute(array($user_id));
    confirm_query($film_wishlist_types);
    $film_wishlist_types_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $film_wishlist_types_array;
}

function renderFilmPreviewBox($filmInfo) {
    if (isset($filmInfo['#F'])) {
        $output =renderUserFilmBox($filmInfo);

    } elseif (isset($filmInfo['#FW'])) {
        $output =renderWishlistFilmBox($filmInfo);
    }
    return $output;
}
function renderWishlistFilmBox($filmInfo){
    $f_image_path = "media/movie_images/";
    $output = "";
    $output .="<p>On Wishlist ";
    $output .="Edit";
    $output .="<span class='deleteBook'><a href='deleteFilm?id=" . $filmInfo['#FW'] . "'>X</a></span>";
    $output .="</p>";
    $output .= "<div class='uk-grid'>";
    $output .="<div class='uk-width-1-2'>";
    $output .="<a href='film?id=" . $filmInfo["#FW"] . "' class='boxLink'>";
    $output .="<span class='bookTitle'>" . $filmInfo['Name'] . "</span>";
    $output .="</a></div>"; // closed the first column;
    $output .="<div class='uk-width-1-2'>";
    $output .="<p class=\"filmImages\">";

    $output .="<img class='bookCover' src=\"" . $f_image_path . \rawurlencode($filmInfo["Image"]) . " \"/>";
    $output .="</p>";
    $output .="</div></div>"; //close the second column div and the grid
    $output .="<span class=\"FilmPriority\">";
    $output .="Priority ";
    $output .=$filmInfo['Priority'];
    $output .="</span>";
    $output .="<div class=\"FilmComments\">";
    $output .=$filmInfo['Comments'];
    $output .="</div>";
    return $output;
}
function renderUserFilmBox($filmInfo) {
    $f_image_path = "media/movie_images/";
    $output = "";
    $output .="<p>Watched ";
    $output .="Edit";
    $output .="<span class='deleteBook'><a href='deleteFilm?id=" . $filmInfo['#F'] . "'>X</a></span>";
    $output .="</p>";
    $output .= "<div class='uk-grid'>";
    $output .="<div class='uk-width-1-2'>";
    $output .="<a href='film?id=" . $filmInfo["#F"] . "' class='boxLink'>";
    $output .="<span class='bookTitle'>" . $filmInfo['Name'] . "</span>";
    $output .="</a></div>"; // closed the first column;
    $output .="<div class='uk-width-1-2'>";
    $output .="<p class=\"filmImages\">";

    $output .="</p>";
    $output .="</div></div>"; //close the second column div and the grid
    $output .="<span class=\"FilmRating\">";
    $output .=displayFilmRating();
    $output .="</span>";
    $output .="<div class=\"FilmReview\">";
    $output .=$filmInfo['Review'];
    $output .="</div>";
    return $output;
}

function renderFilmImages($user_films) {
    $f_image_path = "media/movie_images/";
    $output = "<ul style=\"list-style:none\" class=\"films_list\">";
    foreach ($user_films as $user_film) {
        $image_url = getImageUrl($user_film["image_url"]['image']);
        $output .= "<li><a href=\"films.php?film_id=" . urlencode($user_film['Film']) . "\"><img class='imagedropshadow' src=\"" . $f_image_path . $image_url . " \"/></a></li>";
    }
    $output .= "</ul>";
    return $output;
}
?>

