<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require "./src/functions/function.php";

final class FunctionTest extends TestCase{
  public function testCheckRequired():void{
    global $errMsg;
    $errMsg=array();

    $str='';
    $key='name';
    $expected[$key]="未入力です。";
    checkRequired($key,$str);
    $this->assertSame($expected,$errMsg);
  }
  public function testCheckMinLen():void{
    global $errMsg;
    $errMsg=array();

    $str3='あいう';//=半角'123'
    $str8='あいうえおかきく';//=半角'12345678'
    $str9='あいうえおかきくけ';//=半角'123456789'
    $key='name';
    $min=8;
    //3文字入力の場合
    $expected1[$key]="${min}文字以上入力してください。";
    checkMinLen($key,$str3);
    $this->assertSame($expected1,$errMsg);
    //８文字入力の場合
    $expected2=array();
    $errMsg=array();//テスト毎に$errMsgを初期化する必要あり
    checkMinLen($key,$str8);
    $this->assertSame($expected2,$errMsg);
    //9文字入力の場合
    $expected3=array();
    $errMsg=array();
    checkMinLen($key,$str9);
    $this->assertSame($expected3,$errMsg);
  }

  public function testCheckMaxLen():void{
    global $errMsg;
    $errMsg=array();
    $key='name';
    $str255="ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑをんぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑをんぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑをんぁあぃいぅう";
    $str256="ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑをんぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑをんぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑをんぁあぃいぅうえ";
    $max=255;

    //255文字入力の場合
    $expected1=array();
    global $errMsg;
    checkMaxLen($key,$str255);
    $this->assertSame($expected1,$errMsg);
    //256文字の場合
    $errMsg=array();
    checkMaxLen($key,$str256);
    $expected2[$key]="${max}文字以下を入力してください。";
    $this->assertSame($expected2,$errMsg);

  }

  public function testCheckEnvDepChars(){
    global $errMsg;
    $errMsg=array();
    $key='name';
    $strNormal='aiueo';
    $strSpecial='①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳';
    //環境依存文字が使われていない場合
    $expected1=array();
    checkEnvDepChars($key,$strNormal);
    $this->assertSame($expected1,$errMsg);

    //環境依存文字が使われている場合
    $errMsg=array();
    $expected2[$key]=ERR_ENV_DEP_CHARS;
    checkEnvDepChars($key,$strSpecial);
    $this->assertSame($expected2,$errMsg);
  }

  public function  testCheckSpecialChars():void{
    global $errMsg;
    $errMsg=array();

    $key='name';
    $strNormal='aiueo';
    $strSpecial='<<<<<aiueo<';

    //特殊文字が使われている場合
    $expected1=array();
    checkSpecialChars($key,$strNormal);
    $this->assertSame($expected1,$errMsg);
    //特殊文字が使われていない場合
    $errMsg=array();
    $expected2[$key]=ERR_SPECIAL_CHARS;
    checkSpecialChars($key,$strSpecial);
    $this->assertSame($expected2,$errMsg);
  }

  public function testCheckSingleByteChars():void{
    global $errMsg;
    $errMsg=array();
    $key='name';
    $strSingle='aiueo123';
    $strNotSingle='あいうえabicお＆';

    //半角文字の場合
    $expected1=array();
    checkSingleByteChars($key,$strSingle);
    var_dump($errMsg);
    $this->assertSame($expected1,$errMsg);

    //半角文字でない場合
    $errMsg=array();
    $expected2[$key]=ERR_SINGLE_BYTE;
    checkSingleByteChars($key,$strNotSingle);
    $this->assertSame($expected2,$errMsg);
  }
}
