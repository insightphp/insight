<?php


namespace Insight\Forms\Contracts;


use Insight\Forms\Validation\PendingValidation;
use Insight\Forms\Validation\PreviousControls;

interface ConfiguresPendingValidation
{
    /**
     * Configures pending validation.
     *
     * @param \Insight\Forms\Validation\PendingValidation $pendingValidation
     * @param string $formAttributeName
     * @param \Insight\Forms\Validation\PreviousControls $previousControls
     * @return void
     */
    public function configurePendingValidation(
        PendingValidation $pendingValidation,
        string $formAttributeName,
        PreviousControls $previousControls
    ): void;
}
