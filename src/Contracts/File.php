<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 29/04/2017
 * Time: 12:33
 */

namespace Corporatte\Filesystem\Contracts;

/*
 * A simple File interface
 */
/**
 * Interface File
 * @package Corporatte\CsvProcessor\Contracts
 */
interface File
{
    public static function open($path, $mode);

    public static function exists($path);

    public function close();

    public function read($length);

    public function readLine($length = null);

    public function readFrom($from, $length);

    public function write($string, $length = null);

    public function writeLine($string, $length = null);

    public function getHandle();

    public function getSize();

    public function getPath();

    public function getFullPath();

    public function getName();

    public function getFullName();

    public function getExtension();

    public function isEof();

    public function getContents();

    public function putContents($content, $preserve = false);
}