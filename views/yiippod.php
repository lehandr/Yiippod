<?php
/** @var $this Yiippod */
?>

<div style="height:<?=$this->height?>px; width:<?=$this->width?>px;" id="<?=$this->html5Id?>"></div>

<script>
    if (Modernizr.video) {
        // HTML5
        <?=file_get_contents($this->styleHtml5)."\n"?>
        try {
            // Secondary invoke
            this.<?=$this->html5Id?>.Init();
        } catch(e) {
            this.<?=$this->html5Id?> = new Uppod({m:"video",uid:"<?=$this->html5Id?>",file:"<?=$this->video?>",st:uppodvideo});
        }
        <?php if($this->autoplay): ?>
        setTimeout('function(){ this.<?=$this->html5Id?>.Play(); }', 10);
        <?php endif; ?>
    } else if(!FlashDetect.installed){
        document.getElementById("<?=$this->html5Id?>").innerHTML="<a href=http://www.adobe.com/go/getflashplayer>Требуется установить Flash-плеер</a>";
    } else {
        document.getElementById("<?=$this->html5Id?>").innerHTML('<object data="<?=$this->swfUrl?>" type="application/x-shockwave-flash" height="<?=$this->height?>" width="<?=$this->width?>">'
            +'<param name="bgcolor" value="<?=$this->bgcolor?>">'
            +'<param name="allowFullScreen" value="true">'
            +'<param name="allowScriptAccess" value="always">'
            +'<param name="id" value="<?=$this->id?>">'
            +'<param name="wmode" value="window">'
            +'<param name="movie" value="<?=$this->swfUrl?>">'
            +'<param name="flashvars" value="m=video&uid=<?=$this->id?>&file=<?=$this->video
                .($this->style ? '&st='.$this->style : '')
                .($this->poster ? '&poster ='.$this->poster : '')
                .($this->playlist ? '&pl='.$this->playlist : '')?>">'
            +'</object>');

        try {
            // FLASH
            var flashvars = {"file":"<?=$this->video?>", "uid": "<?=$this->id.'"'
                    .($this->style ? ', "st": "'.$this->style.'"' : '')
                    .($this->poster ? ', "poster": "'.$this->poster.'"' : '')
                    .($this->playlist ? ', "pl": "'.$this->playlist.'"' : '')?>};
                var params = {bgcolor:"<?=$this->bgcolor?>",  wmode:"window", allowFullScreen:"true", allowScriptAccess:"always", id:"<?=$this->id?>"};
            new swfobject.embedSWF("<?=Yii::app()->request->baseUrl.$this->swfUrl?>", "<?=$this->id?>", "<?=$this->width?>", "<?=$this->height?>", "10.0.0", false, flashvars, params);
        } catch(e) {
            alert(e);
        }
    }
</script>