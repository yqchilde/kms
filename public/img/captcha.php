<?php 
/**
  *文件名：showCode.php
  *描述：生成验证
  */ 
$num = "";
for($i=0;$i<4;$i++)
{     
  $num .= rand(0,9); 
}  
session_start(); 
$_SESSION['captcha'] = $num; 
header('Content-type:image/PNG'); 
srand((double)microtime()*1000000); 
$width = 60; 
$height = 20; 
$image =imagecreate($width, $height); 
$black = ImageColorAllocate($image,0,0,0); 
$gray = imagecolorallocate($image,200,200,200); 
imagefill($image, 0, 0, $gray); 
$style = array($black,$black,$black,$black,$black,$gray,$gray,$gray,$gray,$gray);
imagesetstyle($image, $style); 
$y1 = rand(0,20); 
$y2 = rand(0,20); 
$y3 = rand(0,20); 
$y4 = rand(0,20); 
imageline($image,0,$y1,60,$y3,IMG_COLOR_STYLED); 
imageline($image,0,$y2,60,$y4,IMG_COLOR_STYLED); 
//在画布上随机生成大量黑点，起干扰作用
for($i=0;$i<80;$i++)
{     
  imagesetpixel($image,rand(0,60),rand(0,20),$black);
} 
//将 4 个数字随机显示在画布上，字符的水平间距和位置都按一定波动范围随机生成 
$strx = rand(3,8); 
for($i=0;$i<4;$i++)
{    
  $strpos = rand(1,6);     
  imagestring($image,5,$strx,$strpos,substr($num,$i,1),$black);    
  $strx += rand(8,12); 
} 
imagepng($image); 
imagedestroy($image); 
?> 