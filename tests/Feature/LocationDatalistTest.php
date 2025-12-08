<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocationDatalistTest extends TestCase
{
    public function test_location_data_is_loaded_from_database(): void
    {
        // Just test that the component can be instantiated and includes location data
        $component = new \App\Livewire\Guests\Ads\FilterLists;
        $data = $component->render()->getData();

        $this->assertArrayHasKey('locations', $data);
        $this->assertNotEmpty($data['locations']);

        // Check that we have some common Norwegian locations
        $locations = $data['locations']->toArray();
        $this->assertContains('OSLO', $locations);
        $this->assertContains('BERGEN', $locations);
        $this->assertContains('TRONDHEIM', $locations);
        $this->assertContains('STAVANGER', $locations);
    }
}
