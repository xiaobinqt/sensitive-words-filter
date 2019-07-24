<?php
/**
 * Created by PhpStorm.
 * User: v_bivwei
 * Date: 2019/7/24
 * Time: 19:53
 */

namespace Xiaobinqt\SensitiveWordsFilter\Tests;

use PHPUnit\Framework\TestCase;
use Xiaobinqt\SensitiveWordsFilter\Exceptions\FileException;
use Xiaobinqt\SensitiveWordsFilter\SensitiveWordsFilter;

class SensitiveWordsFilterTest extends TestCase
{
    public function testFilter()
    {
        // 加载文件测试,将文件名修改
        $haystack = "淫色 | ?  [] sdfs0221。？！，、；：「」『』“”‘’（）【】《》〈〉    电影";
        $obj = new SensitiveWordsFilter();
        $this->expectException(FileException::class);
        $this->expectExceptionMessage("load sensitive words file error;failed to open stream: No such file or directory");
        $obj->filter($haystack);
        $this->fail('Failed to assert throw exception with invalid argument.');
    }
}