<?php
namespace App\Models;

class User
{
	private ?int $id = null;
  private string $name;
  private string $email;
  private string $password;
  private int $age;
  private ?string $created = '2000-01-01 00:00:00';
	public function __construct(
		?int $id = null,
    string $name,
    string $email,
    string $password,
    int $age,
    ?string $created,
	)	{
		$this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $this->age = $age;
    $this->created = $created;
	}
	/** @return int|null */
	public function getId(): ?int
	{
		return $this->id;
	}
  /** @return string */
  public function getName(): string {
    return $this->name;
  }
  /** @return string */
	public function getEmail(): string {
		return $this->email;
	}
  /** @return string */
	public function getPassword(): string {
		return $this->password;
	}
  /** @return int */
  public function getAge(): int {
    return $this->age;
  }
  /** @return string */
	public function getCreated(): string {
		return $this->created;
	}
}