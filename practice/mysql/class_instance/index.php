<?php
class Enemy{
  public $name;
  public $stamina;
  public $attack;
  public static $count=0;//publicはなくても良い

  public function __construct($name,$stamina=100,$attack=10){
    $this->name=$name;
    $this->stamina=$stamina;
    $this->attack=$attack;
    Self::$count+=1;
  }
  public static function getEnemyCount(){
    echo Self::$count.'体の敵を作りました';
    echo '<br/>';
  }
  public function sayMyName(){
    echo $this->name."があらわれた";
    echo '<br/>';
  }
  public function  sayAttackPoint(){
    echo '攻撃力は'.$this->attack;
    echo '<br/>';
  }
  public function powerUp(){
    $this->attack+=10;
    echo '攻撃力が'.$this->attack.'になった！';
    echo '<br/>';
  }
}

class Boss extends Enemy{
 public function sayMyName(){//オーバーライド
  echo "ぐはは！".$this->name."だよーん";
  echo '<br/>';
 }
 public function specialAttack(){
  echo parent::sayAttackPoint();//親のメソッド呼び出し
  echo 'スペシャルアタック（継承）'.$this->attack;//親の変数呼び出し
  echo '<br/>';
 }
}
  $slime=new Enemy("SLIME");
  $kuribo=new Enemy("Kuribo",200,10);
  $slime->sayMyName();
  echo $slime->stamina;
  echo $slime->attack;
  echo '<br/>';
  $kuribo->sayMyName();
  echo $kuribo->stamina;
  echo $kuribo->attack;

  $kinoko=new Enemy("KINOKO");
  $kinoko->sayMyName();
  $kinoko->powerUp();
  $kinoko->powerUp();
  $kinoko->powerUp();
  $kinoko->powerUp();
  $kinoko->powerUp();

  $boss=new Boss("ボス",300,300);
  $boss->sayMyName();
  $boss->powerUp();
  $boss->specialAttack();
  // echo $boss->name;
  //※private/protected=>クラスの内部でのみ使用可能。
  //クラスの外（別のクラスという意味ではない）で使用するとエラーになる。publicは、クラスの外からでも呼び出せる。$boss->XXX()という漢字で。

  Enemy::getEnemyCount();//すべてのインスタンスをカウントする
  echo Enemy::$count;//変数を呼び出すとき
?>
