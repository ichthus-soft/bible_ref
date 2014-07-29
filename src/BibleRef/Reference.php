<?php
namespace BibleRef;

class Reference {
  private $book;
  private $reference;
  private $details;

  function __construct($reference) {
    $this->reference = $reference;
  }

  function getArray() {
    if(Utils::multiple($this->reference)) {
      $book = [];
      $books = explode(';',$this->reference);
      foreach($books as $_b) {
        $temp = ['name' => "", 'chapter' => "", 'verses' => []];

        $temp = $this->process($temp,$_b);
        array_push($book,$temp);
      }
    } else {
      $book = ['name' => "", 'chapter' => "", 'verses' => []];

      $book = $this->process($book);
    }

    return $book;
  }

  private function process($book, $string = '') {
    if(strlen($string) == 0)
      $string = $this->reference;
    $parts = preg_split('/\s*:\s*/', trim($string, " ;"));
    if(isset($parts[0])) {
      if(preg_match('/\d+\s*$/', $parts[0], $out)) {
        $book['chapter'] = rtrim($out[0]);
      }
      $book['name'] = trim(preg_replace('/\d+\s*$/', "", $parts[0]));
    }
    if(isset($parts[1])) {
      $book['verses'] = preg_split('~\s*,\s*~', $parts[1]);
    }
    foreach($book['verses'] as $key => $verse) {
      // var_dump($verse);
      $this->process_verse($verse, $book, $key);
    }
    sort($book['verses']);
    return $book;
  }

  private function process_verse($verse, &$book, &$key) {
    if(Utils::IsARange($verse)) {
        foreach(Utils::getVersesArray($verse) as $verse) {
          array_push($book['verses'], $verse);
        }
        unset($book['verses'][$key]);
      } else {
        $book['verses'][$key] = (int)$verse;
      }
  }

}
