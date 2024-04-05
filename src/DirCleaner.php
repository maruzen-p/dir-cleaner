<?php
namespace MaruzenP\DirCleaner;
require_once __DIR__.'/../vendor/autoload.php';

use Exception;
use Symfony\Component\Filesystem\Filesystem;

class DirCleaner
{
    /**
     * @var string
     * 削除対象のファイルが配置されているディレクトリのPATH
     */
    private string $path;
    /**
     * @var int
     * 秒数：何秒以上経過したファイルを削除するか
     */
    private int $threshold;

    /**
     * @var string
     * タイムゾーン
     */
    private string $timezone = 'Asia/Tokyo';

    public function __constructor(){

    }

    /**
     * @throws Exception
     */
    public function cleanUp(){
        // 指定のPathにある全てのファイルを配列で取得
        $files = glob($this->path."/*");

        // 現在のDateTimeオブジェクト
        $now = new \DateTime("now");

        $fs = new Filesystem();

        foreach ($files as $file){
            // ファイルのDateTimeオブジェクトを取得
            $then = new \DateTime(date("Y-m-d H:i:s", filemtime($file)));

            // DateTimeをタイムスタンプにして経過秒数を取得
            $interval = $now->format('U') - $then->format('U');

            if($interval > $this->threshold){
                // 閾値を越えると削除
                $fs->remove($file);
            }
        }
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return int
     */
    public function getThreshold(): int
    {
        return $this->threshold;
    }

    /**
     * @param int $threshold
     */
    public function setThreshold(int $threshold): void
    {
        $this->threshold = $threshold;
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     */
    public function setTimezone(string $timezone): void
    {
        $this->timezone = $timezone;
    }

}