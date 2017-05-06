<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 29/04/2017
 * Time: 12:47
 */

namespace Corporatte\Filesystem;

use Corporatte\Filesystem\Contracts\File as FileContract;
use Corporatte\Filesystem\Exceptions\FileOpenException;
use Corporatte\Filesystem\Exceptions\FileReadException;

class File implements FileContract
{

    protected $handle;

    protected $path;

    protected $mode;

    private function __construct($path, $mode)
    {
        if ($mode == FileOpenMode::FO_READ) {
            $this->checkFile($path);
        }

        if ($mode != FileOpenMode::FO_GET_PUT_CONTENTS) {
            $this->handle = fopen($path, $mode);
        }

        $this->path = $path;

        return $this;
    }

    public static function open($path, $mode)
    {
//        $class = new \ReflectionClass(FileOpenModes::class);
//        $constants = $class->getConstants();
//
//        if (! in_array($mode, $constants)) {
//            throw new \InvalidArgumentException('Parameter `$mode` needs to be a constant member of FileOpenModes.');
//        }

        $instance = new static($path, $mode);

        return $instance;
    }

    public static function exists($path)
    {
        return file_exists($path);
    }

    public function getContents()
    {
        if (!self::exists($this->path)) {
            throw new FileOpenException("File `$this->path` not exists.");
        }

        return file_get_contents($this->path);
    }

    public function putContents($content, $preserve = false)
    {
        if ($preserve) {
            $content = $this->getContents() . $content;
        }

        return file_put_contents($this->path, $content);
    }

    public function close()
    {
        return fclose($this->handle);
    }

    public function read($length)
    {
        $this->checkLengthArgument($length);

        return fread($this->handle, $length);
    }

    public function readLine($length = null)
    {
        $this->checkLengthArgument($length);

        if (gettype($this->handle) != 'resource') {
            throw new FileReadException("File is closed, not exists or stream it's not valid.");
        }

        if (isset($length)) {
            return trim(fgets($this->handle, $length));
        }

        return trim(fgets($this->handle));
    }

    public function readFrom($from, $length)
    {
        $this->checkLengthArgument($length);

        if (! is_integer($from)) {
            throw new \InvalidArgumentException('Parameter `$from` must be integer');
        }

        fseek($this->handle, $from);

        return $this->read($length);
    }

    public function write($string, $length = null)
    {
        if (! is_string($string)) {
            throw new \InvalidArgumentException('Parameter `$string` must be a string');
        }

        $this->checkLengthArgument($length);

        if (isset($length)) {
            return fwrite($this->handle, $string, $length);
        }

        return fwrite($this->handle, $string);
    }

    public function writeLine($string, $length = null)
    {
        return $this->write("$string\n", $length);
    }

    protected function checkFile($path)
    {
        if (! file_exists($path)) {
            throw new FileOpenException("File $path, not found!");
        }
    }

    public function getHandle()
    {
        return $this->handle;
    }

    public function getSize()
    {
        return filesize($this->path);
    }

    public function getPath()
    {
        return $this->getFileInfo('dirname');
    }

    public function getExtension()
    {
        return $this->getFileInfo('extension');
    }

    public function getName()
    {
        return $this->getFileInfo('filename');
    }

    public function getFullName()
    {
        return $this->getFileInfo('basename');
    }

    public function getFullPath()
    {
        return $this->getFileInfo('dirname') . DIRECTORY_SEPARATOR . $this->getFileInfo('basename');
    }

    public function isEof()
    {
        return feof($this->handle);
    }

    /*
     * ******* PRIVATE FUNCTIONS
     */
    private function checkLengthArgument($argument)
    {
        if (! is_integer($argument) && ! is_null($argument)) {
            throw new \InvalidArgumentException('Parameter `$length` must be integer');
        }
    }

    public function getFileInfo($info = null)
    {
        $fileProps = pathinfo($this->path);

        if ($fileProps['dirname'] == '.') {
            $fileProps['dirname'] = getcwd();
        }

        return ($info === null) ? $fileProps: $fileProps[$info];
    }
}