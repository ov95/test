<?php

namespace Models;

use Engine\Database\OPdo;


/**
 * Comment Model
 */
class Comment
{
    /* @var OPdo */
    protected $db;

    public function __construct(OPdo $db)
    {
        $this->db = $db;
    }


    // onclick="togleComment(this.id)"

    public function find($id)
    {
        $this->data = $this->db->run("SELECT * FROM users WHERE id = ?", [$id])->fetch();
    }

    public function create($comment)
    {
        try {
            $stmt = 'INSERT INTO comments(name, email, text, approved) VALUES(:name, :email, :text, 0)';
            $stmt = $this->db->prepare($stmt);
            $stmt->bindParam(':name', $comment->name);
            $stmt->bindParam(':email', $comment->email);
            $stmt->bindParam(':text', $comment->text);

            $stmt->execute();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function get($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM comments WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(OPdo::FETCH_OBJ);
    }

    public function getAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM comments ORDER BY id DESC');
        $stmt->execute();
        return $stmt->fetchAll(OPdo::FETCH_OBJ);
    }

    public function togle($id)
    {
        try {
            $status = $this->get($id);
            $approved =  ($status->approved == STATUS_ACTIVE) ? STATUS_INACTIVE : STATUS_ACTIVE;

            $sql = "UPDATE comments SET comments.approved=? WHERE comments.id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$approved, $id]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    public function getAllApproved()
    {
        $approved = STATUS_ACTIVE;
        $stmt = $this->db->prepare('SELECT * FROM comments WHERE approved = :status ORDER BY id DESC');
        $stmt->bindParam(':status', $approved);
        $stmt->execute();
        return $stmt->fetchAll(OPdo::FETCH_OBJ);
    }
}
