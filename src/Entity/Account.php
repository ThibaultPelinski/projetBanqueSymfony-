<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $IBAN;

    /**
     * @ORM\Column(type="float")
     */
    private $balance;

    // /**
    //  * @ORM\Column(type="array")
    //  */
    // // private $credits = [];

    // /**
    //  * @ORM\Column(type="array", nullable=true)
    //  */
    // // private $debits = [];

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="account")
     * @ORM\JoinColumn(nullable=true)
     */
    private $UserId;

    /**
     * @ORM\OneToOne(targetEntity=Transactions::class, mappedBy="account", cascade={"persist", "remove"})
     */
    private $transactions;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIBAN(): ?string
    {
        return $this->IBAN;
    }

    public function setIBAN(string $IBAN): self
    {
        $this->IBAN = $IBAN;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    // public function getCredits(): ?array
    // {
    //     return $this->credits;
    // }

    // public function setCredits(array $credits): self
    // {
    //     $this->credits = $credits;

    //     return $this;
    // }

    // public function getDebits(): ?array
    // {
    //     return $this->debits;
    // }

    // public function setDebits(?array $debits): self
    // {
    //     $this->debits = $debits;

    //     return $this;
    // }

    public function getUserId(): ?User
    {
        return $this->UserId;
    }

    public function setUserId(User $UserId): self
    {
        $this->UserId = $UserId;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTransactions(): ?Transactions
    {
        return $this->transactions;
    }

    public function setTransactions(?Transactions $transactions): self
    {
        // unset the owning side of the relation if necessary
        if ($transactions === null && $this->transactions !== null) {
            $this->transactions->setAccount(null);
        }

        // set the owning side of the relation if necessary
        if ($transactions !== null && $transactions->getAccount() !== $this) {
            $transactions->setAccount($this);
        }

        $this->transactions = $transactions;

        return $this;
    }
}
