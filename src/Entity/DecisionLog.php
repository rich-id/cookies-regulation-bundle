<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cookies_regulation_decision_log')]
class DecisionLog
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected ?int $id;

    #[ORM\Column(type: 'string', length: 50, nullable: false, name: 'uuid')]
    protected string $uuid;

    #[ORM\Column(type: 'datetime', nullable: false, name: 'date')]
    protected \DateTime $date;

    #[ORM\Column(type: 'string', length: 50, nullable: false, name: 'service_name')]
    protected string $serviceName;

    #[ORM\Column(type: 'boolean', nullable: false, name: 'is_enabled')]
    protected bool $isEnabled;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $serviceName): self
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }
}
