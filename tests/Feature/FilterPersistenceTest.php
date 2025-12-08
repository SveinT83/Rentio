<?php

namespace Tests\Feature;

use Tests\TestCase;

class FilterPersistenceTest extends TestCase
{
    public function test_query_string_configuration(): void
    {
        $component = new \App\Livewire\Guests\Ads\AdsList;

        // Access the protected queryString property using reflection
        $reflection = new \ReflectionClass($component);
        $queryStringProperty = $reflection->getProperty('queryString');
        $queryStringProperty->setAccessible(true);
        $queryString = $queryStringProperty->getValue($component);

        $this->assertArrayHasKey('categoryId', $queryString);
        $this->assertArrayHasKey('subcategoryId', $queryString);
        $this->assertArrayHasKey('location', $queryString);
        $this->assertArrayHasKey('municipality', $queryString);

        // Verify except values are correct
        $this->assertEquals(['except' => null], $queryString['categoryId']);
        $this->assertEquals(['except' => null], $queryString['subcategoryId']);
        $this->assertEquals(['except' => null], $queryString['location']);
        $this->assertEquals(['except' => null], $queryString['municipality']);
    }
}
