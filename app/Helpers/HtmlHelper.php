<?php

namespace App\Helpers;

/**
 * HTML Sanitization Helper
 * 
 * Provides strict validation and sanitization for HTML content from CKEditor
 * Only allows safe tags: <p>, <strong>, <em>, <u>, <h1-h6>, <ul>, <ol>, <li>, <blockquote>, <a>, <br>
 */
class HtmlHelper
{
    /**
     * Sanitize HTML content to allow only safe tags
     * 
     * @param string $html
     * @return string
     */
    public static function sanitize($html)
    {
        if (empty($html)) {
            return '';
        }

        // Define allowed tags
        $allowed_tags = '<p><strong><em><u><h1><h2><h3><h4><h5><h6><ul><ol><li><blockquote><a><br><i><b>';

        // Strip all tags except allowed ones
        $sanitized = strip_tags($html, $allowed_tags);

        // Further sanitization using DOM
        return static::sanitizeAttributes($sanitized);
    }

    /**
     * Remove dangerous attributes from tags
     * 
     * @param string $html
     * @return string
     */
    private static function sanitizeAttributes($html)
    {
        // Create DOM document
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'UTF-8');

        // Suppress warnings for malformed HTML
        if (!@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'))) {
            return '';
        }
        libxml_clear_errors();

        // Process all elements
        $nodes = $dom->getElementsByTagName('*');
        foreach ($nodes as $node) {
            static::removeUnsafeAttributes($node);
        }

        // Get the inner HTML
        $body = $dom->getElementsByTagName('body')->item(0);
        if (!$body) {
            return '';
        }

        $html_output = '';
        foreach ($body->childNodes as $child) {
            $html_output .= $dom->saveHTML($child);
        }

        return $html_output;
    }

    /**
     * Remove unsafe attributes from a node
     * 
     * @param \DOMElement $node
     * @return void
     */
    private static function removeUnsafeAttributes($node)
    {
        // Only allow href for <a> tags, no other attributes
        if ($node->nodeName === 'a') {
            $href = $node->getAttribute('href');
            // Clear all attributes
            while ($node->attributes->length > 0) {
                $node->removeAttribute($node->attributes->item(0)->name);
            }
            // Re-add href if it's safe
            if ($href && static::isSafeUrl($href)) {
                $node->setAttribute('href', $href);
                $node->setAttribute('target', '_blank');
                $node->setAttribute('rel', 'noopener noreferrer');
            }
        } else {
            // Remove all attributes from other tags
            while ($node->attributes && $node->attributes->length > 0) {
                $node->removeAttribute($node->attributes->item(0)->name);
            }
        }
    }

    /**
     * Check if URL is safe (no javascript: or data: protocols)
     * 
     * @param string $url
     * @return bool
     */
    private static function isSafeUrl($url)
    {
        $url = strtolower(trim($url));

        // Disallow javascript, data, vbscript protocols
        $dangerous_protocols = ['javascript:', 'data:', 'vbscript:', 'file:', 'about:'];
        foreach ($dangerous_protocols as $protocol) {
            if (strpos($url, $protocol) === 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Strip all HTML tags (for plain text)
     * 
     * @param string $html
     * @return string
     */
    public static function stripTags($html)
    {
        return strip_tags($html);
    }

    /**
     * Get word count (for validation)
     * 
     * @param string $html
     * @return int
     */
    public static function wordCount($html)
    {
        $text = strip_tags($html);
        return str_word_count($text);
    }

    /**
     * Truncate HTML safely (preserving tags)
     * 
     * @param string $html
     * @param int $limit
     * @param string $ending
     * @return string
     */
    public static function truncate($html, $limit = 100, $ending = '...')
    {
        if (empty($html)) {
            return '';
        }

        $text = strip_tags($html);
        
        if (strlen($text) <= $limit) {
            return $html;
        }

        return substr($text, 0, $limit) . $ending;
    }
}
