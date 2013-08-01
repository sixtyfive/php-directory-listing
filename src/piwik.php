<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://<?php echo $pdl->getConfig('piwik', 'fqdn'); ?>/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "<?php echo $pdl->getConfig('piwik', 'site_id'); ?>"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript>
  <img src="https://stats.weitnahbei.de/piwik.php?idsite=1&amp;rec=<?php echo $pdl->getConfig('piwik', 'site_id'); ?>" style="border:0" alt="" />
</noscript>
