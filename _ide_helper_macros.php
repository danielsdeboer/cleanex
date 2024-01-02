<?php

namespace Illuminate\Testing {
	use Application\Common\QA\Support\Html\HtmlAssert;
	use Closure;

	class TestResponse  {
		public function assertHtml(Closure $assertions): TestResponse
		{
			$assertions(HtmlAssert::fromResponse($this));

			return $this;
		}
	}
}
