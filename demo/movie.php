<?php require_once('includes/header.php'); 
  $filePath = 'assets/movie-favorites.json';
  $runtime_in_minutes = 120;
  $pretty_runtime = runtime_prettier($runtime_in_minutes);
?>
<?php 
$movies_filtered = array_filter($movies, 'find_movie_by_id');
if(isset($movies_filtered) && $movies_filtered){
  $movie = reset($movies_filtered);
}
?>
<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['titlu_film'])) {
    $titlu_film_post = $_POST['titlu_film'];
  } else {
    $titlu_film_post = null;
  }
  if(isset($_POST['favorite_action'])) {
    $favorite_action = $_POST['favorite_action'];
  } else {
    $favorite_action = null;
  }

  if(isset($_GET['id'])) {
    $film_id = $_GET['id'];
  } else {
    $film_id = null;
  }

  if($titlu_film_post && $favorite_action !==null) {
    if($favorite_action == '1') {
      echo "<p>Film '$titlu_film_post' adaugat la favorite! </p>";

      if(isset($_COOKIE['favorite_movies'])) {
        $favorite_movies = json_decode($_COOKIE['favorite_movies'], true);
      } else {
        $favorite_movies = [];
      }

      if(!in_array($film_id, $favorite_movies)) {
        $favorite_movies[] = $film_id; 
      }

      setcookie('favorite_movies', json_encode($favorite_movies), time() + (365 * 24 * 60 * 60 ), "/");

    } elseif($favorite_action == '0') {
      echo "<p>Film '$titlu_film_post' sters din favorite! </p>";

      if(isset($_COOKIE['favorite_movies'])) {
        $favorite_movies = json_decode($_COOKIE['favorite_movies'], true);
        
        if(($key = array_search($film_id, $favorite_movies)) !== false ) {
          unset($favorite_movies[$key]);
        }
        setcookie('favorite_movies', json_encode(array_values($favorite_movies)), time() + (365 * 24 * 60 * 60));
      }
      removeFromFavorites($film_id);
    }
  } else {
    echo "<p>Eroare!Datele nu au fost transmise corect!</p>";
  }
}
?>
<?php 
  function addToFavorites($movieId) {
    global $filePath;

    if(!file_exists($filePath)) {
      $favorites = [];
    } else {
      $fileContent = file_get_contents($filePath);

      $favorites = json_decode($fileContent, true);
      if(!is_array($favorites)) {
        $favorites = [];
      }
    }
    if(isset($favorites[$movieId])) {
      $favorites[$movieId]++;
    } else {
      $favorites[$movieId] = 1;
    }
    $newJsonContent = json_encode($favorites, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $newJsonContent);
  }
  $movieId = 17;
  addToFavorites($movieId);
?>
<?php
function removeFromFavorites($movieId) {
  $filePath = 'assets/movie-favorites.json';

  if(!file_exists($filePath)) {
    $fileContent = file_get_contents($filePath);
    $favorites = json_decode($fileContent, true);
    if(is_array($favorites) && isset($favorites[$movieId])) {
      if($favorites[$movieId] > 1) {
        $favorites[$movieId]--;
      } else {
        unset($favorites[$movieId]);
      }

      file_put_contents($filePath, json_encode($favorites, JSON_PRETTY_PRINT));
    }
  }
}
?>
<?php 
  function getFavoritesCount($movieId) {
    $filePath = 'assets/movie-favorites.json';

    if(file_exists($filePath)) {
      $fileContent = file_get_contents($filePath);
      $favorites = json_decode($fileContent, true);
      if(is_array($favorites) && isset($favorites[$movieId])) {
        return($favorites[$movieId]);
      }
    }
    return 0;
  }
?>
<?php if(isset($movie) && $movie){ 
  $is_favorite = false;
  if(isset($_COOKIE['favorite_movies'])) {
    $favorite_movies = json_decode($_COOKIE['favorite_movies'], true);
    $is_favorite = in_array($_GET['id'], $favorite_movies);
  }
?>
<?php
  if(isset($movies_filtered) && $movies_filtered) {
    $movie = reset($movies_filtered);
    $favoritesCount = getFavoritesCount($movie['id']);
  }
?>
<h1><?php echo $movie['title']; ?>
  <form action="" method="POST">
  <input type="hidden" name="titlu_film" value="<?php echo $movie['title'] ?>">
  <input type="hidden" name="favorite_action" value="1">
  <button type="submit" class="btn btn-primary">Adauga la favorite</button>
  <span class="badge bg-secondary"><?php echo $favoritesCount; ?></span>
  </form>
</h1>
 <div class="row">
    <div class="col-md-4 col-lg-3">
      <img class="card-img-top" src="<?php echo $movie['posterUrl']; ?>" alt="<?php echo $movie['title']; ?>">
    </div>
    <div class="col-md-8 col-lg-9">
      <?php $old_movie = check_old_movie($movie['year']); ?>
      <div class="h3">
        <?php echo $movie['year']; ?>
        <?php if($old_movie) { ?>
          <span class="badge rounded-pill text-bg-warning">Old Movie: <?php echo $old_movie; ?> years</span>
        <?php } ?>
      </div>
      <div class="description mb-3">
        <?php echo $movie['plot']; ?>
      </div>
      <div class="mb-3">
        Genres: <strong><?php echo implode(', ', $movie['genres']); ?></strong>
      </div>
      <div class="mb-3">
        Directed by: <strong>James Cameron</strong><br/>
      </div>
      <div class="mb-3"> 
        Runtime: <strong><?php echo $pretty_runtime; ?></strong>
      </div>
        <h3>Cast:</h3>
          <ul>
            <?php $actors = explode(', ', $movie['actors']); 
            foreach($actors as $actor){
              echo '<li>' . $actor . '</li>';
            } ?>
          </ul>
      </div>
    </div>
<?php }else{ ?>
  <h1>
    Movie page
  </h1>
  <p>
    Error! No movie found!
  </p>
  <a href="movies.php" class="btn btn-primary">
    Back to all movies
  </a>
<?php } ?>
</div>
<?php require_once('includes/footer.php'); ?>