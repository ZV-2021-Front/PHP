<?php

namespace App\Entity;

use App\Repository\RussianAliasesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RussianAliasesRepository::class)
 */
class RussianAliases
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
    private $field;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $russian_aliases;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $data_base;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $table_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getRussianAliases(): ?string
    {
        return $this->russian_aliases;
    }

    public function setRussianAliases(string $russian_aliases): self
    {
        $this->russian_aliases = $russian_aliases;

        return $this;
    }

    public function getDataBase(): ?string
    {
        return $this->data_base;
    }

    public function setDataBase(string $data_base): self
    {
        $this->data_base = $data_base;

        return $this;
    }

    public function getTableName(): ?string
    {
        return $this->table_name;
    }

    public function setTableName(string $table_name): self
    {
        $this->table_name = $table_name;

        return $this;
    }
}
