<?php
abstract class AST_ShortCodeLoader
  {
    public function register($shortcodeName)
      {
        $this->registerShortcodeToFunction($shortcodeName, 'handleShortcode');
      }
    protected function registerShortcodeToFunction($shortcodeName, $functionName)
      {
        if (is_array($shortcodeName))
          {
            foreach ($shortcodeName as $aName)
              {
                add_shortcode($aName, array(
                    $this,
                    $functionName
                ));
              }
          }
        else
          {
            add_shortcode($shortcodeName, array(
                $this,
                $functionName
            ));
          }
      }
    public abstract function handleShortcode($atts);
  }