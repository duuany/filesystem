<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 29/04/2017
 * Time: 13:03
 */

namespace Corporatte\Filesystem;


abstract class FileOpenMode
{
    const FO_READ = 'rt';

    const FO_READ_BINARY = 'rb';

    const FO_WRITE_OR_CREATE = 'w';

    const FO_WRITE_OR_CREATE_BINARY = 'wb';

    const FO_APPEND_OR_CREATE = 'a';

    const FO_APPEND_OR_CREATE_BINARY = 'ab';

    const FO_READ_WRITE = 'r+t';

    const FO_READ_WRITE_BINARY = 'r+b';

    const FO_READ_WRITE_CREATE = 'w+t';

    const FO_READ_WRITE_CREATE_BINARY = 'w+b';

    const FO_READ_APPEND = 'a+t';

    const FO_READ_APPEND_BINARY = 'a+b';

    const FO_GET_PUT_CONTENTS = 'fo-contents';
}