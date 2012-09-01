<?php
include "theme.php";

uses('l10n'); 
class EnityView extends ThemeView {

    function _replaceVars($matches) {
        $var = $matches[1];
        $var = '$'.$var;
        return "<?php if(isset($var)) echo $var ?>";
    }

    function _replaceTags($matches) {
        $attributes = array();
        $class = Inflector::camelize($matches[1]);
        $method = $matches[2];
        $attributeString = $matches[3];

        $attributePieces = explode(' ', $attributeString);

        foreach($attributePieces as $attributePiece) {
            if ($attributePiece) {
                list($name, $value) = explode('=', $attributePiece);
                if ($value === null) {
                    $value = true;
                } else {
                    if($value[0] == '"')
                        $value = substr($value, 1, -1);
                }
                $attributes[$name] = $value;
            }
        }

        $content = false;
        if(isset($matches[5]))
            $content = $matches[5];

        Configure::write('debug', 4);

        $params = '';
        $helper = $class.'Helper';
        if(App::import('Helper',$class)) {
            $methodObject = new ReflectionMethod($helper, $method);
            $parameters = $methodObject->getParameters();
            foreach($parameters as $parameter) {
                $parameterObject = new ReflectionParameter(array($helper, $method), $parameter->name);
                if($parameterObject->isDefaultValueAvailable()) {
                    $default = $parameterObject->getDefaultValue();
                    if(is_array($default))
                        $default = 'array()';
                } else {
                    $default = 'null';
                }

                if($params) {
                    $params .= ', ';
                } elseif($content !== false) {
                    $params .= '"'.$content.'"';
                    continue;
                }

                if(isset($attributes[$parameter->name]))
                    $params .= '"'.$attributes[$parameter->name].'"';
                else
                    $params .= $default;
            }
        }

        return '<?php echo $this->'.$class.'->'.$method . '('.$params.'); ?>';

    }

    function getCachedFilename($fileName) {
        $fileName = ENITY_CACHE.str_replace(ROOT, '', $fileName);
        $filePath = dirname($fileName);
        if(__generateFolders($filePath))
            return $fileName;
        else
            return false;
    }

    function generateCache($viewFileName) {
        $content = file_get_contents($viewFileName);
        $content = str_replace("\n", '###n###', $content);
        $content = preg_replace_callback('#{{([a-z_]*)}}#i', 'self::_replaceVars', $content);
        $content = preg_replace_callback('#<([a-z]+):([a-z]+)( (.*))?/>#i', 'self::_replaceTags', $content);
        $content = preg_replace_callback('#<([a-z]+):([a-z]+)( (.*))?>(.*)</\\1:\\2>#i', 'self::_replaceTags', $content);
        $content = str_replace('###n###', "\n", $content);
        return $content;
    }

    function readCache($fileName) {
        return false;
        $cacheFile = $this->getCachedFilename($fileName);

        if (file_exists($cacheFile)) {
            return $cacheFile;
        }

        return false;
    }

    function writeCache($fileName, $content) {
        $cacheFile = self::getCachedFilename($fileName);
        file_put_contents($cacheFile, $content);
        return $cacheFile;
    }

    function generate($viewFileName) {
        $phpFile = $this->readCache($viewFileName);
        if (!$phpFile) {
            $content = $this->generateCache($viewFileName);
            $phpFile = $this->writeCache($viewFileName, $content);
        }
        return $phpFile;
    }

    function _render($___viewFn, $___dataForView, $loadHelpers = true, $cached = false) {
        $phpViewFile = $this->generate($___viewFn);
        return parent::_render($phpViewFile, $___dataForView, $loadHelpers, $cached);
    }
}