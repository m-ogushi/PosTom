
<table>
  <thead>
    <th>ID</th><th>width</th><th>height</th>
    <th>x</th><th>y</th><th>area_id</th>
    <th>date</th>
  </thead>
  <?php $JsonFile='{"toppage_img":"'.str_replace('/','\/',$this->Html->webroot).'img\/thumb\/toppage_pbla.png","posmapp_bg":["'.str_replace('/','\/',$this->Html->webroot).'img\/bg\/backGround.png"],"STATIC_WIDTH":"720","STATIC_HEIGHT":"960",';   ?>
  <?php
  echo str_replace('/','\/',$this->Html->webroot);
   $pointer=1;
   $JsonPosition='"position":[';
   $JsonAuthor='"author":[';
   $JsonPresent='"presen":[';
   $JsonPoster='"poster":[';
   foreach($posters as $poster):

          $JsonPosition.='{';
          $JsonPosition.='"id":'.'"'.$pointer.'",';
          $JsonPosition.='"x":'.'"'.$poster['Poster']['x'].'",';
          $JsonPosition.='"y":'.'"'.$poster['Poster']['y'].'",';
          $JsonPosition.='"width":'.'"'.$poster['Poster']['width'].'",';
          $JsonPosition.='"height":'.'"'.$poster['Poster']['height'].'",';
          $JsonPosition.='"direction":'.'"sideways"';
          $JsonPosition.='}';

          $JsonAuthor.='{';
          $JsonAuthor.='"presenid":"A1-'.$pointer. '",';
          $JsonAuthor.='"name":"",';
          $JsonAuthor.='"belongs":"’}”g‘å",';
          $JsonAuthor.='"first":"1"';
          $JsonAuthor.='}';

          $JsonPresent.='{';
          $JsonPresent.='"presenid":"A1-'.$pointer.'",';
          $JsonPresent.='"title":"",';
          $JsonPresent.='"abstract":"",';
          $JsonPresent.='"bookmark":"0"';
          $JsonPresent.='}';

          $JsonPoster.='{';
          $JsonPoster.='"presenid":"A1-'  .$pointer.  '",';
          $JsonPoster.='"posterid":"'  .$pointer.  '",';
          $JsonPoster.='"star":"1",';
          $JsonPoster.='"date":"1"';
          $JsonPoster.='}';

          if($pointer<count($posters))
          {
              $pointer=$pointer+1;
              $JsonPosition.=',';
              $JsonAuthor.=',';
              $JsonPresent.=',';
              $JsonPoster.=',';
          }
  endforeach;
  $JsonPosition.='],';
  $JsonAuthor.='],';
  $JsonPresent.='],';
  $JsonPoster.=']';
  $JsonFile.=$JsonPosition.$JsonAuthor.$JsonPresent.$JsonPoster.'}';
  echo $JsonFile;

  //JSON‚Ö•ÏŠ·‚µ‚Ä‘‚«ž‚Ý
  $filename ='../webroot/json/data.json';

  $handle = fopen($filename, 'w');
  fwrite($handle,$JsonFile);
  fclose($handle);
  echo 'save successed!';

   ?>
</table>