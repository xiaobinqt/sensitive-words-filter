<?php
/**
 * Created by PhpStorm.
 * User: v_bivwei
 * Date: 2019/7/24
 * Time: 19:40
 */


namespace Xiaobinqt\SensitiveWordsFilter;

use Xiaobinqt\SensitiveWordsFilter\Exceptions\Exception;
use Xiaobinqt\SensitiveWordsFilter\Exceptions\FileException;

class SensitiveWordsFilter
{
    /**
     * @description 过滤函数
     * @param $haystack
     * @return array|mixed
     * @throws Exception
     * @throws FileException
     * @author BinWei
     */
    public function filter($haystack)
    {

        $lines = file(__DIR__ . DIRECTORY_SEPARATOR . "data/keywords");
        if (!$lines) {
            throw new FileException("load sensitive words file error;failed to open stream: No such file or directory");
        }

        try {
            $preg = "/[\x{4e00}-\x{9fa5}]+/u";
            if (preg_match_all($preg, $haystack, $matches)) {
                $haystack = strtolower(str_replace(',', "", implode(',', $matches[0])));
                $pattern = "/{$haystack}/i";
                foreach ($lines as $line) {
                    $line = rtrim($line);
                    // 过滤常用字符串中的特殊字符
                    // $special_character = "[`?~!@#$%^&*()_+\|-=\{\}\[\]:\";'\\。？！，、；：「」『』“”‘’（）【】《》〈〉\s+\w+]";
                    $ret = preg_match_all($pattern, strtolower($line), $matches);
                    if ($ret) {
                        $sensitive_words = $matches[0];
                        return $sensitive_words;
                        break;
                    }
                }
            }
            return array();
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}