Bible_ref
=====================
About the project
---------

**Bible_ref** is a composer package that transforms real text references into PHP an PHP array for better handling in MySQL queries or stuff like that. 

### Query syntax ###
```
# You can add a single verse
$single = new Reference('John 3:16');
# You can add a range of verses
$range = new Reference('John 3:1-16');
# You can ask for multiple chapters
$multiple = new Reference('John 3:1&4:1-10');
# You can even ask for two books
$books = new Reference('John 3:16;Acts 1:1-10');
# You can combine all of the above
$uberCool = new Reference('John 3:16&1:1;Acts 5:1-15;Genesis 1:1-20&2:1');
```
So, to summarize:
* The format is BookName chapter:verse[-endVerse] (Genesis 1:1[-10])
* To add another chapter, concatenate with **&** (Genesis 1:1&2:1)
* To add another book, concatenate with **;** (that's a semi-colon) (Genesis 1:1;Acts 1:1)

#### Be careful! ####

If you add multiple chapters, the ```verses``` return value will be default empty and the ```chapters``` return value will be an array of chapters with the verses associated.

```
array (size=3)
  'name' => string 'John' (length=4)
  'chapter' => 
    array (size=2)
      1 => 
        array (size=1)
          0 => int 1
      2 => 
        array (size=1)
          0 => int 1
  'verses' => 
    array (size=0)
```

In order to get the verses in the return value ```verses``` you have to init the Reference class with the second parameter set to ```false```:
```$test = new Reference('John 1:1&2:1', false);```

And basically the ```verses``` key of the returned array will be a clone of the ```chapter``` key (an associative array with chapterNumber => array()  of verses!

Examples
-------------------
```
require_once __DIR__ . '/vendor/autoload.php';
use BibleRef\Reference;
$test = new Reference('John 3:16');
$array = $test->getArray();
var_dump($array);
/**
Returns something like:
array (size=3)
  'name' => string 'John' (length=4)
  'chapter' => string '3' (length=1)
  'verses' => 
    array (size=1)
      0 => int 16
**/
```

#### More advanced example ####
```
require_once __DIR__ . '/vendor/autoload.php';

use BibleRef\Reference;
$test = new Reference('Ioan 1:1-4,5,6,9,11-14,20-27&2:1,4-10;Evrei 12:16,1-5,22-27&22:1,5-6&4:88,55,1-3');
$array = $test->getArray();
echo '<pre>';
print_r($array);
```
returns this
```
Array
(
    [0] => Array
        (
            [name] => Ioan
            [chapter] => Array
                (
                    [1] => Array
                        (
                            [0] => 1
                            [1] => 2
                            [2] => 3
                            [3] => 4
                            [4] => 5
                            [5] => 6
                            [6] => 9
                            [7] => 11
                            [8] => 12
                            [9] => 13
                            [10] => 14
                            [11] => 20
                            [12] => 21
                            [13] => 22
                            [14] => 23
                            [15] => 24
                            [16] => 25
                            [17] => 26
                            [18] => 27
                        )

                    [2] => Array
                        (
                            [0] => 1
                            [1] => 4
                            [2] => 5
                            [3] => 6
                            [4] => 7
                            [5] => 8
                            [6] => 9
                            [7] => 10
                        )

                )

            [verses] => Array
                (
                    [1] => Array
                        (
                            [0] => 1
                            [1] => 2
                            [2] => 3
                            [3] => 4
                            [4] => 5
                            [5] => 6
                            [6] => 9
                            [7] => 11
                            [8] => 12
                            [9] => 13
                            [10] => 14
                            [11] => 20
                            [12] => 21
                            [13] => 22
                            [14] => 23
                            [15] => 24
                            [16] => 25
                            [17] => 26
                            [18] => 27
                        )

                    [2] => Array
                        (
                            [0] => 1
                            [1] => 4
                            [2] => 5
                            [3] => 6
                            [4] => 7
                            [5] => 8
                            [6] => 9
                            [7] => 10
                        )

                )

        )

    [1] => Array
        (
            [name] => Evrei
            [chapter] => Array
                (
                    [12] => Array
                        (
                            [0] => 16
                            [1] => 1
                            [2] => 2
                            [3] => 3
                            [4] => 4
                            [5] => 5
                            [6] => 22
                            [7] => 23
                            [8] => 24
                            [9] => 25
                            [10] => 26
                            [11] => 27
                        )

                    [22] => Array
                        (
                            [0] => 1
                            [1] => 5
                            [2] => 6
                        )

                    [4] => Array
                        (
                            [0] => 88
                            [1] => 55
                            [2] => 1
                            [3] => 2
                            [4] => 3
                        )

                )

            [verses] => Array
                (
                    [12] => Array
                        (
                            [0] => 16
                            [1] => 1
                            [2] => 2
                            [3] => 3
                            [4] => 4
                            [5] => 5
                            [6] => 22
                            [7] => 23
                            [8] => 24
                            [9] => 25
                            [10] => 26
                            [11] => 27
                        )

                    [22] => Array
                        (
                            [0] => 1
                            [1] => 5
                            [2] => 6
                        )

                    [4] => Array
                        (
                            [0] => 88
                            [1] => 55
                            [2] => 1
                            [3] => 2
                            [4] => 3
                        )

                )

        )

)
```
