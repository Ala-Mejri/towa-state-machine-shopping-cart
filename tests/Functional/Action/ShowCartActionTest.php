<?php


namespace App\Tests\Functional\Action;

use App\Tests\Functional\CartAssertionsTrait;
use App\Tests\Functional\ProductTrait;
use App\Tests\UserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers ShowCartAction
 */
class ShowCartActionTest extends WebTestCase
{
    use CartAssertionsTrait;
    use ProductTrait;
    use UserTrait;

    const PRODUCT_ITEM_CSS_SELECTOR = '[itemtype="https://schema.org/Product"]';

    public function testCartIsEmpty(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart');

        $this->assertResponseIsSuccessful();
        $this->assertCartIsEmpty();
    }

    public function testAddProductToCart(): void
    {
        $client = static::createClient();
        $client->loginUser($this->getUser());

        $product = $this->addRandomProductToCart($client);
        $crawler = $client->request('GET', '/cart');

        $this->assertResponseIsSuccessful();
        $this->assertCartItemsCountEquals($crawler, 1);
        $this->assertCartContainsProductWithQuantity($crawler, $product['name'], 1);
        $this->assertCartTotalEquals($crawler, $product['price']);
    }

    public function testAddProductTwiceToCart(): void
    {
        $client = static::createClient();
        $client->loginUser($this->getUser());

        $product = $this->getRandomProduct($client);
        $crawler = $client->request('GET', $product['url']);

        for ($i = 0; $i < 2; $i++) {
            $form = $crawler->filter('form')->form();
            $client->submit($form);
            $crawler = $client->followRedirect();
        }

        // Go to the cart page
        $crawler = $client->request('GET', '/cart');

        $this->assertResponseIsSuccessful();
        $this->assertCartItemsCountEquals($crawler, 1);
        $this->assertCartContainsProductWithQuantity($crawler, $product['name'], 2);
        $this->assertCartTotalEquals($crawler, $product['price'] * 2);
    }

    public function testRemoveProductFromCart(): void
    {
        $client = static::createClient();
        $client->loginUser($this->getUser());

        $product = $this->addRandomProductToCart($client);

        // Go to the cart page
        $client->request('GET', '/cart');

        // Removes the product from the cart
        $client->submitForm('Remove');
        $crawler = $client->followRedirect();

        $this->assertCartNotContainsProduct($crawler, $product['name']);
    }

    public function testUpdateProductQuantity(): void
    {
        $client = static::createClient();
        $client->loginUser($this->getUser());

        $product = $this->addRandomProductToCart($client);

        // Go to the cart page
        $crawler = $client->request('GET', '/cart');

        // Updates the quantity
        $cartForm = $crawler->filter('form')->form([
            'cart[items][0][quantity]' => 4,
        ]);
        $client->submit($cartForm);
        $crawler = $client->followRedirect();

        $this->assertCartTotalEquals($crawler, $product['price'] * 4);
        $this->assertCartContainsProductWithQuantity($crawler, $product['name'], 4);
    }

    public function testClearCart(): void
    {
        $client = static::createClient();
        $client->loginUser($this->getUser());

        $this->addRandomProductToCart($client);

        // Go to the cart page
        $client->request('GET', '/cart');

        // Clears the cart
        $client->submitForm('Clear');
        $client->followRedirect();

        $this->assertCartIsEmpty();
    }
}
