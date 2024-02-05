<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\CustomerRepository;
use App\Validator\UniqueEmail;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\UuidV6;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            security:  'is_granted("ROLE_USER") and object.getReseller() == user',
            securityMessage: 'Not Found'
        ),
        new GetCollection(
            security:  'is_granted("ROLE_USER")',
            securityMessage: 'Not Found'
        ),
        new Post(
        ),
        new Delete(
            security:  'is_granted("ROLE_USER") and object.getReseller() == user',
            securityMessage: 'Not Found'
        ),
    ],
    normalizationContext: ['groups' => ['customer:read']],
    denormalizationContext: ['groups' => [ "customer:write"]]
)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['customer:read', 'customer:write'])]
    #[Assert\NotBlank(message:"This value should not be blank.")]
    #[Assert\Regex('/^[a-zA-ZÀ-ÿ[:blank:]-]{1,}$/')]
    #[Assert\Length(max:255, maxMessage:"Your Lastname can't be that long")]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['customer:read', 'customer:write'])]
    #[Assert\NotBlank(message:"This value should not be blank.")]
    #[Assert\Length(max:255, maxMessage:"Your Firstname can't be that long")]
    #[Assert\Regex('/^[a-zA-ZÀ-ÿ]{1,}$/')]
    private ?string $firstName = null;

    #[ORM\Column]
    #[Groups('customer:read')]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(length: 255)]
    #[Groups(['customer:read', 'customer:write'])]   
    #[Assert\NotBlank(message:"This value should not be blank.")] 
    #[Assert\Length(max:255, maxMessage:"Your Address can't be that long")]
    private ?string $facturationAddress = null;

    #[ORM\Column(length: 255)]
    #[Groups(['customer:read', 'customer:write'])]
    #[Assert\NotBlank(message:"This value should not be blank.")]
    #[Assert\Email(message:"This must be a valid email address")]
    #[Assert\Length(max:255, maxMessage:"Your Email can't be that long")]
    #[UniqueEmail]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'customers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['customer:read'])]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private ?Reseller $reseller = null;

    #[ORM\Column(type: Types::GUID)]
    #[ApiProperty(identifier: true)]
    private ?string $uuid;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->uuid =  new UuidV6();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFacturationAddress(): ?string
    {
        return $this->facturationAddress;
    }

    public function setFacturationAddress(string $facturationAddress): static
    {
        $this->facturationAddress = $facturationAddress;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getReseller(): ?Reseller
    {
        return $this->reseller;
    }

    public function setReseller(?Reseller $reseller): static
    {
        $this->reseller = $reseller;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }
}
