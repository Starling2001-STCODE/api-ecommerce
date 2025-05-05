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

    /**
     * Publica un mensaje en el Topic configurado.
     *
     * @param string $message
     * @param array $attributes
     * @return void
     */
    public function publish(string $message, array $attributes = []): void
    {
        try {
            $response = $this->snsClient->publish([
                'TopicArn' => $this->topicArn,
                'Message' => $message,
                'MessageAttributes' => $this->formatAttributes($attributes),
            ]);

            Log::info('SNS message published successfully.', [
                'message_id' => $response->get('MessageId'),
                'message' => $message,
                'attributes' => $attributes,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to publish SNS message.', [
                'error' => $e->getMessage(),
                'message' => $message,
                'attributes' => $attributes,
            ]);
            throw $e;
        }
    }

    /**
     * Formatea los atributos para SNS.
     *
     * @param array $attributes
     * @return array
     */
    private function formatAttributes(array $attributes): array
    {
        $formatted = [];

        foreach ($attributes as $key => $value) {
            if (isset($value['DataType']) && isset($value['StringValue'])) {
                $formatted[$key] = [
                    'DataType' => $value['DataType'],
                    'StringValue' => $value['StringValue'],
                ];
            } else {
                // Si solo pasas un valor simple (sin estructura DataType/StringValue)
                $formatted[$key] = [
                    'DataType' => 'String',
                    'StringValue' => (string) $value,
                ];
            }
        }

        return $formatted;
    }
}
