<?php

namespace App\Command;

use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

#[AsCommand(name: 'app:consumer')]
class ConsumerCommand extends Command
{
    private SqsClient $sqsClient;
    private ContainerBagInterface $params;

    public function __construct(SqsClient $sqsClient, ContainerBagInterface $params, string $name = null)
    {
        parent::__construct($name);
        $this->sqsClient = $sqsClient;
        $this->params = $params;
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sqsUrl = $this->params->get('sqsUrl');
        try {
            $result = $this->sqsClient->receiveMessage(array(
                'AttributeNames' => ['SentTimestamp'],
                'MaxNumberOfMessages' => 1,
                'MessageAttributeNames' => ['All'],
                'QueueUrl' => $sqsUrl,
                'WaitTimeSeconds' => 0,
            ));
            if (!empty($result->get('Messages'))) {
                $output->writeln($result->get('Messages')[0]['Body']);
                $result = $this->sqsClient->deleteMessage([
                    'QueueUrl' => $sqsUrl,
                    'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle']
                ]);
            } else {
                $output->writeln('No messages in queue');
            }
        } catch (AwsException $e) {
            error_log($e->getMessage());
        }
        $output->writeln([
            'Received message',
            '============',
        ]);
        return Command::SUCCESS;
    }
}
