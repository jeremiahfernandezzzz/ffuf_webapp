<?php

namespace a15l\serialization\metadata\loader\file;

abstract class AbstractFileLoader implements FileLoaderInterface{

    /**
     * @var string
     */
    protected $configDir;

    /**
     * @var array
     */
    protected $configDirs = array();

    /**
     * @var string
     */
    protected $suffix;

    /**
     * AbstractFileLoader constructor.
     * @param string $configDir
     * @param string $suffix
     */
    public function __construct($configDir, $suffix){
        $this->configDir = $configDir;
        $this->suffix = $suffix;
    }

    /**
     * Adds another directory path that will be scanned for the required metadata files.
     * @param string $dir
     */
    public function addConfigDir($dir){
        $this->configDirs[] = $dir;
    }

    protected function getAbsFileName($fileName){
        $file = $this->configDir . DIRECTORY_SEPARATOR . $fileName . '.' . $this->suffix;
        if (file_exists($file) === true) {
            return $file;
        }
        foreach ($this->configDirs as $dir) {
            $file = $dir . DIRECTORY_SEPARATOR . $fileName . '.' . $this->suffix;
            if (file_exists($file) === true) {
                return $file;
            }
        }
        return null;
    }

}