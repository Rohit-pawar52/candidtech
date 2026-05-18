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
        $allowed_tags = '<p><strong><em><u><h1><h2><h3><h4><h5><h6><ul><ol><li><blockquote><a><br><i><b><span><font>';

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
        $href = null;
        $color = null;
        $style = null;

        if ($node->hasAttribute('href') && $node->nodeName === 'a') {
            $href = $node->getAttribute('href');
        }

        if ($node->hasAttribute('color') && $node->nodeName === 'font') {
            $color = $node->getAttribute('color');
        }

        if ($node->hasAttribute('style')) {
            $style = static::sanitizeStyle($node->getAttribute('style'));
        }

        while ($node->attributes && $node->attributes->length > 0) {
            $node->removeAttribute($node->attributes->item(0)->name);
        }

        if ($href && static::isSafeUrl($href)) {
            $node->setAttribute('href', $href);
            $node->setAttribute('target', '_blank');
            $node->setAttribute('rel', 'noopener noreferrer');
        }

        if ($color && static::isSafeColor($color)) {
            $node->setAttribute('color', $color);
        }

        if ($style) {
            $node->setAttribute('style', $style);
        }
    }

    /**
     * Sanitize safe CSS style declarations
     *
     * @param string $style
     * @return string|null
     */
    private static function sanitizeStyle($style)
    {
        $allowedProperties = [
            'color',
            'background-color',
            'font-weight',
            'font-style',
            'text-decoration',
            'text-align'
        ];

        $result = [];
        foreach (explode(';', $style) as $declaration) {
            if (!trim($declaration)) {
                continue;
            }

            [$property, $value] = array_map('trim', explode(':', $declaration, 2) + [1 => '']);
            $property = strtolower($property);
            $value = trim($value);

            if (!$property || !$value || !in_array($property, $allowedProperties, true)) {
                continue;
            }

            if (in_array($property, ['color', 'background-color'], true)) {
                if (!static::isSafeColor($value)) {
                    continue;
                }
            }

            if ($property === 'font-weight' && !preg_match('/^(normal|bold|bolder|lighter|[1-9]00)$/i', $value)) {
                continue;
            }

            if ($property === 'font-style' && !in_array(strtolower($value), ['normal', 'italic', 'oblique'], true)) {
                continue;
            }

            if ($property === 'text-decoration' && !in_array(strtolower($value), ['none', 'underline', 'line-through', 'overline'], true)) {
                continue;
            }

            if ($property === 'text-align' && !in_array(strtolower($value), ['left', 'right', 'center', 'justify'], true)) {
                continue;
            }

            $result[] = "$property: $value";
        }

        return $result ? implode('; ', $result) : null;
    }

    /**
     * Check if color value is safe
     *
     * @param string $color
     * @return bool
     */
    private static function isSafeColor($color)
    {
        $color = trim($color);

        return preg_match('/^(#([0-9a-f]{3}|[0-9a-f]{6})|rgba?\(\s*\d+\s*,\s*\d+\s*,\s*\d+(?:\s*,\s*(0|1|0?\.\d+))?\s*\)|[a-z]+)$/i', $color) === 1;
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
