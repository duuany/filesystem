<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 29/04/2017
 * Time: 12:53
 */

namespace Corporatte\Filesystem;

use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function setup()
    {
        return File::open('dummyfile.txt', FileOpenMode::FO_READ);
    }

    public function test_if_is_instanciable_and_opens_and_close_a_file()
    {
        $file = $this->setup();
        $this->assertInstanceOf(File::class, $file);
        $file->close();
        //assert if close method works
        $this->assertEquals('unknown type', gettype($file->getHandle()));
    }

    public function test_if_read_a_line_file()
    {
        $file = $this->setup();

        $this->assertEquals("1234", $file->readLine());

        $file->close();
    }

    public function test_if_read_length_from_file()
    {
        $file = $this->setup();

        $this->assertEquals('123', $file->read(3));

        $file->close();
    }

    public function test_if_read_from_char_position_from_file()
    {
        $file = $this->setup();

        $this->assertEquals('678', $file->readFrom(7, 3));

        $file->close();
    }

    public function test_if_create_a_file()
    {
        $file = File::open('testdummy.txt', FileOpenMode::FO_WRITE_OR_CREATE);

        $this->assertEquals('resource', gettype($file->getHandle()));

        $file->close();
    }

    public function test_if_writes_a_file()
    {
        $file = File::open('testdummy.txt', FileOpenMode::FO_WRITE_OR_CREATE);

        $this->assertTrue($file->write('1234') !== false);

        $file->close();

    }

    public function test_if_appends_and_reads_data_from_a_file()
    {
        $file = File::open('testdummy.txt', FileOpenMode::FO_READ_APPEND);

        $file->write("5678");

        $this->assertEquals("12345678", $file->readFrom(0, 8));

        $file->close();
    }

    public function test_if_writes_a_line_on_file()
    {
        $file = File::open('testdummy.txt', FileOpenMode::FO_READ_APPEND);

        $file->writeLine('');
        $file->writeLine('abcd');

        $this->assertEquals("abcd", $file->readFrom(10, 4));

        $file->close();
    }

    public function test_if_get_a_file_size()
    {
        $file = $this->setup();

        $this->assertEquals(16, $file->getSize());

        $file->close();
    }

    public function test_if_a_file_exists()
    {
        $this->assertTrue(File::exists('testdummy.txt'));
    }

    public function test_if_gets_file_fullname()
    {
        $file = $this->setup();

        $this->assertEquals('C:\Users\Jorge\Code\corporatte-filesystem\dummyfile.txt', $file->getFullPath());

        $file->close();
    }

    public function test_if_get_a_file_directory()
    {
        $file = $this->setup();

        $this->assertEquals('C:\Users\Jorge\Code\corporatte-filesystem', $file->getPath());

        $file->close();
    }

    public function test_if_get_a_file_name()
    {
        $file = $this->setup();

        $this->assertEquals('dummyfile', $file->getName());

        $file->close();
    }

    public function test_if_get_a_file_fullname()
    {
        $file = $this->setup();

        $this->assertEquals('dummyfile.txt', $file->getFullName());

        $file->close();
    }

    public function test_if_get_file_extension()
    {
        $file = $this->setup();

        $this->assertEquals('txt', $file->getExtension());

        $file->close();
    }

    public function test_if_get_file_info()
    {
        $file = $this->setup();

        $this->assertEquals([
            'dirname'=>'C:\Users\Jorge\Code\corporatte-filesystem',
            'basename'=>'dummyfile.txt',
            'extension'=>'txt',
            'filename'=>'dummyfile'
        ], $file->getFileInfo());

        $file->close();
    }

    public function test_if_get_contents()
    {
        $file = File::open('dummyfile.txt', FileOpenMode::FO_GET_PUT_CONTENTS);

        $this->assertEquals("1234".PHP_EOL."5678".PHP_EOL."90-=", $file->getContents());

    }

    public function test_if_put_contents()
    {
        $file = File::open('dummyfile.txt', FileOpenMode::FO_GET_PUT_CONTENTS);

        $file->putContents("1234");

        $this->assertEquals("1234", $file->getContents());
    }

    public function test_if_preserve_put_contents()
    {
        $file = File::open('dummyfile.txt', FileOpenMode::FO_GET_PUT_CONTENTS);

        $file->putContents(PHP_EOL."5678".PHP_EOL."90-=", true);

        $this->assertEquals("1234".PHP_EOL."5678".PHP_EOL."90-=", $file->getContents());
    }
}
