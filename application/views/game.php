<!DOCTYPE html>
<html>
   <head>
      <title>PP - Game Client</title>
      <meta charset="utf-8">
      <link rel="icon" type="image/png" sizes="32x32" href="https://www.pragmaticplay.com/favicon-32x32.png">
      <meta name="apple-mobile-web-app-capable" content="yes" />
      <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
      <style>
         body,
         html {
         position: fixed;
         } 
      </style>
      <script>
      if( !sessionStorage.getItem('sessionId') ){
          sessionStorage.setItem('sessionId', parseInt(Math.random() * 1000000));
      }
      
      var exitUrl='';
      if(document.location.href.split("api_exit=")[1]!=undefined){
      exitUrl=document.location.href.split("api_exit=")[1].split("&")[0];
      }
      addEventListener('message',function(ev){
      
      if(ev.data=='CloseGame'){
      
      document.location.href=exitUrl;	
      }
      
      });
   </script>
   </head>
   <body style="margin:0px;width:100%;background-color:black;overflow:hidden">
      <iframe id='game' style="margin:0px;border:0px;width:100%;height:100vh;"
         src='<?= base_url(); ?>public/<?= $game; ?>/gs2c/html5Game.php?lang=<?= $lang; ?>&cur=<?= $cur; ?>&gameSymbol=<?= $game; ?>&user=<?= $user; ?>';
         allowfullscreen>
      </iframe>
   </body>
   <script rel="javascript" type="text/javascript" src="<?= base_url(); ?>public/vs20olympgate/device.js"></script>
</html>