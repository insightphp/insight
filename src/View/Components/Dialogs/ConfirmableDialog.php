<?php


namespace Insight\View\Components\Dialogs;


use Insight\Elements\View\Components\Link;
use Insight\View\Components\Heroicon;

class ConfirmableDialog extends Dialog
{
    /**
     * The title of the dialog.
     *
     * @var string
     */
    public string $title;

    /**
     * The message of the dialog.
     *
     * @var string|null
     */
    public ?string $message = null;

    /**
     * The icon of the dialog.
     *
     * @var \Insight\View\Components\Heroicon|null
     */
    public ?Heroicon $icon = null;

    /**
     * Cancel button label.
     *
     * @var string
     */
    public string $cancelLabel = 'Cancel';

    /**
     * Confirm button label.
     *
     * @var string
     */
    public string $confirmLabel = 'Confirm';

    /**
     * Style of the dialog.
     *
     * @var string
     */
    public string $look = 'primary';

    /**
     * Custom link for confirmation.
     *
     * @var \Insight\Elements\View\Components\Link|null
     */
    public ?Link $confirmUsing = null;

    /**
     * Set confirm label.
     *
     * @param string $label
     * @return $this
     */
    public function confirmLabel(string $label): static
    {
        $this->confirmLabel = $label;

        return $this;
    }

    /**
     * Set cancel label.
     *
     * @param string $label
     * @return $this
     */
    public function cancelLabel(string $label): static
    {
        $this->cancelLabel = $label;

        return $this;
    }

    /**
     * Set primary look of the dialog.
     *
     * @return $this
     */
    public function primary(): static
    {
        $this->look = 'primary';

        return $this;
    }

    /**
     * Set danger look of the dialog.
     *
     * @return $this
     */
    public function danger(): static
    {
        $this->look = 'danger';

        return $this;
    }

    /**
     * Set the custom link for confirming the dialog.
     *
     * @param \Insight\Elements\View\Components\Link $link
     * @return $this
     */
    public function confirmUsing(Link $link): static
    {
        $this->confirmUsing = $link;

        return $this;
    }
}
