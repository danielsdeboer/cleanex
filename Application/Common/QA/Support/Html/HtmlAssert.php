<?php

namespace Application\Common\QA\Support\Html;

use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert;
use RuntimeException;
use Symfony\Component\DomCrawler\Crawler;

class HtmlAssert extends Assert
{
	private readonly Crawler $crawler;

	public function __construct(string $html)
	{
		$this->crawler = new Crawler($html);
	}

	public static function fromResponse(Response|TestResponse $response): self
	{
		$content = $response->getContent();

		if ($content === false) {
			throw new RuntimeException('Response content is false');
		}

		return new self($content);
	}

	public function hasAttributeValue(
		string $path,
		string $attributeName,
		string $attributeValue,
	): void {
		$node = $this->crawler->filter($path);

		if ($node->count() === 0) {
			throw new RuntimeException(
				sprintf('Node not found for path: %s', $path),
			);
		}

		if ($node->count() > 1) {
			throw new RuntimeException(
				sprintf('Multiple nodes found for path: %s', $path),
			);
		}

		$this->assertSame($attributeValue, $node->attr($attributeName));
	}
}
