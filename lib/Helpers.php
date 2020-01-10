<?php

/**
 * get User Profile picture URL
 *
 * @param string $email
 * @param int $size
 *
 * @return string
 */
function getUserProfile($email, $size)
{
    return "https://www.gravatar.com/avatar/" . md5($email) . "?size=" . $size;
}

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
 * get sub content without html tags
 *
 * @param string $content
 * @param int $length
 *
 * @return string
 */
function getSubContentWithoutHTMLTags($content, $length)
{
    return strip_tags(mb_substr($content, 0, $length));
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
