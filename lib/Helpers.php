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

/**
 * get a post thumbnail
 *
 * @param string $content
 *
 * @return string
 */
function getPostThumbnail($content)
{
    preg_match('/(\<img .*\/\>)/m', $content, $matches);
    if (count($matches) > 1) {
        return $matches[1];
    }
    return null;
}

/**
 * get posts with transform
 *
 * @param array $post
 * @param string $username
 *
 * @return array
 */
function getPostsWithTransform($post, $username)
{
    $post['username'] = $username;
    $post['author'] = "/board/list.php?user=" . urlencode($post['username']);
    $post['thumbnail'] = getPostThumbnail($post['content']);
    $post['content'] = getSubContentWithoutHTMLTags($post['content'], 200);
    $post['created_at'] = getPostCreatedAt($post['created_at']);
    $post['url'] = "/board/read.php?id=" . $post['id'];

    return $post;
}
