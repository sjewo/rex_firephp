<?php
  if(!function_exists('rexdev_css_add'))
  {
    function rexdev_css_add($params) {
      global $REX;
      
      fb($params,'$params IN');
      $params['subject'] .= "\n".$params['css'];
      fb($params,'$params OUT');
      
      return $params['subject'];
    }
  }
?>