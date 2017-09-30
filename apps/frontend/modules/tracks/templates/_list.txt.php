 -----------------------------------------
     *******          
     *******          
 ******* ***    ***   
 ******* ***   ***    
 *** *** ***  ***     
 *** *** *** ***                     
 -----------------------------------------
 *******                             
 *******              
 *** *******                    **        
 *** *******        ****  *** **** ** ****
 *** *** ***        **   **** **** ** ****
 *** *** ***        **   **** **** ** ****
      
 -----------------------------------------
 downloaded from http://www.mazemod.org
 -----------------------------------------
 contact: info@mazemod.org
 -----------------------------------------

 Title : <?php  echo $playlist->getTitle(); ?>   
 Author : <?php  echo $playlist->getAuthor(), "\n"; ?>
 Tracks :                      
 <?php foreach ($playlist->getTracks() as $track): ?>
  * <?php echo $track->getComposer() ?> - <?php echo $track->getTitle(), "\n" ?>
 <?php endforeach; ?>     
 Author's notes : <?php echo "\n\n" ?>
<?php echo $playlist->getDescription(), "\n" ?>
 -----------------------------------------   