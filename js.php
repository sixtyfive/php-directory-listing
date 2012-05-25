<script type="text/javascript">
    $(document).ready(function() {
      $('.fancybox').fancybox({
        padding: 15,
        margin: 50,
        prevEffect: 'none',
        nextEffect: 'none',
        closeBtn: false,
        helpers: {
          overlay: {opacity: 0.9, css: {'background-color': '#000'}}
        }
      });
    
      $('#playpause').click(function() {
        soundManager.togglePause('backgroundMusic');
        var obj = $(this);
        if (obj.attr('src') == '<?php echo $pdl->url().'icons/pause.png'; ?>') {
          obj.attr('src', '<?php echo $pdl->url().'icons/play.png'; ?>');
        } else {
          obj.attr('src', '<?php echo $pdl->url().'icons/pause.png'; ?>');
        }
      });
    });
    
    soundManager.url = '<?php echo $pdl->url().'thirdparty/soundmanager2/swf/'; ?>';
    soundManager.flashVersion = 9;
    soundManager.waitForWindowLoad = true;
    
    soundManager.onready(function() {
      var backgroundMusic = soundManager.createSound({
        id: 'backgroundMusic',
        url: 'background.mp3',
        onid3: function() {
          $('#songtitle').html(this.id3['TPE2'] + ' - ' + this.id3['TIT2']);
        },
        onfinish: function() {
          $('#playpause').attr('src', '<?php echo $pdl->url().'icons/play.png'; ?>');
        }
      });
    
      backgroundMusic.play();
    });
  </script>
