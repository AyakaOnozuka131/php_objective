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
        <h2 class="start_heading">ゲームオーバー</h2>
        <p class="gameover_lead">遊んでくれてありがとうございました！</p> 
        <div class="gameover_img"><img src="/assets/images/use/gameover.png" alt=""></div>
        <div class="getItem">
          <p class="getItem_text"><i class="fas fa-syringe"></i>手に入れた血:<?php echo $_SESSION['knockDownCount']?>コ</p>
        </div> 
     </div>
  </main>
  <footer>
      <small>鬼滅の刃ゲーム</small>
  </fotter>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(function () {
      var $ftr = $('footer');
      if(window.innerHeight > $ftr.offset().top + $ftr.outerHeight() ){
        $ftr.attr({'style':'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) + 'px;'});
      }
    });
  </script>
</body>
</html>