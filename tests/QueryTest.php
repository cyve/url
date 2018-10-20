<?php

namespace Cyve\Url\Test;

use Cyve\Url\Query;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
	public function testQuery()
	{
		$query = new Query('lorem=ipsum&sit=dolor');

        $this->assertEquals('lorem=ipsum&sit=dolor', $query);
		
		$this->assertEquals('lorem=ipsum&sit=dolor', $query);
		$this->assertEquals('ipsum', $query->get('lorem'));
		$this->assertEquals('dolor', $query->get('sit'));
		$this->assertEquals(null, $query->get('amet'));
		$this->assertEquals(['lorem' => 'ipsum', 'sit' => 'dolor'], $query->all());
		$this->assertEquals('foo', $query->get('amet', 'foo'));
		$this->assertEquals('foo', $query->set('amet', 'foo')->get('amet'));
	}
}
