<?php

namespace App\Jobs\Kafka;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class SendTopic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $topic,
        protected Message $message
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Kafka::publishOn($this->topic)
            ->withMessage($this->message)
            ->send();
    }
}
