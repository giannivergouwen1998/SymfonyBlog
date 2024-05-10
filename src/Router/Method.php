<?php

namespace App\Router;

enum Method: string
{
    case GET = 'get';

    case POST = 'post';

    case PATCH = 'patch';

    case PUT = 'put';

    case DELETE = 'delete';

    case HEAD = 'head';

    case OPTION = 'option';
}
