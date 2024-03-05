<?php

class Video
{
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function get_video($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM videos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function get_all_videos()
    {
        $stmt = $this->db->query("SELECT * FROM videos ORDER BY id ASC;");
        return $stmt->fetchAll();
    }

    public function create_video($data)
    {

        $link = $data["link"];
        $title = $data["title"];
        $description = $data["description"];


        $stmt = $this->db->prepare("INSERT INTO videos (video_link, title, description) VALUES (:video_link, :title, :description)");
        $stmt->bindParam(':video_link', $link);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam('description', $description);
        $stmt->execute();

        return true;

    }

    public function edit_video($data)
    {
        $id = $data["id"];
        $link = $data["link"];
        $title = $data["title"];
        $description = $data["description"];

        $stmt = $this->db->prepare("UPDATE videos SET video_link = :video_link, title = :title, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':video_link', $link);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->execute();

        return true;
    }


    public function delete_video($id)
    {

        $stmt = $this->db->prepare("DELETE FROM videos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    }




}
