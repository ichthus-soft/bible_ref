<?php
namespace BibleRef;

class Utils {
  public static function multiple($string) {
    return strpos($string,';') !== false;
  }
  public static function isARange($string) {
    return strpos($string,'-') !== false;
  }

  public static function getVersesArray($range) {
    return Utils::list2array($range);
  }

  public static function list2array ($list) {
    $array = explode(',', $list);
    $return = array();
    foreach ($array as $value) {
        $explode2 = explode('-', $value);
        if (count($explode2) > 1) {
            $range = range($explode2[0], $explode2[1]);
            $return = array_merge($return, $range);
        } else {
            $return[] = (int) $value;
        }
    }
    return $return;
}
}
