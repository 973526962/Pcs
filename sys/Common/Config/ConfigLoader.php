<?php
namespace Pcs\Common\Config;

use Pcs\Common\File\File;
use Pcs\Common\Path\Path;
use Pcs\Common\Traits\Singleton;

class ConfigLoader
{
    use Singleton;

    public function load($path)
    {
        $configMap = array();
        $configs = scandir($path);
        $configs = File::fileTypeFilter('php', $configs);
        foreach ($configs as $config) {
            $ret = require $path . '/' . $config;
            if (!is_array($ret)) {
                throw new \Exception('config format error');
            }
            $config = substr($config, 0, -4);
            $configMap[$config] = $ret;
        }

        return $configMap;
    }
}