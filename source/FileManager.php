<?php


namespace CliqueTI\FileManager;

use Exception;


/**
 * Class FileManager
 * @package CliqueTI\FileManager
 */
abstract class FileManager {
    /** @var string $path */
    private $path;

    /** @var string $file */
    private $file;

    /** @var string $mode */
    private $mode;

    /** @var $handle */
    private $handle;

    /** @var Exception $fail */
    private $fail;

    /**
     * FileManager constructor.
     * @param string|null $path
     */
    public function __construct(string $path=null, string $dirPermission="0777") {
        $this->path = $this->checkPath($this->filter($path), $dirPermission);
    }

    /**
     * @param string|null $path
     * @return $this
     */
    protected function path(string $path=null, string $dirPermission="0777"):FileManager {
        $this->path = $this->checkPath($this->filter($path), $dirPermission);
        return $this;
    }

    /**
     * @param string|null $file
     * @return $this
     */
    protected function file(string $file=null, string $mode="r"):FileManager {
        $file = (empty($file)?"":($file[0] == "/" ? $file : "/{$file}"));
        $this->file = $this->filter($file);
        $this->mode = $this->filter($mode);
        return $this;
    }

    /**
     * @param string|null $mode
     * @return $this
     */
    protected function mode(string $mode=null):FileManager {
        $this->mode = $this->filter($mode);
        return $this;
    }

    /**
     * @return $this
     */
    protected function open():FileManager {
        try {
            $this->handle = fopen(str_replace('//','/',$this->path.$this->file),$this->mode);
        } catch (Exception $exception) {
            $this->fail = $exception;
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function close():FileManager {
        fclose($this->handle);
        return $this;
    }

    /**
     * @param string|null $path
     * @param string $mode
     * @return string|null
     */
    public function checkPath(string $path=null, string $mode="0777"):?string {
        if(!is_dir($path)){
            mkdir($path, $mode);
        }
        return $path;
    }

    /**
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getHandle() {
        return $this->handle;
    }

    /**
     * @param Exception $fail
     */
    public function fail(Exception $fail): void {
        $this->fail = $fail;
    }

    /**
     * @return mixed
     */
    protected function getFail() {
        return $this->fail;
    }

    /**
     * @param string|null $value
     * @return string
     */
    protected function filter(string $value=null):string {
        return filter_var($value,FILTER_SANITIZE_STRIPPED);
    }

}