<?php

use App\Models\Candidate;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->user = User::factory()->general()->create();

    $this->position = Position::factory()->create();
    $this->candidate = Candidate::factory()->for($this->position)->create();
});

test('authorized user can create new candidate', function () {
    dd('test');
    /* actingAs($this->admin)->post(route('positions.candidates.store', $this->position), [
        'name' => fake()->name(),
        'photo' => UploadedFile::fake()->image('candidate.jpg'),
    ])->assertRedirect(route('positions.candidates.index', $this->position)); */
});

/* test('unauthorized user unable to create new candidate', function () {
    actingAs($this->user)->post(route('positions.candidates.store', $this->position), [
        'name' => fake()->name(),
        'photo' => UploadedFile::fake()->image('candidate.jpg'),
    ])->assertRedirect(route('dashboard'));
});

test('authorized user can update candidate', function () {
    actingAs($this->admin)->put(route('positions.candidates.update', [$this->position, $this->candidate]), [
        'name' => fake()->name(),
        'photo' => UploadedFile::fake()->image('candidate2.jpg'),
    ])->assertRedirect(route('positions.index'));
});

test('unauthorized user unable to update the candidate', function () {
    actingAs($this->user)->put(route('positions.candidates.update', [$this->position, $this->candidate]), [
        'name' => fake()->name(),
        'photo' => UploadedFile::fake()->image('candidate.jpg'),
    ])->assertRedirect(route('dashboard'));
});

test('authorized user can destroy position', function () {
    actingAs($this->admin
    )->put(route('positions.candidates.update', [$this->position, $this->candidate]))
    ->assertRedirect(route('positions.index'));
});

test('unauthorized user unable to destroy the position', function () {
    actingAs($this->user)
    ->put(route('positions.candidates.update', [$this->position, $this->candidate]))
    ->assertRedirect(route('dashboard'));
}); */

