<?php

namespace App\Console\Commands;

use App\Actions\SendBulkEmail;
use App\Models\User;
use App\Notifications\ExampleNotification;
use Illuminate\Console\Command;

class SendExampleNotification extends Command
{
    protected $signature = 'app:send-example-notification';

    protected $description = 'Send an example notification to multiple recipients';

    public function handle(SendBulkEmail $sendBulkEmail): void
    {
        // Chunk the users (if we have 2000 users and the chunk size is 500, we call the API 4 times)
        $chunks = User::all()->chunk(500);

        foreach ($chunks as $chunk) {
            $sendBulkEmail->execute(
                new ExampleNotification([
                    'url' => 'https://example.com', // Shared data across all recipients
                ]),
                'Example notification subject',
                $chunk->map(fn($user) => [
                    'email' => $user->email,
                    'data' => [
                        'name' => $user->name
                    ],
                ])->toArray()
            );

            $this->info("Sent notification to {$chunk->count()} users");
        }
    }
}
