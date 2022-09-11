<?php

declare(strict_types=1);

namespace Functional\App\Reservation\Application\Controller\Read;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ReservationControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testGetReservations(): void
    {
        $this->client->request('GET', '/v1/reservations');
        $content = $this->content();

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $content);
        $this->assertArrayHasKey('metadata', $content);

        foreach ($content['data'] as $record) {
            $this->assertArrayHasKey('startDate', $record);
            $this->assertIsArray($record['startDate']);
            $this->assertArrayHasKey('endDate', $record);
            $this->assertIsArray($record['endDate']);
            $this->assertArrayHasKey('confirmed', $record);
            $this->assertIsBool($record['confirmed']);
            $this->assertArrayHasKey('holder', $record);
            $this->assertIsArray($record['holder']);
            $this->assertArrayHasKey('room', $record);
            $this->assertIsArray($record['room']);
        }
    }

    public function testGetReservation(): void
    {
        $this->client->request('GET', '/v1/reservations/1');
        $content = $this->content();

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('data', $content);

        $this->assertArrayHasKey('startDate', $content['data']);
        $this->assertIsArray($content['data']['startDate']);
        $this->assertArrayHasKey('endDate', $content['data']);
        $this->assertIsArray($content['data']['endDate']);
        $this->assertArrayHasKey('confirmed', $content['data']);
        $this->assertIsBool($content['data']['confirmed']);
        $this->assertArrayHasKey('holder', $content['data']);
        $this->assertIsArray($content['data']['holder']);
        $this->assertArrayHasKey('room', $content['data']);
        $this->assertIsArray($content['data']['room']);
    }

    private function content(): array {
        return json_decode($this->client->getResponse()->getContent(), true);
    }
}