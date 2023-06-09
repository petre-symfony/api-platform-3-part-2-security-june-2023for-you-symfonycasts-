<?php

namespace Functional;

use App\Factory\DragonTreasureFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Json;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;

class DragonTreasureResourceTest extends KernelTestCase {
	use HasBrowser;
	use ResetDatabase;

	public function testGetCollectionOfTreasures(): void {
		DragonTreasureFactory::createMany(5);

		$this->browser()
			->get('/api/treasures')
			->assertJson()
			->assertJsonMatches('"hydra:totalItems"', 5)
			->use(function(Json $json) {
				dump($json->search('keys("hydra:member"[0])'));
			})
		;
	}
}