<?php

declare(strict_types=1);

namespace Functional\App\Reservation\Application\Controller\Read;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ReservationHolderControllerTest extends WebTestCase
{

    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testGetReservationHolders(): void
    {
        $this->client->request('GET', '/v1/reservations/holders');
        $content = $this->content();

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $content);

        foreach ($content['data'] as $record) {
            $this->assertArrayHasKey('firstName', $record);
            $this->assertIsString($record['firstName']);
            $this->assertArrayHasKey('lastName', $record);
            $this->assertIsString($record['lastName']);
            $this->assertArrayHasKey('phoneNumber', $record);
            $this->assertIsString($record['phoneNumber']);
            $this->assertArrayHasKey('email', $record);
            $this->assertIsString($record['email']);
        }
    }


    private function content(): array {
        return json_decode($this->client->getResponse()->getContent(), true);
    }
}