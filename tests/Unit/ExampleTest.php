<?php
use Illuminate\Foundation\Testing\RefreshDatabase;

it('returns a successful response from API root', function () {
    $response = $this->getJson('/api');

    $response->assertStatus(200);
});