<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessInternalWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $eventType;
    public array $payload;
    public $systemUserId;

    /**
     * Create a new job instance.
     */
    public function __construct($eventType, array $payload, $systemUserId = null)
    {
        $this->eventType = $eventType;
        $this->payload = $payload;
        $this->systemUserId = $systemUserId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Na produkcji tu logika dla webhooka
        \Log::info("ProcessInternalWebhookJob run", [
            'event_type' => $this->eventType,
            'payload' => $this->payload,
            'system_user_id' => $this->systemUserId,
        ]);
    }
}
