<?php

/**
 * get Post created date time from mysql timestamp
 *
 * @param string $timestamp
 *
 * @return string
 */
function getPostCreatedAt($timestamp)
{
    return date('h:i A, M j', strtotime($timestamp));
}

/**
 * remove specific tags
 *
 * @param string $content
 * @param array $tags
 *
 * @return string
 */
function removeTags($content, ...$tags)
{
    foreach ($tags as $tag) {
        $content = preg_replace("/\<(\/?)$tag\>/", '', $content);
    }
    return $content;
}

/**
 * Define javascript variables
 *
 * @param array $args
 *
 * @return string
 */
function jsVar($args)
{
    $script = "<script>";
    foreach ($args as $name => $value) {
        $var = "let {$name} = ";
        switch (gettype($value)) {
            case 'integer':
                $var .= $value;
                break;
            case 'string':
                $var .= "'$value'";
                break;
            case 'array':
                $var .= json_encode($value);
                break;
        }
        $script .= $var .= ';';
    }
    return $script .= "</script>";
}
