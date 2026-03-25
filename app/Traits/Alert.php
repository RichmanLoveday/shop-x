<?php

namespace App\Traits;

use function Flasher\Notyf\Prime\notyf;

trait Alert
{
    public function updated(string $message)
    {
        notyf()->success($message ?? 'Updated successfully');
    }

    public function created(string $message)
    {
        notyf()->success($message ?? 'Created successfully');
    }

    public function deleted(string $message)
    {
        notyf()->success($message ?? 'Deleted successfully');
    }

    public function failed(string $message)
    {
        notyf()->error($message ?? 'An error occurred');
    }
}
