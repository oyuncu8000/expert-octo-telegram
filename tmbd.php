<?php
session_start();

$api_key = "d220bce37ab5c480799c5b880cd14dac";
$search_query = isset($_GET['search']) ? $_GET['search'] : "";

// Favori ekleme
if(isset($_GET['fav'])) {
    $movie_id = $_GET['fav'];
    $_SESSION['favorites'][$movie_id] = true;
}

// API URL
if($search_query != "") {
    $url = "https://api.themoviedb.org/3/search/movie?api_key=$api_key&language=tr-TR&query=".urlencode($search_query);
} else {
    $url = "https://api.themoviedb.org/3/movie/popular?api_key=$api_key&language=tr-TR&page=1";
}

$response = file_get_contents($url);
$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>WoxPlus Filmler</title>
<style>
body { 
    font-family: 'Arial', sans-serif; 
    background: linear-gradient(135deg, #0ff, #f0f, #ff0); 
    margin:0; 
    color:#fff; 
    overflow-x:hidden;
}

h1 { text-align:center; margin-top:20px; text-shadow:0 0 10px #0ff,0 0 20px #f0f; }

.search { text-align:center; margin:20px; }
input[type=text] { padding:10px; width:300px; border-radius:20px; border:none; background:#222; color:#fff; box-shadow:0 0 10px #0ff; outline:none; }
button { padding:10px 20px; border:none; border-radius:20px; margin-left:5px; background:#f0f; color:#fff; cursor:pointer; box-shadow:0 0 10px #f0f; }

.slider-container { position:relative; padding:20px; }
.slider { display:flex; overflow-x:auto; scroll-behavior:smooth; gap:15px; padding-bottom:20px; }
.movie { flex:0 0 auto; width:180px; background:#111; border-radius:15px; padding:10px; 
         box-shadow:0 0 15px #0ff; transform-style: preserve-3d; transition: transform 0.3s; cursor:pointer; }
.movie:hover { transform: rotateY(12deg) scale(1.05); }
img { width:100%; height:auto; border-radius:10px; }
.title { font-weight:bold; margin:10px 0 5px; font-size:14px; }
.overview { font-size:12px; height:50px; overflow:hidden; }
.vote { margin:5px 0; font-size:13px; }
.fav { display:block; text-align:center; background:red; padding:4px 8px; border-radius:10px; text-decoration:none; color:white; margin-top:5px; font-size:13px; }
.favorited { display:block; text-align:center; background:green; padding:4px 8px; border-radius:10px; color:white; margin-top:5px; font-size:13px; }

.arrow { position:absolute; top:50%; transform:translateY(-50%); font-size:28px; cursor:pointer; color:#fff; text-shadow:0 0 5px #0ff; z-index:10; user-select:none; }
.arrow-left { left:5px; }
.arrow-right { right:5px; }

/* Mobil uyum */
@media screen and (max-width:600px){
    .movie { width:140px; }
    .overview { height:40px; font-size:11px; }
    .title { font-size:12px; }
    .vote { font-size:11px; }
}
</style>
</head>
<body>

<h1>🎬 WoxPlus Filmleri</h1>

<div class="search">
    <form method="GET">
        <input type="text" name="search" placeholder="Film Ara..." value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit">🔍 Ara</button>
    </form>
</div>

<div class="slider-container">
    <div class="arrow arrow-left" onclick="scrollSlider(-300)">&#10094;</div>
    <div class="arrow arrow-right" onclick="scrollSlider(300)">&#10095;</div>

    <div class="slider" id="slider">
        <?php foreach($data['results'] as $movie): ?>
        <div class="movie" onclick="window.location='detail.php?id=<?php echo $movie['id']; ?>'">
            <img src="https://image.tmdb.org/t/p/w500<?php echo $movie['poster_path']; ?>" alt="<?php echo $movie['title']; ?>">
            <div class="title"><?php echo $movie['title']; ?></div>
            <div class="overview"><?php echo $movie['overview']; ?></div>
            <div class="vote">⭐ <?php echo $movie['vote_average']; ?></div>

            <?php if(isset($_SESSION['favorites'][$movie['id']])): ?>
                <span class="favorited">✔ Favorilere Eklendi</span>
            <?php else: ?>
                <a class="fav" href="?fav=<?php echo $movie['id']; ?>&search=<?php echo urlencode($search_query); ?>">❤️ Favorilere Ekle</a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function scrollSlider(value){
    document.getElementById('slider').scrollBy({left: value, behavior:'smooth'});
}
</script>

</body>
</html>