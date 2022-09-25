<?php

uses(\Insight\Inertia\Tests\TestCase::class)->in(__DIR__);

function components(bool $discover = false): \Insight\Inertia\ComponentManager
{
    $components = new \Insight\Inertia\ComponentManager();

    if ($discover) {
        $components->addComponentsFromPath(__DIR__ . '/Fixtures/Components', 'surface');
    }

    return $components;
}
