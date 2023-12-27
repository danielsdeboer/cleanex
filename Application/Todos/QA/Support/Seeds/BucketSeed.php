<?php

namespace Application\Todos\QA\Support\Seeds;

use Application\Common\IO\Config\ConnectionResolverInterface;
use Application\Common\IO\Config\TableNameEnum;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Support\Str;

class BucketSeed
{
	private int $count;

	public function __construct(
		private readonly ConnectionResolverInterface $resolver,
		private readonly Generator $faker,
	)
	{
		$this->count = 1;
	}

	public function count(int $count): self
	{
		$this->count = $count;

		return $this;
	}

	public function insert(): array
	{
		$inserted = [];

		for ($i = 0; $i < $this->count; $i++) {
			$record = $this->definition();

			$this->resolver
				->getBuilder(TableNameEnum::Buckets)
				->insert($record);

			$inserted[] = $record;
		}

		return $inserted;
	}

	private function definition(): array
	{
		return [
			'uuid' => Str::orderedUuid(),
			'name' => $this->faker->sentence(3),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		];
	}
}
