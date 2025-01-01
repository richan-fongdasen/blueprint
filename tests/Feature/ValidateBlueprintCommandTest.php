<?php

it('can validate the blueprint files', function () {
    $path = __DIR__ . '/../../blueprints';
    $this->artisan('blueprint:validate ' . $path)
        ->expectsOutput('The blueprint files are valid.')
        ->assertExitCode(0);
});
