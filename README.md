<h1 align="center"> sensitive-words-filter </h1>

<p align="center"> sensitive words filter.</p>


## Installing

```shell
$ composer require xiaobinqt/sensitive-words-filter -vvv
```

## 基本使用

```php
use Xiaobinqt\SensitiveWordsFilter\SensitiveWordsFilter;

$haystack = "淫色 | ?  [] sdfs0221。？！，、；：「」『』“”‘’（）【】《》〈〉    电影";
$obj = new SensitiveWordsFilter();
try {
    $ret = $obj->filter($haystack);
    var_dump($ret);
} catch (Exception $exception) {
    // TODO
}

```
## 返回的结果
```
array("淫色电影");
```


## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/xiaobinqt/sensitive-words-filter/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/xiaobinqt/sensitive-words-filter/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT