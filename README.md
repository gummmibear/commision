# commission calculator

# setup:
```composer i```

# run
```bin/import data/file.txt```

```
gbear@gbear:~/PhpProjects/commission$ bin/import data/file.txt 
Importing file: data/file.txt
Bin: 45717360 => 1
Bin: 516793 => 0.45
Bin: 45417360 => 1.21
Bin: 41417360 => 2.34
Bin: 4745030 => 23.76
```


```bin/bin {binNumber}``` - debug command


# run unit test
```./vendor/bin/phpunit tests```

```
gbear@gbear:~/PhpProjects/commission$ ./vendor/bin/phpunit tests
PHPUnit 12.1.5 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.4.5

......................................W.......                    46 / 46 (100%)

Time: 00:00.021, Memory: 10.00 MB

OK, but there were issues!
Tests: 46, Assertions: 51, Warnings: 1.

```

