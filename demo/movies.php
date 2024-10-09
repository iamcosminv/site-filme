<?php require_once('includes/header.php'); ?>
<?php 
if(isset($_GET['genre']) && in_array($_GET['genre'], $genres)){
  $movie_list = array_filter($movies, 'find_movies_by_genre');
  $title_before = $_GET['genre'] . ' ';
  }else {
    $movie_list = $movies;
    $title_before = '';
  } 
?>

<h1><?php echo $title_before; ?>Movies</h1>
  <div class="row movies-list">
    <?php 
      foreach($movie_list as $movie_key => $movie) { ?>
        <div class="col-md-4 mb-4" id="movie-<?php echo $movie['id']; ?>">
          <?php require('includes/archive-movie.php'); ?>
        </div>
        <?php } ?>
  </div>
<?php require_once('includes/footer.php'); ?>      