<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport " content="width=device-width, initial-scale=1.0">
      <title>Laporan Pemeliharaan Perbaikan</title>
      <style>
         .page-break{
            page-break-after:always;
         } 
         .tulisan_tengah{
            text-align: center;
         }
         .col-md-3 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
         }
         .img-center{
            text-align: center;
         }
</style>
   </head>
   <body>
     <table>
     <?php 
      $x= 0;
      $limit= $totaldata;
      $percolom= 3;
      $totalbaris =  ceil($limit/$percolom);
 
    ?>
    <?php  for ($y = 0; $y <  $totalbaris; $y++):?>
      <tr>
         <?php  
          
          for ($i = 0; $i <  $percolom; $i++):?>
         <td>
            <?php 
            if ($x < $limit) {
               # code...
            
            ?>
                     <div class="img-center">
                     <img style="display:flex;"
                                       height="<?=scaleIMG($data[$x]['Qrcode'],'1')['h']?>" 
                                       width="<?=scaleIMG($data[$x]['Qrcode'],'1')['w']?>"
                                       src="<?=$data[$x]['Qrcode']?>" > 
                     </div>
                
                  <p class="tulisan_tengah">SN : <?=$data[$x]['sn']?></p>
                <?php $x++;}
                
                ?>
                                       
         </td>
         <?php  
       endfor;
      ?>
      </tr>
      <?php endfor;?>
     </table>
     <?php 

?>
       
     
   <!-- -->
 
   </body>
</html>