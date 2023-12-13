<?php

use App\Repositories\LocationRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class LocationControllerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    private $locationRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->locationRepository = new LocationRepository();
    }

    private $locationData = [
        'name' => 'Güvercin Sokağı, Levent Mahallesi, Beşiktaş, Istanbul, Marmara Region, 34330, Turkey',
        'latitude' => 41.0788495,
        'longitude' => 29.0204988,
        'marker_color'=>"#eeeeee"
    ];



    public function testIndex()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testList()
    {
        $response = $this->get('/location/list');
        $response->assertStatus(200)
            ->assertJson(['status' => true]);
    }

    public function testStore()
    {
        $response = $this->post('/location/create', $this->locationData);
        $response->assertStatus(200)
            ->assertJson(['status' => true]);
    }

    public function testShow()
    {
        $location = $this->locationRepository->create($this->locationData);

        $response = $this->get("/location/{$location->id}");

        $response->assertStatus(200)
            ->assertJson(['status' => true]);
    }

    public function testUpdate()
    {
        $location = $this->locationRepository->create($this->locationData);

        $updatedData = [
            'location_id' => $location->id,
            'name' => 'Gökhaliller Köyü, Seben, Bolu, Black Sea Region, 14752, Turkey',
            'latitude' => 40.399105,
            'longitude' => 31.59174,
            'marker_color'=>"#0000FF"
        ];

        $response = $this->put('/location/update', $updatedData);
        $response->assertStatus(200)
            ->assertJson(['status' => true]);
    }

    public function testDelete()
    {

        $location = $this->locationRepository->create($this->locationData);

        $response = $this->delete('/location/delete', ['id' => $location->id]);
        $response->assertStatus(200)
            ->assertJson(['status' => true]);
    }
}
