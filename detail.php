<?php
session_start();
$api_key = "d220bce37ab5c480799c5b880cd14dac";

if(!isset($_GET['id'])) {
    echo "Film ID eksik!";
    exit;
}

$movie_id = $_GET['id'];
$url = "https://api.themoviedb.org/3/movie/$movie_id?api_key=$api_key&language=tr-TR";
$response = file_get_contents($url);
$movie = json_decode($response,true);

// Favori ekleme
if(isset($_GET['fav'])) {
    $_SESSION['favorites'][$movie_id] = true;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title><?php echo $movie['title']; ?></title>
<style>
body { font-family: 'Arial'; background: linear-gradient(135deg, #0ff, #f0f, #ff0); color:#fff; padding:20px;}
.container { display:flex; gap:20px; flex-wrap:wrap; }
img { width:300px; border-radius:10px; box-shadow:0 0 20px #0ff; }
.details { max-width:600px; }
h1 { text-shadow:0 0 10px #0ff,0 0 20px #f0f; }
.vote { margin:10px 0; font-weight:bold; }
.fav { display:inline-block; background:red; padding:10px 20px; border-radius:10px; text-decoration:none; color:white; margin-top:10px;}
.favorited { display:inline-block; background:green; padding:10px 20px; border-radius:10px; margin-top:10px; }
</style>
</head>
<body>

<div class="container">
    <img src="https://image.tmdb.org/t/p/w500<?php echo $movie['poster_path']; ?>" alt="<?php echo $movie['title']; ?>">
    <div class="details">
        <h1><?php echo $movie['title']; ?></h1>
        <div class="vote">⭐ <?php echo $movie['vote_average']; ?></div>
        <p><?php echo $movie['overview']; ?></p>

        <?php if(isset($_SESSION['favorites'][$movie_id])): ?>
            <span class="favorited">✔ Favorilere Eklendi</span>
        <?php else: ?>
            <a class="fav" href="?id=<?php echo $movie_id; ?>&fav=1">❤️ Favorilere Ekle</a>
        <?php endif; ?>
    </div>
</div>

<a href="index.php" style="display:block;margin-top:20px;color:#0ff;">⬅ Geri</a>

</body>
</html>