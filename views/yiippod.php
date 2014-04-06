<?php
/** @var $this Yiippod */
?>

<object data="<?=$this->swfUrl?>" type="application/x-shockwave-flash" height="<?=$this->height?>" width="<?=$this->width?>">
    <param name="bgcolor" value="<?=$this->bgcolor?>">
    <param name="allowFullScreen" value="true">
    <param name="allowScriptAccess" value="always">
    <param name="id" value="<?=$this->id?>">
    <param name="wmode" value="window">
    <param name="movie" value="<?=$this->swfUrl?>">
    <param name="flashvars" value="m=video&uid=<?=$this->id?>&file=<?=$this->video
    .($this->style ? '&st='.$this->style : '')
    .($this->poster ? '&poster ='.$this->poster : '')
    .($this->playlist ? '&pl='.$this->playlist : '')?>">
</object>

<div style="height:<?=$this->height?>px; width:<?=$this->width?>px;" id="<?=$this->html5Id?>"></div>

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
        } catch(e) {}
    }

    if(ua.indexOf("iphone") != -1 || ua.indexOf("ipad") != -1 || (ua.indexOf("android") != -1 && !flashInstalled)){
        // HTML5
        <?=file_get_contents($this->styleHtml5)?>
        this.<?=$this->html5Id?> = new Uppod({m:"video",uid:"<?=$this->html5Id?>",file:"<?=$this->video?>",st:uppodvideo});
        <?php if($this->autoplay): ?>
        setTimeout('function(){this.<?=$this->html5Id?>.Play()}', 10);
        <?php endif; ?>
    } else {
       if(!flashInstalled){
           // NO FLASH
           document.getElementById("<?=$this->id?>").innerHTML="<a href=http://www.adobe.com/go/getflashplayer>Требуется установить Flash-плеер</a>";
       } else {
            try {
               // FLASH
               var flashvars = {"file":"<?=$this->video?>"<?=($this->style ? ', "st": "'.$this->style.'"' : '')?>};
               var params = {bgcolor:"<?=$this->bgcolor?>",  allowFullScreen:"true", allowScriptAccess:"always",id:"<?=$this->id?>"};
               new swfobject.embedSWF("<?=Yii::app()->request->baseUrl.$this->swfUrl?>", "<?=$this->id?>", "<?=$this->width?>", "<?=$this->height?>", "10.0.0", false, flashvars, params);
            } catch(e) {
               alert(e);
            }
        }
    }
</script>