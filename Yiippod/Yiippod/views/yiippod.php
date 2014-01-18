<object data="<?=$this->swfUrl?>" type="application/x-shockwave-flash" height="<?=$this->height?>" width="<?=$this->width?>">
    <param value="<?=$bgcolor?>" name="bgcolor">
    <param value="true" name="allowFullScreen">
    <param value="always" name="allowScriptAccess">
    <param value="<?=$this->id?>" name="id">
    <param value="file=<?=$this->video.($this->st ? "&st={$this->st}" : '')?>" name="flashvars">
</object>

<script>
    var ua = navigator.userAgent.toLowerCase();
    var flashInstalled = false;
    if (typeof(navigator.plugins)!="undefined" && typeof(navigator.plugins["Shockwave Flash"])=="object") {
         flashInstalled = true;
    } else if (typeof window.ActiveXObject != "undefined") {
        try {
            if (new ActiveXObject("ShockwaveFlash.ShockwaveFlash")) {
                flashInstalled = true;
            }
        } catch(e) {};
    };

   if(ua.indexOf("iphone") != -1 || ua.indexOf("ipad") != -1 || (ua.indexOf("android") != -1 && !flashInstalled)){
        // HTML5
        this.<?=$this->id?> = new Uppod({m:"video",uid:"<?=$this->id?>",file:"<?=$this->video?>"});
   } else {
      if(!flashInstalled){
         // NO FLASH
         document.getElementById("<?=$this->id?>").innerHTML="<a href=http://www.adobe.com/go/getflashplayer>Требуется установить Flash-плеер</a>";
      } else {
         // FLASH
         var flashvars = {"file":"<?=$this->video?>"<?=($this->st ? ', "st": "'.$this->st.'"' : '')?>};
         var params = {bgcolor:"<?=$bgcolor?>",  allowFullScreen:"true", allowScriptAccess:"always",id:"<?=$this->id?>"};
         new swfobject.embedSWF("<?=Yii::app()->request->baseUrl.$this->swfUrl?>", "<?=$this->id?>", "<?=$this->width?>", "<?=$this->height?>", "10.0.0", false, flashvars, params);
      }
   }
</script>