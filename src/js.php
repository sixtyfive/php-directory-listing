<script type="text/javascript">
  $(document).ready(function() {
    $('.fancybox').fancybox({
      padding: 15,
      <?php if($pdl->getConfig('general', 'interface') == 'gallery') { echo "margin: [10, 50, 50, 50],\n"; } else { echo "margin: 50,\n"; } ?>
      prevEffect: 'none',
      nextEffect: 'none',
      closeBtn: false,
      <?php if ($pdl->getConfig('general', 'interface') == 'gallery' && $pdl->getConfig('gallery', 'slideshow_autostart')) { echo "autoPlay: true,\n"; } ?>
      <?php if ($pdl->getConfig('gallery', 'slideshow_loop')) { echo "cyclic: true,\n"; } ?>
      helpers: {
        <?php if ($pdl->getConfig('general', 'interface') == 'gallery') { ?>buttons: {tpl: '<div id="fancybox-buttons"><ul><li><a class="btnPrev" href="javascript:;"></a></li><li><a class="btnPlay" href="javascript:;"></a></li><li><a class="btnNext" href="javascript:;"></a></li><li><a class="btnClose" href="javascript:jQuery.fancybox.close();"></a></li></ul></div>'},<?php } ?>
        overlay: {opacity: 0.9, css: {'background-color': '#000'}}
      }
    });
    
    <?php if ($pdl->getConfig('general', 'interface') == 'gallery') { ?>
      <?php if ($pdl->getConfig('gallery', 'slideshow_autostart')) { echo "$('#content .image a:first').trigger('click');\n"; } ?>
      $('#playpause').click(function() {
        soundManager.togglePause('backgroundMusic');
        var obj = $(this);
        if (obj.attr('src') == '<?php echo $pdl->url().'icons/pause.png'; ?>') {
          obj.attr('src', '<?php echo $pdl->url().'icons/play.png'; ?>');
        } else {
          obj.attr('src', '<?php echo $pdl->url().'icons/pause.png'; ?>');
        }
      });
    <?php } ?>
  });
    
  <?php if ($pdl->getConfig('general', 'interface') == 'gallery') { ?>
    soundManager.url = '<?php echo $pdl->url().'thirdparty/soundmanager2/swf/'; ?>';
    soundManager.flashVersion = 9;
    soundManager.waitForWindowLoad = false;
    soundManager.onready(function() {
      var backgroundMusic = soundManager.createSound({
        id: 'backgroundMusic',
        url: 'background.mp3',
        onid3: function() {
          $('#songtitle').html(this.id3['TPE1'] + ' - ' + this.id3['TIT2']);
        },
        onfinish: function() {
          $('#playpause').attr('src', '<?php echo $pdl->url().'icons/play.png'; ?>');
          <?php if ($pdl->getConfig('gallery', 'backgroundmusic_loop')) { echo "$('#playpause').trigger('click');\n"; } ?>
        }
      });
    <?php if ($pdl->getConfig('gallery', 'backgroundmusic_autostart')) { echo "backgroundMusic.play();\n"; } else { echo "backgroundMusic.load();\n"; } ?>
    });
  <?php } ?>
</script>
