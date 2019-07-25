<?php
/**
 * Created by PhpStorm.
 * User: BinWei
 * Date: 2019/7/24
 * Time: 19:53
 */

namespace Xiaobinqt\SensitiveWordsFilter\Tests;

use PHPUnit\Framework\TestCase;
use Xiaobinqt\SensitiveWordsFilter\Exceptions\Exception;
use Xiaobinqt\SensitiveWordsFilter\SensitiveWordsFilter;

class SensitiveWordsFilterTest extends TestCase
{
    public function testFilter()
    {
        // 加载文件测试,测试如果敏感词文件不存在异常
        $haystack = "淫色 | ?  [] sdfs0221。？！，、；：「」『』“”‘’（）【】《》〈〉    电影";
        $obj = new SensitiveWordsFilter();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("sensitive file not exist ");

        $obj->filter($haystack);
        $this->fail('Failed to assert throw exception with invalid argument.');
    }
}