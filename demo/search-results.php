<?php require_once('includes/header.php'); ?>
<?php if(isset($_GET['s']) && strlen($_GET['s']) >= 3){ ?>
    <h1>
        Search results for: <strong><?php echo $_GET['s']; ?></strong>
    </h1>
    <?php include ('includes/search-form.php'); ?>
    <?php $filtered_movies = array_filter($movies, 'find_movie_by_title'); ?>

    <?php if(count($filtered_movies) === 0){ ?>
        <P>No results</P>
    <?php }else { ?>
        <div class="row movie-list mt-5">
            <?php foreach($filtered_movies as $movie){
                require('includes/archive-movie.php');
            }?>
        </div>
    <?php } ?>

<?php }elseif(isset($_GET['s']) && strlen($_GET['s']) < 3){ ?>
    <h1>Invalid search</h1>
    <p>Too short searching word!</p>
    <?php include ('includes/search-form.php'); ?>
<?php }else { ?>
    <h1>Invalid search</h1>
    <p>Try something else!</p>
    <?php include ('includes/search-form.php'); ?>
<?php } ?>
<?php require_once('includes/footer.php'); ?>