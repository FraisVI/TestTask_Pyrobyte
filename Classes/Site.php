<?php

namespace Classes;

class Site
{
 public $loc;
 public $lastmod;
 public $priority;
 public $changefreq;

    public function __construct($loc, $lastmod, $priority, $changefreq)
    {
        $this->loc = $loc;
        $this->lastmod = $lastmod;
        $this->priority = $priority;
        $this->changefreq = $changefreq;
 }
}