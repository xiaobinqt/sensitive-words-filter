<?php
/**
 * Created by PhpStorm.
 * User: BinWei
 * Date: 2019/7/24
 * Time: 19:40
 */


namespace Xiaobinqt\SensitiveWordsFilter;

use Xiaobinqt\SensitiveWordsFilter\Exceptions\Exception;
use Xiaobinqt\SensitiveWordsFilter\Exceptions\ExecException;
use Xiaobinqt\SensitiveWordsFilter\Exceptions\FileException;

class SensitiveWordsFilter
{

    private $sensitiveRealPath = '';
    private $customSensitiveArray = array(); // 自定义敏感词数组
    private $defaultSensitiveFilePath = __DIR__ . DIRECTORY_SEPARATOR . "data/keywords.txt"; // 默认的敏感词文件
    private $lines = array(); // 读取的敏感词数组

    /**
     * SensitiveWordsFilter constructor.
     * @param string $customSensitiveFileRealPath
     * @param array $customSensitiveArray
     */
    public function __construct($customSensitiveFileRealPath = '', array $customSensitiveArray = array())
    {

        $this->sensitiveRealPath = empty($customSensitiveFileRealPath) ? $this->defaultSensitiveFilePath : $customSensitiveFileRealPath;
        $this->customSensitiveArray = $customSensitiveArray;
    }


    /**
     * @description 过滤函数
     * @param $haystack
     * @return array
     * @throws Exception
     * @throws ExecException
     * @throws FileException
     * @author BinWei
     */
    public function filter($haystack)
    {
        $startTime = microtime(true);
        if (!file_exists($this->sensitiveRealPath)) {
            throw new Exception("sensitive file not exist ");
        }
        if (!empty($this->customSensitiveArray)) {
            $this->lines = $this->customSensitiveArray;
        } else {
            $this->lines = file($this->sensitiveRealPath);
            if (!$this->lines) {
                throw new FileException("load sensitive words file fail ");
            }
        }

        try {
            $preg = "/[\x{4e00}-\x{9fa5}]+/u";
            if (preg_match_all($preg, $haystack, $matches)) {
                $haystack = strtolower(str_replace(',', "", implode(',', $matches[0])));
                foreach ($this->lines as $line) {
                    $line = trim($line);
                    if (empty($line)) {
                        continue;
                    }
                    $pattern = "/{$line}/i";
                    // 如果匹配到了敏感词就停止
                    $ret = preg_match_all($pattern, strtolower($haystack), $matches);
                    if ($ret) {
                        $sensitive_words = $matches[0];
                        $endTime = microtime(true);
                        return array(
                            'costTimeMs'     => ($endTime - $startTime) * 1000,
                            'sensitiveWords' => array_unique($sensitive_words)
                        );
                        break;
                    }
                }
            }
            return array();
        } catch (\Exception $exception) {
            throw new ExecException("program execution error ");
        }
    }
}