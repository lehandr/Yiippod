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
'bgcolor'=>'#000'
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
     * @var array
     */
    public $st;

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

        if(!isset($this->swfUrl)) $this->swfUrl = $this->assets.'/uppod.swf';

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
}