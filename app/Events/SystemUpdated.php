<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $entity,
        public string $action,
        public int|string|null $id = null,
    ) {
    }

    public function broadcastOn(): array
    {
        return [new Channel('system-updates')];
    }

    public function broadcastAs(): string
    {
        return 'system.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'entity' => $this->entity,
            'action' => $this->action,
            'id' => $this->id,
            'at' => now()->toIso8601String(),
        ];
    }
}

