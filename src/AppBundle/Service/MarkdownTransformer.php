<?php

namespace AppBundle\Service;

use Doctrine\Common\Cache\Cache;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class MarkdownTransformer
{
    protected $markdownParser;
    protected $cache;

    public function __construct(MarkdownParserInterface $markdownParser, Cache $cache)
    {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
    }

    public function parse(string $markdown)
    {
        $key = md5($markdown);
        if ($this->cache->contains($key)) {
            return $this->cache->fetch($key);
        }

        $parsed = $this->markdownParser->transformMarkdown($markdown);
        $this->cache->save($key, $parsed);

        return $parsed;
    }
}
