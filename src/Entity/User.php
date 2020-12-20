<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\OneToOne(targetEntity=Account::class, mappedBy="UserId", cascade={"persist", "remove"})
     */
    private $account;

    /**
     * @ORM\OneToMany(targetEntity=Account::class, mappedBy="user")
     */
    private $accounts;

    /**
     * @ORM\OneToMany(targetEntity=Target::class, mappedBy="user")
     */
    private $targets;

    /**
     * @ORM\OneToMany(targetEntity=Target::class, mappedBy="UserId")
     */
    private $targets2;

    /**
     * @ORM\OneToOne(targetEntity=Transactions::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $transactions;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
        $this->targets = new ArrayCollection();
        $this->targets2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        // set the owning side of the relation if necessary
        if ($account->getUserId() !== $this) {
            $account->setUserId($this);
        }

        $this->account = $account;

        return $this;
    }

    /**
     * @return Collection|Account[]
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(Account $account): self
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts[] = $account;
            $account->setUser($this);
        }

        return $this;
    }

    public function removeAccount(Account $account): self
    {
        if ($this->accounts->removeElement($account)) {
            // set the owning side to null (unless already changed)
            if ($account->getUser() === $this) {
                $account->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Target[]
     */
    public function getTargets(): Collection
    {
        return $this->targets;
    }

    public function addTarget(Target $target): self
    {
        if (!$this->targets->contains($target)) {
            $this->targets[] = $target;
            $target->setUser($this);
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        if ($this->targets->removeElement($target)) {
            // set the owning side to null (unless already changed)
            if ($target->getUser() === $this) {
                $target->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Target[]
     */
    public function getTargets2(): Collection
    {
        return $this->targets2;
    }

    public function addTargets2(Target $targets2): self
    {
        if (!$this->targets2->contains($targets2)) {
            $this->targets2[] = $targets2;
            $targets2->setUserId($this);
        }

        return $this;
    }

    public function removeTargets2(Target $targets2): self
    {
        if ($this->targets2->removeElement($targets2)) {
            // set the owning side to null (unless already changed)
            if ($targets2->getUserId() === $this) {
                $targets2->setUserId(null);
            }
        }

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
            $this->transactions->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($transactions !== null && $transactions->getUser() !== $this) {
            $transactions->setUser($this);
        }

        $this->transactions = $transactions;

        return $this;
    }
}
