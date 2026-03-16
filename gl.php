<?php
/**
 * SuperApp - Learning Algorithm Edition
 * Beğeniye göre içerik önerme sistemi.
 */

$API_KEY = 'AIzaSyCEtL-qhEgCPmO_cXPiaA_0x3tKRUOdQgg'; 

// Kullanıcının tercihini simüle etmek için (PHP tarafında ilk yükleme)
$base_queries = ['Beavis and Butt-Head shorts', 'Adult Swim edits shorts', 'Anime fight shorts', 'Cartoon Network shorts'];
$q = urlencode($base_queries[array_rand($base_queries)] . " funny action edit");

$api_url = "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=15&q={$q}&type=video&videoDuration=short&key={$API_KEY}";
$data = json_decode(@file_get_contents($api_url), true);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>AI Powered Shorts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body, html { margin: 0; padding: 0; height: 100%; background: #000; overflow: hidden; font-family: sans-serif; }
        .swiper { width: 100%; height: 100vh; }
        .swiper-slide { position: relative; background: #000; }
        
        .video-container { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; }
        iframe { width: 100%; height: 100%; pointer-events: none; transform: scale(1.1); } /* Kenar boşluklarını yok etmek için hafif zoom */
        
        .swipe-handler { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 5; }

        .ui-layer {
            position: absolute; bottom: 0; left: 0; width: 100%;
            padding: 120px 20px 50px;
            background: linear-gradient(transparent, rgba(0,0,0,0.9));
            color: white; z-index: 10; pointer-events: none;
        }

        .side-bar {
            position: absolute; right: 15px; bottom: 180px;
            display: flex; flex-direction: column; gap: 30px; pointer-events: auto;
        }

        .side-icon { color: white; transition: transform 0.2s; cursor: pointer; text-align: center; }
        .side-icon i { font-size: 32px; }
        .side-icon.liked i { color: #FF0050; }
        .side-icon:active { transform: scale(1.3); }

        #loader {
            position: fixed; top:0; left:0; width:100%; height:100%;
            background:#000; z-index:9999; display:flex; align-items:center; justify-content:center;
        }
        .start-btn {
            padding: 18px 45px; background: linear-gradient(45deg, #FF0050, #9000FF);
            color: white; border: none; border-radius: 40px; font-weight: bold; font-size: 20px;
            box-shadow: 0 4px 15px rgba(255, 0, 80, 0.4);
        }
    </style>
</head>
<body>

<div id="loader">
    <button class="start-btn" onclick="initApp()">KEŞFETMEYE BAŞLA</button>
</div>

<div class="swiper">
    <div class="swiper-wrapper">
        <?php if(isset($data['items'])): foreach($data['items'] as $item): 
            $id = $item['id']['videoId'];
            $title = $item['snippet']['title'];
        ?>
            <div class="swiper-slide" data-id="<?= $id ?>" data-title="<?= htmlspecialchars($title) ?>">
                <div class="video-container"><div id="player-<?= $id ?>"></div></div>
                <div class="swipe-handler" ondblclick="likeVideo('<?= $id ?>')"></div>
                
                <div class="ui-layer">
                    <div class="side-bar">
                        <div class="side-icon" id="like-<?= $id ?>" onclick="likeVideo('<?= $id ?>')">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="side-icon"><i class="fas fa-comment"></i></div>
                        <div class="side-icon"><i class="fas fa-share"></i></div>
                    </div>
                    <h3 style="margin-bottom:5px;">@PrimeAnimasyon</h3>
                    <p style="font-size: 14px; opacity: 0.9;"><?= htmlspecialchars($title) ?></p>
                </div>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>

<script src="https://www.youtube.com/iframe_api"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    let players = {};
    let likedVideos = JSON.parse(localStorage.getItem('likedVideos')) || [];

    // Beğeni Fonksiyonu
    function likeVideo(id) {
        const btn = document.getElementById('like-' + id);
        const slide = document.querySelector(`[data-id="${id}"]`);
        const title = slide.dataset.title;

        if (!likedVideos.includes(id)) {
            likedVideos.push(id);
            btn.classList.add('liked');
            
            // Algoritmayı eğit: Başlıktaki kelimeleri kaydet
            let keywords = title.toLowerCase().split(' ').filter(w => w.length > 3);
            let prefs = JSON.parse(localStorage.getItem('userPrefs')) || [];
            localStorage.setItem('userPrefs', JSON.stringify([...new Set([...prefs, ...keywords])]));
            
            localStorage.setItem('likedVideos', JSON.stringify(likedVideos));
        } else {
            // Beğeniyi geri çek
            likedVideos = likedVideos.filter(v => v !== id);
            btn.classList.remove('liked');
            localStorage.setItem('likedVideos', JSON.stringify(likedVideos));
        }
    }

    // Video Oynatıcı Kontrolü
    function createPlayer(vId) {
        if (!players[vId]) {
            players[vId] = new YT.Player('player-' + vId, {
                videoId: vId,
                playerVars: { 'autoplay': 1, 'controls': 0, 'modestbranding': 1, 'loop': 1, 'playlist': vId },
                events: { 'onReady': (e) => { e.target.playVideo(); e.target.unMute(); } }
            });
        } else {
            players[vId].playVideo();
            players[vId].unMute();
        }
    }

    const swiper = new Swiper('.swiper', {
        direction: 'vertical',
        on: {
            slideChange: function () {
                Object.values(players).forEach(p => p.pauseVideo && p.pauseVideo());
                const currentId = this.slides[this.activeIndex].dataset.id;
                createPlayer(currentId);
                
                // Daha önce beğenilmişse kırmızı yap
                if (likedVideos.includes(currentId)) {
                    document.getElementById('like-' + currentId).classList.add('liked');
                }
            }
        }
    });

    function initApp() {
        document.getElementById('loader').style.display = 'none';
        createPlayer(swiper.slides[0].dataset.id);
    }

    function onYouTubeIframeAPIReady() {}
</script>
</body>
</html>