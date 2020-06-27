<?php

ini_set('log_errors','on'); //ログを取るか
ini_set('error_log','php.log');
session_start();

$demons = array();
// モンスター識別クラス
class Individual{
  const HANTENG = 1;
  const GYOKKO = 2;
  const KOKUSHIBOU = 3;
  const DOMA = 4;
  const AKAZA = 5;
  const KAIGAKU = 6;
}
// 抽象クラス（生き物クラス）
abstract class Creature{
  protected $name;
  protected $hp;
  protected $attackMin;
  protected $attackMax;
  abstract public function sayCry();
  public function setName($str){
    $this->name = $str;
  }
  public function getName(){
    return $this->name;
  }
  public function setHp($num){
    $this->hp = $num;
  }
  public function getHp(){
    return $this->hp;
  }
  public function attack($targetObj){
    $attackPoint = mt_rand($this->attackMin, $this->attackMax);
    if(!mt_rand(0,9)){
      $attackPoint = $attackPoint * 1.5;
      $attackPoint = (int)$attackPoint;
      History::set($this->getName().'のクリティカルヒット!!');
    }
    $targetObj->setHp($targetObj->getHp()-$attackPoint);
    History::set($attackPoint.'ポイントのダメージ！');
  }
}
// 主人公クラス
class Human extends Creature{
  public function __construct($name, $hp, $attackMin, $attackMax){
    $this->name = $name;
    $this->hp = $hp;
    $this->attackMin = $attackMin;
    $this->attackMax = $attackMax;
  }
  public function sayCry(){
    History::set($this->name.'が叫ぶ！');
    if(mt_rand(0,9)){
      History::set('頑張れ俺 頑張れーー！！');
    }else{
      History::set('燃やせ 燃やせ 燃やせ！ 心を燃やせ！！');
    }
  }
}
class Demons extends Creature{
  protected $img;
  protected $individual;
  public function __construct($name, $individual, $hp, $img, $attackMin, $attackMax){
    $this->name = $name;
    $this->individual = $individual;
    $this->hp = $hp;
    $this->img = $img;
    $this->attackMin = $attackMin;
    $this->attackMax = $attackMax;
  }
  public function getImg(){
    return $this->img;
  }
  public function sayCry(){
    History::set($this->name.'が叫ぶ！');
    switch($this->individual){
      case Individual::HANTENG :
        History::set('弱き者をいたぶる鬼畜 不快 不愉快 極まれり 極悪人共めが');
        break;
      case Individual::GYOKKO :
        History::set('あれは首を生けるものではない…だがそれもまたいい');
        break;
      case Individual::KOKUSHIBOU :
        History::set('さらなる高みへの…開けた道をも…自ら放棄するとは…軟弱千万');
        break;
      case Individual::DOMA :
        History::set('誰もが皆死ぬのを怖がるから だから俺が”食べてあげてる” 俺と共に生きていくんだ永遠の時を');
        break;
      case Individual::AKAZA :
        History::set('そう 弱者には虫唾が走る反吐が出る 淘汰されるのは自然の摂理に他ならない');
        break;
      case Individual::KAIGAKU :
        History::set('俺は常に！！どんな時も！！正しく俺を評価する者につく');
        break;
    }
  }
}
interface HistoryInterface{
  public static function set($str);
  public static function clear();
}
// 履歴管理クラス
class History implements HistoryInterface{
  public static function set($str){
    // セッションhistoryが作られてなければ作る
    if(empty($_SESSION['history'])) $_SESSION['history'] = '';
    // 文字列をセッションhistoryへ格納
    $_SESSION['history'] .= $str.'<br>';
  }
  public static function clear(){
    unset($_SESSION['history']);
  }
}
// インスタンス生成
$human = new Human('炭治郎',300,60,120);
$demons[] = new Demons('半天狗',Individual::HANTENG, 100, '/assets/images/use/oni_01.jpg', 20, 40);
$demons[] = new Demons('玉壺',Individual::GYOKKO, 130,'/assets/images/use/oni_02.jpg',20,40);
$demons[] = new Demons('黒死牟',Individual::KOKUSHIBOU, 300,'/assets/images/use/oni_03.jpg',20,40);
$demons[] = new Demons('童磨',Individual::DOMA, 200,'/assets/images/use/oni_04.jpg',20,40);
$demons[] = new Demons('猗窩座',Individual::AKAZA, 200,'/assets/images/use/oni_05.jpg',20,40);
$demons[] = new Demons('獪岳',Individual::KAIGAKU, 80,'/assets/images/use/oni_06.jpg',10,30);

function createDemon(){
  global $demons;
  $demons = $demons[mt_rand(0,7)];
  $_SESSION['demons'] = $demons;
  // History::set($demons->getName().'が現れた！');
}
function createHuman(){
  global $human;
  $_SESSION['human'] =  $human;
}
function init(){
  History::clear();
  History::set('初期化します！');
  $_SESSION['knockDownCount'] = 0;
  createHuman();
  createDemon();
}
function gameOver(){
  header("Location:gameover.php");
}

// 1.post送信されていた場合
if(!empty($_POST)){
  $attackFlgWoter = (!empty($_POST['water'])) ? true : false;
  $attackFlgSun = (!empty($_POST['sun'])) ? true : false;
  $startFlg = (!empty($_POST['start'])) ? true : false ;
  error_log('POSTされた！');

  if($startFlg){
    error_log('ゲームスタート！');
    History::set('ゲームスタート！');
    init();
  }else{
    // 攻撃するを押した場合
    if($attackFlgWoter || $attackFlgSun){
      error_log('主人公の攻撃');

      // 鬼に攻撃を与える
      History::set($_SESSION['human']->getName().'の攻撃！');
      $_SESSION['human']->attack($_SESSION['demons']);
      $_SESSION['demons']->sayCry();

      // 鬼が攻撃をする
      error_log('鬼の攻撃');
      History::set($_SESSION['demons']->getName().'の攻撃');
      $_SESSION['demons']->attack($_SESSION['human']);
      $_SESSION['human']->sayCry();

      // 自分のhpが0以下になったらゲームオーバー
      if($_SESSION['human']->getHp() <= 0){
        gameOver();
      }else{
        // hpが0以下になったら、別の鬼を出現させる
        if($_SESSION['demons']->getHp() <= 0){
          History::set($_SESSION['demons']->getName().'を倒した！');
          createDemon();
          $_SESSION['knockDownCount'] = $_SESSION['knockDownCount']+1;
        }
      }
    }else{
      // 逃げるを押した場合
      History::set('逃げた！');
      createDemon();
    }
  }
  $_POST = array();
}
?>
