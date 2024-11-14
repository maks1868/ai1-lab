<?php

namespace App\Model;

use App\Service\Config;

class Boat
{
    private ?int $id = null;
    private ?string $name = null;
    private ?float $length = null;
    private ?float $width = null;
    private ?float $height = null;
    private ?int $number_of_sails = null;

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function getLength(): ?float { return $this->length; }
    public function getWidth(): ?float { return $this->width; }
    public function getHeight(): ?float { return $this->height; }
    public function getNumberOfSails(): ?int { return $this->number_of_sails; }

    public function setId(?int $id): Boat { $this->id = $id; return $this; }
    public function setName(?string $name): Boat { $this->name = $name; return $this; }
    public function setLength(?float $length): Boat { $this->length = $length; return $this; }
    public function setWidth(?float $width): Boat { $this->width = $width; return $this; }
    public function setHeight(?float $height): Boat { $this->height = $height; return $this; }
    public function setNumberOfSails(?int $number_of_sails): Boat { $this->number_of_sails = $number_of_sails; return $this; }

    public static function fromArray($array): Boat {
        $boat = new self();
        $boat->fill($array);
        return $boat;
    }

    public function fill($array): Boat {
        if (isset($array['id']) && ! $this->getId()) $this->setId($array['id']);
        if (isset($array['name'])) $this->setName($array['name']);
        if (isset($array['length'])) $this->setLength($array['length']);
        if (isset($array['width'])) $this->setWidth($array['width']);
        if (isset($array['height'])) $this->setHeight($array['height']);
        if (isset($array['number_of_sails'])) $this->setNumberOfSails($array['number_of_sails']);
        return $this;
    }

    public static function findAll(): array {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM boats';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $boats = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $boatArray) {
            $boats[] = self::fromArray($boatArray);
        }
        return $boats;
    }

    public static function find($id): ?Boat {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM boats WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $boatArray = $statement->fetch(\PDO::FETCH_ASSOC);
        return $boatArray ? self::fromArray($boatArray) : null;
    }

    public function save(): void {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (!$this->getId()) {
            $sql = "INSERT INTO boats (name, length, width, height, number_of_sails) VALUES (:name, :length, :width, :height, :number_of_sails)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'name' => $this->getName(),
                'length' => $this->getLength(),
                'width' => $this->getWidth(),
                'height' => $this->getHeight(),
                'number_of_sails' => $this->getNumberOfSails(),
            ]);
            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE boats SET name = :name, length = :length, width = :width, height = :height, number_of_sails = :number_of_sails WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'name' => $this->getName(),
                'length' => $this->getLength(),
                'width' => $this->getWidth(),
                'height' => $this->getHeight(),
                'number_of_sails' => $this->getNumberOfSails(),
                'id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM boats WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $this->getId()]);

        $this->setId(null);
        $this->setName(null);
        $this->setLength(null);
        $this->setWidth(null);
        $this->setHeight(null);
        $this->setNumberOfSails(null);
    }
}
