<?php
namespace BibleRef;

class Reference {
  private $book;
  private $reference;
  private $details;

  function __construct($reference) {
    $this->reference = $reference;
  }

  public function getName() {
    return $this->reference;
    #test nu merge mah
  }
}
