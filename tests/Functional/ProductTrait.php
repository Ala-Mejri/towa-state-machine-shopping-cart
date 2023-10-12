<?php

namespace App\Tests\Functional;

use Symfony\Component\BrowserKit\AbstractBrowser;

trait ProductTrait
{
    private function addRandomProductToCart(AbstractBrowser $client): array
    {
        $product = $this->getRandomProduct($client);
        $crawler = $client->request('GET', $product['url']);
        $form = $crawler->filter('form')->form();
        $client->submit($form);

        return $product;
    }

    private function getRandomProduct(AbstractBrowser $client): array
    {
        $crawler = $client->request('GET', '/products');
        $productNode = $crawler->filter(self::PRODUCT_ITEM_CSS_SELECTOR)->eq(rand(0, 9));
        $productName = $productNode->filter('[itemprop="name"]')->getNode(0)->textContent;
        $productPrice = $productNode->filter('[itemprop="price"]')->getNode(0)->textContent;
        $productPrice = (float)str_replace('€', '', $productPrice);
        $productLink = $productNode->filter('[itemprop="url"]')->link();

        return [
            'name' => $productName,
            'price' => $productPrice,
            'url' => $productLink->getUri(),
        ];
    }
}