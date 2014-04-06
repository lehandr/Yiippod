<?php
/*
 * @author -\- автор  Alexander Shapovalov <mail@shapovalov.org>
 * 
 * usage -\- использование
<?php  
 
$this->widget('ext.Yiippod.Yiippod', array(
'video'=>"http://www.youtube.com/watch?v=qD2olIdUGd8",
'id' => 'yiippodplayer',
'width'=>640,
'height'=>480,
'bgcolor'=>'#000',
'autoplay'=>true,
));

?>
 */

class Yiippod extends CWidget
{
    /** The uppod.swf url -\- Ссылка на .swf файл uppod'а
     * @var string
     */
    public $swfUrl;

    /** The media file or stream video URL -\- Адрес медиа файла или потока (RTMP, mov, mp4, flv, avi)
     * The media file must be a string -\- Адрес к файлу\потоку должен иметь строковой тип данных
     *
     * @var string
     */
    public $video;
    /** Player width -\- Ширина плеера
     * @var integer
     */
    public $width=640;
    /** Player height. -\- Высота плеера
     * @var integer
     */
    public $height=480;
    /** Player background color -\- Цвет заднего фона плеера
     * @var string
     */
    public $bgcolor='#000';
    /** Player id. -\- Идентификатор ИД плеера
     * @var string
     */
    public $id='uppodplayer';
    /** The js scripts to register  -\- Путь до скрипта uppod'a
     * @var array
     */
    public $js = array(
        'uppod.js'
    );
    /** The styles file to register  -\- Путь до файла стилей uppod'a
     * @var string
     */
    public $style;

    /** The poster picture link
     * @var string
     */
    public $poster;

    /** The comment (title) of the video
     * @var string
     */
    public $comment;

    /** Play on start: true or false.
     * @var bool
     */
    public $playlist;

    /** The asset folder after published  -\- Папка со скриптами после публикации
     * @var string
     */
    public $autoplay;

    /** The js-file url of HTML5 settings  -\- Путь до файла JS кода для HTML5 версии плеера
     * @var array
     */
    public $styleHtml5;

    /** The asset folder after published  -\- Папка со скриптами после публикации
     * @var string
     */
    private $assets;

    /**
     * Publishing the assets  -\- Публикация скриптов
     **/
    private function publishAssets()
    {
        $assets = __DIR__.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR;
        $this->assets = Yii::app()->getAssetManager()->publish($assets);
    }
    /**
     * Register the core uppod js lib -\- Регистрация скрипта плеера библиотека js
     *
     */
    private function registerScripts()
    {
        $this->publishAssets();

        Yii::app()->clientScript
            ->registerScriptFile($this->assets.'/swfobject.js')
            ->registerScriptFile($this->assets.'/uppod.js');

    }
    /**
     * Initialize the widget and necessary properties -\- Инициализация виджета и необходимых свойств
     *
     */
    public function init()
    {
        $this->publishAssets();
        $this->registerScripts();

        if(!$this->swfUrl===null) {
            $this->swfUrl = $this->assets.'/uppod.swf';
        }
        if(!$this->playlist===null) {
            $this->playlist=$this->assets.'/playlist.txt';
        }

        $this->height=(int)$this->height;
        $this->width=(int)$this->width;
    }
    /**
     * Render uppod player -\- Отображение плеера
     *
     */
    public function run()
    {
        $this->render('yiippod');
    }

    /**
     * @return string ID for HTML5 player.
     */
    public function getHtml5Id() {
        return $this->id.'html5';
    }
}