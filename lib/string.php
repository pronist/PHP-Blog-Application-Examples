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
 * strip tags without editor HTML
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
