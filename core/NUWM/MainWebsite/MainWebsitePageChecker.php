<?php

	namespace NUWM\MainWebsite;

	use DOMDocument;
	use DOMXPath;
	use Exception;
	use GuzzleHttp\Client;
	use GuzzleHttp\Exception\GuzzleException;

	class MainWebsitePageChecker
		{
			public const STATUS_UNKNOWN = 'unknown';
			public const STATUS_READY = 'ready';
			public const STATUS_MISSING = 'missing';

			public static function Check(MainWebsitePage $page): array
				{
					$result = [
						'status' => self::STATUS_UNKNOWN,
						'http_code' => 0,
						'error' => null,
					];

					$url = trim((string) $page->URL());
					if ($url === '')
						{
							$result['error'] = 'Page URL is empty.';
							unset($result['http_code']);
							return $result;
						}

					$client = new Client([
						'timeout' => 20,
						'connect_timeout' => 8,
						'headers' => [
							'User-Agent' => 'NUWM MainWebsitePageChecker/1.0 (+https://nuwm.edu.ua)',
							'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
						],
						'allow_redirects' => [
							'max' => 5,
							'strict' => false,
						],
						'verify' => true,
					]);

					try
						{
							$response = $client->request('GET', $url);
							$result['http_code'] = $response->getStatusCode();
							$body = (string) $response->getBody();

							if ($result['http_code'] >= 200 && $result['http_code'] < 400)
								{
									$result['status'] = self::hasContent($body) ? self::STATUS_READY : self::STATUS_MISSING;
								}
							else
								{
									$result['status'] = self::STATUS_MISSING;
									$result['error'] = 'Unexpected HTTP status code '.$result['http_code'];
								}
						}
					catch (GuzzleException $e)
						{
							$result['status'] = self::STATUS_MISSING;
							$result['error'] = $e->getMessage();
						}

					return $result;
				}

			public static function CheckAndUpdate(MainWebsitePage $page): array
				{
					$result = self::Check($page);

					if ($result['status'] === self::STATUS_READY)
						$page->SetReady(1);
					elseif ($result['status'] === self::STATUS_MISSING)
						$page->SetReady(0);

					if ($page->NeedToCheck())
						$page->SetNeedToCheck(0);

					return $result;
				}

			protected static function hasContent(string $html): bool
				{
					if (trim($html) === '')
						return false;

					$dom = new DOMDocument();
					libxml_use_internal_errors(true);
					try
						{
							$dom->loadHTML($html);
						}
					catch (Exception $e)
						{
							return false;
						}
					finally
						{
							libxml_clear_errors();
							libxml_use_internal_errors(false);
						}

					$xpath = new DOMXPath($dom);

					$containers = $xpath->query(
						"//div[contains(concat(' ', normalize-space(@class), ' '), ' blog_area ')]" .
						"//div[contains(concat(' ', normalize-space(@class), ' '), ' container ')]" .
						"//div[contains(concat(' ', normalize-space(@class), ' '), ' col-lg-8 ')]"
					);

					if ($containers === false || $containers->length === 0)
						return false;

					foreach ($containers as $container)
						{
							$cloned = $container->cloneNode(true);
							self::removeHeadings($cloned);

							if (self::containsMeaningfulContent($cloned))
								return true;
						}

					return false;
				}

			protected static function removeHeadings($node): void
				{
					if (!$node || !$node->hasChildNodes())
						return;

					for ($i = $node->childNodes->length - 1; $i >= 0; $i--)
						{
							$child = $node->childNodes->item($i);
							if ($child->nodeType === XML_ELEMENT_NODE && strtolower($child->nodeName) === 'h3')
								{
									$class = $child->attributes->getNamedItem('class');
									if ($class !== null && strpos(' '.$class->nodeValue.' ', ' mb-3 ') !== false)
										{
											$node->removeChild($child);
											continue;
										}
								}

							if ($child->hasChildNodes())
								self::removeHeadings($child);
						}
				}

			protected static function containsMeaningfulContent($node): bool
				{
					if (!$node || !$node->hasChildNodes())
						return false;

					foreach ($node->childNodes as $child)
						{
							if ($child->nodeType === XML_TEXT_NODE)
								{
									if (trim($child->nodeValue) !== '')
										return true;
								}
							elseif ($child->nodeType === XML_ELEMENT_NODE)
								{
									$tag = strtolower($child->nodeName);
									if (in_array($tag, ['br', 'hr', 'img']))
										continue;

									if (self::containsMeaningfulContent($child))
										return true;
								}
						}

					return false;
				}
		}


