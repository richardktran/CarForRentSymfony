<?php

namespace App\Command;

use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

#[AsCommand(name: 'app:producer')]
class ProducerCommand extends Command
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = uniqid();
        $sqsUrl = $this->params->get('sqsUrl');
        $params = [
            'MessageBody' => "Create id " . $id,
            'QueueUrl' => $sqsUrl
        ];
        $output->writeln([
            'Send message success ' . $id,
            '============',
        ]);
        try {
            $this->sqsClient->sendMessage($params);
        } catch (AwsException $e) {
            error_log($e->getMessage());
        }
        return Command::SUCCESS;
    }
}
