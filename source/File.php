<?php


namespace CliqueTI\FileManager;

use Exception;

/**
 * Class File
 * @package CliqueTI\FileManager
 */
class File extends FileManager {

    /**
     * File constructor.
     * @param string|null $path
     */
    public function __construct(string $path = null) {
        parent::__construct($path);
    }

    /**
     * @param string|null $file
     * @return string|null
     */
    public function read(string $file=null):? string {
        try {
            $file = (empty($file)?"":($file[0] == "/" ? $file : "/{$file}"));
            $file = str_replace('//','/',$this->getPath().$file);
            if(file_exists($file)){
                return (file_get_contents($file)??null);
            }
            return null;
        } catch (Exception $exception) {
            $this->fail($exception);
            return null;
        }
    }

    /**
     * @param string|null $file
     * @return array|null
     */
    public function readByLine(string $file=null):? array {
        $this->file($file);
        $this->open();
        while(! feof($this->getHandle())) {
            $line = fgets($this->getHandle());
            $return[] = $line;
        }
        $this->close();
        return ($return??null);
    }

    /**
     * @param string $file
     * @param bool $associative
     * @return object|array|null
     */
    public function readFromJson(string $file, bool $associative = false) {
        try {
            $file = (empty($file)?"":($file[0] == "/" ? $file : "/{$file}"));
            $file = str_replace('//','/',$this->getPath().$file);
            return json_decode(file_get_contents($file), $associative);
        } catch (Exception $exception) {
            $this->fail($exception);
            return null;
        }
    }

    /**
     * @param string $file
     * @param string|null $content
     * @return $this
     */
    public function write(string $file, string $content = null):File {
        $this->file($file,'w')->open();
        fwrite($this->getHandle(), $content);
        $this->close();
        return $this;
    }

    /**
     * @param string $file
     * @param string|null $content
     * @return $this
     */
    public function update(string $file, string $content = null): File {
        $this->file($file,'a+')->open();
        fwrite($this->getHandle(), $content);
        $this->close();
        return $this;
    }

}