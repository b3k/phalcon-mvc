<?php

namespace App\Library\Asset;

use Phalcon\Assets\Manager as AssetManager;
use Phalcon\Assets\Collection;
use App\Library\Utilities\ArrayUtils;
use App\Library\DI\Behaviour\DIBehaviour;
use Phalcon\Tag;
use Phalcon\Assets\Filters\Cssmin;
use Phalcon\Assets\Filters\Jsmin;

class Manager extends AssetManager
{

    use DIBehaviour {
        DIBehaviour::__construct as protected __DIConstruct;
    }

    const
        FILENAME_PATTERN_CSS = 'style-%s.css',
        FILENAME_PATTERN_JS = 'javascript-%s.js';
    const
        DEFAULT_COLLECTION_JS = 'js',
        DEFAULT_COLLECTION_CSS = 'css';
    const 
        COMPILED_STORAGE_PATH = 'assets/comp/',
        GENERATED_STORAGE_PATH = 'assets/gen/',
        ASSETS_CSS_PATH = 'Assets/Css',
        ASSETS_JS_PATH = 'Assets/Js';

    private $_config = array(
      'lifetime' => 3600,
      'join' => true,
      'css' => array(
        'builders' => array(
          array('extensions' => array('less'), 'builder' => 'App\Library\Assets\Builder\Css\Less', 'adapter' => 'NodeLess'),
          array('extensions' => array('scss'), 'builder' => 'App\Library\Assets\Builder\Css\Scss', 'adapter' => 'NodeScss')
        )
      ),
      'js' => array(
        array('extensions' => array('coffe'), 'builder' => 'App\Library\Assets\Builder\Js\CoffeScript'),
      )
    );

    /**
     * 
     * assets/
     *      css/
     *          index/
     *              file.less
     *              file2.scss
     *      js/
     *          index/
     *              file.coffe
     *              file2.coffe
     * 
     * tmp/
     *      assets/
     *          gen/
     *              css/
     *                  index/
     *                      file.css
     *                      file2.css
     *              js/
     *                  index/ 
     *                      file.js
     *                      file2.js
     * 
     * 
     * try {
     *  $Assetmaneger->compileCss()->
     *                  getBuilder('less')->
     *                  setInputFile('assets/css/index/file.less')->
     *                  setOutputFile('tmp/assets/css/index/file2.css')->
     *                  build();
     * } catch () {
     *  
     * }
     * 
     * 
     * 
     * 
     */
    public function __construct($di)
    {
        $this->__DIConstruct($di);
        $this->_config = ArrayUtils::array_merge_recursive_distinct($this->_config,
                $this->getDI()->getShared('config')->application->assets->toArray());
        $this->initializeCollections();
    }

    public function initializeCollections()
    {
        $this->set(self::DEFAULT_COLLECTION_CSS, $this->getNewCssCollection());
        $this->set(self::DEFAULT_COLLECTION_JS, $this->getNewJsCollection());
    }

    public function getNewCssCollection()
    {
        $collection = new Collection();
        return $collection
                ->setSourcePath(APP_APPLICATION_DIR . DS . 'Assets' . DS . 'Stylesheets' . DS)
                ->addFilter(new Cssmin())
                ->join($this->getConfig('join'));
    }

    public function getNewJsCollection()
    {
        $collection = new Collection();
        return $collection
                ->setSourcePath(APP_APPLICATION_DIR . DS . 'Assets' . DS . 'Javascripts' . DS)
                ->addFilter(new Jsmin())
                ->join($this->getConfig('join'));
    }
    
    public function createBuilder($type) {
        
    }

    /**
     * COmpioles all project CSS, less
     * 
     * 1. We need to get all file extensions that we should care about
     * 2. 
     * 
     */
    public function compileCss($source = null, $target = null)
    {
        $source = $source ?: APP_APPLICATION_DIR . DS . self::ASSETS_CSS_PATH . DS;
        $target = $target ?: APP_TMP_DIR . DS . self::COMPILED_STORAGE_PATH . DS;
        
        // Get all supported extensions
        $exts = implode('|', $this->getCssBuilderExtensions());
        
        // Get all files we are interested
        $Finder = new \Symfony\Component\Finder\Finder();
        $Finder->files()->name('/.*\.('.$exts.')/i')->in($source);
        
        foreach ($Finder as $result) {
            try {
                $this->createBuilder($result->getExtension())
                    ->setInputFile($result->openFile("r"))
                    ->setOutputFile($target)
                    ->build();
            } catch (\Exception $e) {
                
            }
        }
        
        
    }
    
    public function getBuilderForExtension() {
        
    }

    public function getCssBuilderExtensions()
    {
        return $this->getBuilderExtensions('css');
    }

    public function getJsBuilderExtensions()
    {
        return $this->getBuilderExtensions('js');
    }

    public function getBuilderExtensions($type)
    {
        $cssBuilderConf = $this->getConfig('css');
        $compileExts = [];
        foreach ($cssBuilderConf['builders'] as $builderConf) {
            $compileExts[] = array_merge($compileExts,
                $builderConf['extensions']);
        }
        return array_unique($compileExts);
    }

    /**
     * Compile all JS 
     * 
     * it takes all .coffe scripts and build it to js
     */
    public function compileJs()
    {
        
    }

    public function outputCss($collectionName = self::DEFAULT_COLLECTION_CSS)
    {
        $collection = $this->collection($collectionName);
        if ($collection->getJoin()) {
            $lifetime = $this->getConfig('lifetime');
            $filepath = self::GENERATED_STORAGE_PATH . $filename = $filename = $this->getCollectionFileName($collection,
                self::FILENAME_PATTERN_CSS);
            $collection
                ->setTargetPath($filepath)
                ->setTargetUri($filepath);

            if ($this->getCache()->exists($filename)) {
                return Tag::stylesheetLink($collection->getTargetUri());
            }

            $res = parent::outputCss($collectionName);

            $this->getCache()->save($filename, true, $lifetime);

            return $res;
        }
        return parent::outputCss($collectionName);
    }

    public function outputJs($collectionName = self::DEFAULT_COLLECTION_JS)
    {
        $collection = $this->collection($collectionName);
        if ($collection->getJoin()) {
            $lifetime = $this->getConfig('lifetime');
            $filepath = self::GENERATED_STORAGE_PATH . $filename = $filename = $this->getCollectionFileName($collection,
                self::FILENAME_PATTERN_CSS);
            $collection
                ->setTargetPath($filepath)
                ->setTargetUri($filepath);

            if ($this->getCache()->exists($filename)) {
                return Tag::stylesheetLink($collection->getTargetUri());
            }

            $res = parent::outputCss($collectionName);

            $this->getCache()->save($filename, true, $lifetime);

            return $res;
        }
        return parent::outputCss($collectionName);
    }

    public function getCollectionFileName(Collection $collection, $pattern)
    {
        return sprintf($pattern, crc32(serialize($collection)));
    }

    protected function getConfig($value)
    {
        return isset($this->_config[$value]) ? $this->_config[$value] : NULL;
    }

    protected function getCache()
    {
        return $this->getDI()->getShared('cache');
    }

}
