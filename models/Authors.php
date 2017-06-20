<?php
namespace Models;

class Authors extends Model
{
    public function getAuthors()
    {
        try {
            $pdoSt = $this->cn->query(
                'SELECT * FROM library.authors'
            );
            return $pdoSt->fetchAll();
        } catch (\PDOException $exception) {
            return null;
        }
    }

    public function getAuthor($id)
    {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT * FROM authors WHERE authors.id = :id'
            );
            $pdoSt->execute([':id' => $id]);
            return $pdoSt->fetch();
        } catch (\PDOException $exception) {
            return null;
        }
    }

    public function checkBirthDate($date)
    {
        $date = trim($date);
        $date = preg_replace('#/#U', '-', $date);
        if (preg_match('#^[0-9]{4}-[01][0-9]-[0-3][0-9]$#', $date)) {
            return $date;
        } elseif (preg_match('#^[0-9]{4}-[0-3][0-9]-[01][0-9]$#', $date)) {
            return preg_replace('#^([0-9]{4})-([0-3][0-9])-([01][0-9])$#', '$1-$3-$2', $date);
        } elseif (preg_match('#^[0-3][0-9]-[01][0-9]-[0-9]{4}$#', $date)) {
            return preg_replace('#^([0-3][0-9])-([01][0-9])-([0-9]{4})$#', '$3-$2-$1', $date);
        } else {
            return null;
        }
    }

    public function checkPictureURL($url)
    {
        if (preg_match('#(\.jpg|\.jpeg|\.png)$#', $url)) {
            return $url;
        }
        return null;
    }

    public function addAuthor($author)
    {
        try {
            $pdoSt = $this->cn->prepare(
                'INSERT INTO library.authors
                  ( alias_name, birth_date, picture, description ) VALUES
                  ( :alias_name, :birth_date, :picture, :description )'
            );
            $pdoSt->execute([
                ':alias_name' => $author['alias_name'],
                ':birth_date' => $author['birth_date'],
                ':picture' => $author['picture'],
                ':description' => $author['description'],
            ]);
            return true;
        } catch (\PDOException $exception) {
            return false;
        }
    }

    public function findAuthor($term)
    {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT id, alias_name FROM library.authors WHERE alias_name LIKE :term '
            );
            $pdoSt->bindValue(':term', '%' . $term . '%');
            $pdoSt->execute();
            return $pdoSt->fetchAll();
        } catch (\PDOException $exception) {
            return null;
        }
    }
}
