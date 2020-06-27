<?php require('function.php');?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200;300;400;500;600;700;900&display=swap" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

  <!-- css -->
  <link rel="stylesheet" href="/assets/css/style.css">

  <title>オブジェクト指向部</title>

</head>
<body>
  <header>
    <h1 class="main_heading">
      鬼滅の刃ゲーム
    </h1>
  </header>
  <main>
     <div class="l-content">
     <?php if(empty($_SESSION)){ ?>
        <h2 class="start_heading">ゲームスタート</h2>
          <form action="" method="POST">
            <input type="submit" name="start" value="▶ゲームスタート" class="start_btn">
          </form>
        <?php }else{ ?>
          <div class="demon_area">
          <div class="c-img"><img src="<?php echo $_SESSION['demons']->getImg();?>" alt=""><p class="hit_point">HP：<?php echo $_SESSION['demons']->getHp();?></p></div>
          <div class="log">
            <div class="history js-scroll-area">
              <?php echo (!empty($_SESSION['history'])) ? $_SESSION['history'] : '';?>
            </div>
          </div>
        </div>
        <div class="hero_area">
          <div class="c-img"><img src="/assets/images/use/player.jpg" alt=""><p class="hit_point">HP：<?php echo $_SESSION['human']->getHp();?></p></div>
          <form class="command_area" method="POST" action="">
            <input type="submit" name="water" value="水の呼吸" class="water c-command">
            <input type="submit" name="sun" value="日の呼吸" class="sun c-command">
            <input type="submit" name="escape" value="逃げる" class="escape c-command">
          </form>
        </div>
       <div class="getItem">
        <p class="getItem_text"><i class="fas fa-syringe"></i>手に入れた血:<?php echo $_SESSION['knockDownCount']?>コ</p>
      </div>
      <?php } ?>
     </div>
  </main>
  <footer>
      <small>鬼滅の刃ゲーム</small>
  </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(function () {
      // フッター固定
      var $ftr = $('footer');
      if(window.innerHeight > $ftr.offset().top + $ftr.outerHeight() ){
        $ftr.attr({'style':'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) + 'px;'});
      }
      // スクロールエリア
      var $scrollAuto = $('.js-scroll-area');
      $scrollAuto.animate({scrollTop: $scrollAuto[0].scrollHeight},'slow');
    });
  </script>
</body>
</html>