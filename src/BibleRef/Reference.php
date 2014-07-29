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
    $book = ['name' => "", 'chapter' => "", 'verses' => []];
    $parts = preg_split('/\s*:\s*/', trim($this->reference, " ;"));
    if(isset($parts[0])) {
      if(preg_match('/\d+\s*$/', $parts[0], $out)) {
        $book['chapter'] = rtrim($out[0]);
      }
      $book['name'] = trim(preg_replace('/\d+\s*$/', "", $parts[0]));
    }
    if(isset($parts[1])) {
      $book['verses'] = preg_split('~\s*,\s*~', $parts[1]);
    }

    return $book;
  }

}
