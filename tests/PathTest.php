<?php

namespace Cyve\Url\Test;

use Cyve\Url\Path;
use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    public function testPath()
    {
        $path = new Path('/foo/bar');

        $this->assertEquals('/foo/bar', (string) $path);

        $this->assertEquals('foo', $path[0]);
        $this->assertEquals('bar', $path[1]);
        unset($path[1]);
        $path[] = 'pouet';
        $this->assertEquals('/foo/pouet', (string) $path);
        $this->assertCount(2, $path);
    }

    public function testEmptyPath()
    {
        $path = new Path();

        $this->assertEquals('', (string) $path);
    }
}
