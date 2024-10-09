<?php 
  require_once('includes/functions.php'); 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cosmin Vasie</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <?php
            if(!in_array(basename($_SERVER['PHP_SELF']), array('contact.php', 'index.php'))) {
            $movies = json_decode(file_get_contents('./assets/movies-list-db.json'),true)['movies'];
          }

          $genres = json_decode(file_get_contents('./assets/movies-list-db.json'),true)['genres'];
    ?>
        <nav class="navbar navbar-expand-lg bg-body-tertiary header-navbar">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">CV</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <?php $menu_items = [
                    [
                      'title' => 'Home',
                      'link' => 'index.php'
                    ],
                    [
                      'title' => 'Movies',
                      'link' => 'movies.php'
                    ],
                    [
                      'title' => 'Contact',
                      'link' => 'contact.php'
                    ]
                  ]; 
                  
                  foreach($menu_items as $menu_item) { ?>
                    <li class="nav-item">
                      <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) === $menu_item['link']) echo 'active'; ?>" <?php if(basename($_SERVER['PHP_SELF']) === $menu_item['link']) echo 'aria-current="page"'; ?> href="<?php echo $menu_item['link']; ?>"><?php echo $menu_item['title']; ?></a>
                    </li>
                  <?php } ?>
                </ul>
                <?php include ('includes/search-form.php'); ?>
              </div>
            </div>
          </nav>

          <div class="container py-4">