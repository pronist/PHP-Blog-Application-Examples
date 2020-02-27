<?php

return routes([
    [ '/image', 'get', 'image.show' ],
    [ '/image', 'post', 'image.store' ]
]) ?: header('HTTP/1.1 404 Not Found');
