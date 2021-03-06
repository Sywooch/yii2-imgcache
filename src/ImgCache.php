<?php

namespace LireinCore\Yii2ImgCache;

use Yii;
use yii\base\Object;

class ImgCache extends Object
{
    /**
     * @var array
     */
    public $config;

    /**
     * @var \LireinCore\ImgCache\ImgCache
     */
    private $_imgcache;

    /**
     * ImgCache constructor.
     *
     * @param $config array
     */
    public function __construct($config = [])
    {
        $this->_imgcache = new \LireinCore\ImgCache\ImgCache();

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!empty($this->config)) {
            $config = $this->config;

            if (isset($config['srcdir'])) {
                $config['srcdir'] = Yii::getAlias($config['srcdir']);
            }
            if (isset($config['destdir'])) {
                $config['destdir'] = Yii::getAlias($config['destdir']);
            }
            if (isset($config['webdir'])) {
                $config['webdir'] = Yii::getAlias($config['webdir']);
            }
            if (isset($config['baseurl'])) {
                $config['baseurl'] = Yii::getAlias($config['baseurl']);
            }
            if (isset($config['plug'])) {
                if (isset($config['plug']['path'])) {
                    $config['plug']['path'] = Yii::getAlias($config['plug']['path']);
                }
            }
            if (isset($config['presets'])) {
                foreach ($config['presets'] as $presetName => $preset) {
                    if (isset($preset['srcdir'])) {
                        $config['presets'][$presetName]['srcdir'] = Yii::getAlias($preset['srcdir']);
                    }
                    if (isset($preset['destdir'])) {
                        $config['presets'][$presetName]['destdir'] = Yii::getAlias($preset['destdir']);
                    }
                    if (isset($preset['webdir'])) {
                        $config['presets'][$presetName]['webdir'] = Yii::getAlias($preset['webdir']);
                    }
                    if (isset($preset['baseurl'])) {
                        $config['presets'][$presetName]['baseurl'] = Yii::getAlias($preset['baseurl']);
                    }
                    if (isset($preset['plug'])) {
                        if (isset($preset['plug']['path'])) {
                            $config['presets'][$presetName]['plug']['path'] = Yii::getAlias($preset['plug']['path']);
                        }
                    }
                    if (isset($preset['effects'])) {
                        foreach ($preset['effects'] as $ind => $effect) {
                            if ($effect['type'] == 'overlay') {
                                if (isset($effect['params']['path'])) {
                                    $config['presets'][$presetName]['effects'][$ind]['params']['path'] = Yii::getAlias($effect['params']['path']);
                                }
                            }
                        }
                    }
                }
            }

            $this->_imgcache->setConfig($config);
        }
    }

    /**
     * @param $config array|string
     */
    public function setConfig($config)
    {
        $this->_imgcache->setConfig($config);
    }

    /**
     * @param string $presetName
     * @param string|null $fileRelPath
     * @param bool $usePlug
     *
     * @return bool|string
     */
    public function path($presetName, $fileRelPath = null, $usePlug = true)
    {
        $fileRelPath = Yii::getAlias($fileRelPath);

        return $this->_imgcache->path($presetName, $fileRelPath, $usePlug);
    }

    /**
     * @param string|null $presetName
     * @param string|null $fileRelPath
     * @param bool $absolute
     * @param bool $usePlug
     *
     * @return bool|string
     */
    public function url($presetName = null, $fileRelPath = null, $absolute = false, $usePlug = true)
    {
        $fileRelPath = Yii::getAlias($fileRelPath);

        return $this->_imgcache->url($presetName, $fileRelPath, $absolute, $usePlug);
    }

    /**
     * @param string $fileRelPath
     * @param string|null $presetName
     */
    public function clearFileThumbs($fileRelPath, $presetName = null)
    {
        $fileRelPath = Yii::getAlias($fileRelPath);
        $this->_imgcache->clearFileThumbs($fileRelPath, $presetName);
    }

    /**
     * @param string|null $presetName
     */
    public function clearPlugsThumbs($presetName = null)
    {
        $this->_imgcache->clearPlugsThumbs($presetName);
    }

    /**
     * @param string $presetName
     */
    public function clearPresetThumbs($presetName)
    {
        $this->_imgcache->clearFileThumbs($presetName);
    }
}