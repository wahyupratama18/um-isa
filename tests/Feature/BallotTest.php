<?php

use App\Models\Position;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->user = User::factory()->general()->create();

    $this->position = Position::factory()->create();
});

test('authorized user can create new position', function () {
    actingAs($this->admin)->post(route('positions.store'), [
        'name' => fake()->name(),
    ])->assertRedirect(route('positions.index'));
});

test('unauthorized user unable to create new position', function () {
    actingAs($this->user)->post(route('positions.store'), [
        'name' => fake()->name(),
    ])->assertRedirect(route('dashboard'));
});

test('authorized user can update position', function () {
    actingAs($this->admin)->put(route('positions.update', $this->position), [
        'name' => fake()->name(),
    ])->assertRedirect(route('positions.index'));
});

test('unauthorized user unable to update the position', function () {
    actingAs($this->user)->put(route('positions.update', $this->position), [
        'name' => fake()->name(),
    ])->assertRedirect(route('dashboard'));
});

test('authorized user can destroy position', function () {
    actingAs($this->admin)->delete(route('positions.destroy', $this->position), [
        'name' => fake()->name(),
    ])->assertRedirect(route('positions.index'));
});

test('unauthorized user unable to destroy the position', function () {
    $position = Position::factory()->create();

    actingAs($this->user)->delete(route('positions.destroy', $position), [
        'name' => fake()->name(),
    ])->assertRedirect(route('dashboard'));
});
