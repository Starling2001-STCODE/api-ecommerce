<?php

namespace App\Notifications\Services;

use Aws\Sns\SnsClient;
use Illuminate\Support\Facades\Log;

class SnsService
{
    protected SnsClient $snsClient;
    protected string $topicArn;

    public function __construct()
    {
        $this->snsClient = new SnsClient([
            'region' => config('services.sns.region'),
            'version' => 'latest',
            'credentials' => [
                'key' => config('services.sns.key'),
                'secret' => config('services.sns.secret'),
            ],
        ]);

        $this->topicArn = config('services.sns.topic_arn');
    }

    public function publish(string $message, array $attributes = []): void
    {
        try {
            $this->snsClient->publish([
                'TopicArn' => $this->topicArn,
                'Message' => $message,
                'MessageAttributes' => $this->formatAttributes($attributes),
            ]);

            Log::info('SNS message published successfully.', [
                'message' => $message,
                'attributes' => $attributes,
            ]);
        } catch (\Exception $e) {
            Log::error('Error publishing to SNS.', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function formatAttributes(array $attributes): array
    {
        $formatted = [];

        foreach ($attributes as $key => $value) {
            $formatted[$key] = [
                'DataType' => $value['DataType'] ?? 'String',
                'StringValue' => $value['StringValue'],
            ];
        }

        return $formatted;
    }
}
