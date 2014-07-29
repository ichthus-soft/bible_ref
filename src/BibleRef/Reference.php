<?php
namespace BibleRef;

class Reference {
  private $book;
  private $reference;
  private $details;
  private $current = 0;
  private $emptyVersesIfMultiple;
  private $sort = false;

  function __construct($reference, $empty = true) {
    $empty = (bool) $empty;
    $this->emptyVersesIfMultiple = $empty;
    $this->reference = $reference;
  }

  public function sort($val) {
    $this->sort = (bool)$val;
  }

  function getArray() {
    if(Utils::multiple($this->reference)) {
      $book = [];
      $books = explode(';',$this->reference);
      foreach($books as $_b) {
        $temp = ['name' => "", 'chapter' => "", 'verses' => []];

        $temp = $this->process($temp,$_b);

        if(count($temp['verses']) == 0 AND !$this->emptyVersesIfMultiple) {
           $temp['verses'] = $temp['chapter'];
        }
        array_push($book,$temp);
        $this->resetCount();
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
    $parts = preg_split('/\s*:\s*/', trim($string, " ;"),2);
    if(isset($parts[0])) {
      if(preg_match('/\d+\s*$/', $parts[0], $out)) {
        // var_dump($parts);
        if(Utils::hasMoreChapters($parts)) {
          $book['chapter'] = [];
          $book['chapter'][rtrim($out[0])] = rtrim($out[0]);
          preg_match_all('/\d+(?=:)/', $parts[1], $others);
          foreach($others[0] as $intt) {
            $book['chapter'][$intt] = $intt;
          }
          }
        else
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
    if(is_array($book['chapter'])) {
      // var_dump($verse);
      if(Utils::hasMoreChapters($verse)) {
        $parts = explode('&',$verse);
        $cnt = 0;
        foreach($parts as $p) {
          // $this->current++;
          // var_dump($p);
          $cnt++;
          if($cnt > 1) $this->current++;
          preg_match_all('/(?<=:)[^&]*/', $p, $mt);
          if(empty($mt[0])) {
            $_s = array_keys($book['chapter']);
            $keyy = $_s[$this->current];
            // var_dump($mt[0]); die;
            // var_dump($p);
            $this->addToChapter($keyy, $p, $book, $key);
          } else {
              $_cnt = $this->current - 1;
              // echo $_cnt;
              $slice = array_slice($book['chapter'], $this->current, 1);
              // $keyy = foreach($)

              $pts = explode(':',$p);
              // var_dump($slice);
              $this->addToChapter($slice[0], $pts[1], $book, $key);
          }
        }
      } else {
        $_s = array_keys($book['chapter']);
        $keyy = $_s[$this->current];
        // var_dump($keyy);
        $this->addToChapter($keyy, $verse, $book, $key);
        unset($book['verses'][$key]);
      }
    } else {
      $this->singleton($verse, $book, $key);
    }
  }

  private function singleton($verse, &$book, &$key) {
    if(Utils::IsARange($verse)) {
        foreach(Utils::getVersesArray($verse) as $verse) {
          array_push($book['verses'], $verse);
        }
        unset($book['verses'][$key]);
      } else {
        $book['verses'][$key] = (int)$verse;
      }
  }

  private function addToChapter($chapter, $verse, &$book, &$key) {
    $array = [];
    // var_dump($chapter);
    if(!is_array($book['chapter'][$chapter]))
      $book['chapter'][$chapter] = [];
    if(!$this->emptyVersesIfMultiple) {
      // echo $chapter.' ';
      // $book['verses']['test'] = ['test'];
      // var_dump($book);
    }
    // var_dump($verse);
    if(Utils::IsARange($verse)) {
        foreach(Utils::getVersesArray($verse) as $verse) {
          array_push($book['chapter'][$chapter], $verse);
        }
        unset($book['verses'][$key]);
      } else {
        $book['chapter'][$chapter][] = (int)$verse;
      }
      return $book;
  }


  private function resetCount() {
    $this->current = 0;
  }
}
