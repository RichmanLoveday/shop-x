<?php

namespace App\Events;

use App\Models\Admin;
use App\Models\ProductFile;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DigitalProductFileStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public ProductFile $file,
        public User|Admin $user,
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
                "digital-files.user.{$this->user->id}"
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'digital-file.status.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->file->id,
            'status' => $this->file->status->value,
        ];
    }
}
