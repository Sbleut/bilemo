<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Customer;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\Uid\Uuid;

#[AsDecorator('api_platform.doctrine.orm.state.persist_processor')]
class CustomerSetResellerProcessor implements ProcessorInterface
{
    public function __construct(private ProcessorInterface $innerProcessor, private Security $security)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data instanceof Customer && $data->getReseller() === null && $this->security->getUser()) {
            $data->setReseller($this->security->getUser());
            $data->setCreatedAt(new \DateTimeImmutable());
            $data->setUuid(Uuid::v6());
        }
        $this->innerProcessor->process($data, $operation, $uriVariables, $context);
        return $this->innerProcessor->process($data, $operation, $uriVariables, $context);
        
    }
}

