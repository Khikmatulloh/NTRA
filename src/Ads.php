<?php

declare(strict_types=1);

namespace App;

use PDO;

class Ads
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function createAds(
        string $title,
        string $description,
        int    $user_id,
        int    $status_id,
        int    $branch_id,
        string $address,
        float  $price,
        int    $rooms,
    ): false|string {
        $query = "INSERT INTO ads (title, description, user_id, status_id, branch_id, address, price, rooms, created_at) 
                  VALUES (:title, :description, :user_id, :status_id, :branch_id, :address, :price, :rooms, NOW())";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':status_id', $status_id);
        $stmt->bindParam(':branch_id', $branch_id);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':rooms', $rooms);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function getAd($id)
    {
        $query = "SELECT ads.*, name AS image
                    FROM ads
                    JOIN ads_image ON ads.id = ads_image.ads_id
                  WHERE ads.id = :id";

        $stmt  = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getAds(): false|array
    {
        $query = "SELECT *, ads.id AS id, ads.address AS address, ads_image.name AS image
                  FROM ads
                    JOIN branch ON branch.id = ads.branch_id
                    LEFT JOIN ads_image ON ads.id = ads_image.ads_id";
         return $this->pdo->query($query)->fetchAll();
    }

    public function getUsersAds(int $userId): false|array
    {
        $query = "SELECT *, ads.id AS id, ads.address AS address, ads_image.name AS image
                  FROM ads
                    JOIN branch ON branch.id = ads.branch_id
                    LEFT JOIN ads_image ON ads.id = ads_image.ads_id
                  WHERE user_id = $userId"; // FIXME: Prepare userId
        return $this->pdo->query($query)->fetchAll();
    }

    public function updateAds(
        int    $id,
        string $title,
        string $description,
        int    $user_id,
        int    $status_id,
        int    $branch_id,
        string $address,
        float  $price,
        int    $rooms
    ) {
        $query = "UPDATE ads SET title = :title, description = :description, user_id = :user_id,
                 status_id = :status_id, branch_id = :branch_id, address = :address, 
                 price = :price, rooms = :rooms, updated_at = NOW() WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':status_id', $status_id);
        $stmt->bindParam(':branch_id', $branch_id);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':rooms', $rooms);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteAds(int $id): array|false
    {
        $image = $this->pdo->query("SELECT name FROM ads_image WHERE ads_id = $id")->fetch()->name;
        if ($image!=="default.jpg"){
            unlink("assets/images/ads/$image");
        }

        $query = "DELETE FROM ads WHERE id = :id";
        $stmt  = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function search(
        string $searchPhrase,
        int|null $searchBranch = null,
        int $searchMinPrice = 0,
        int $searchMaxPrice = PHP_INT_MAX
    ) {
        $query = "SELECT *,
                ads.id AS id,
                ads.address AS address,
                ads_image.name AS image
            FROM ads
            JOIN branch ON branch.id = ads.branch_id
            LEFT JOIN ads_image ON ads.id = ads_image.ads_id
            WHERE (title LIKE :searchPhrase
                OR ads.description LIKE :searchPhrase)
                AND price BETWEEN :minPrice AND :maxPrice";

        $params = [
            ':searchPhrase' => "%$searchPhrase%",
            ':minPrice' => $searchMinPrice,
            ':maxPrice' => $searchMaxPrice
        ];

        // Today PATCH: Search and filter refactored
        if ($searchBranch) {
            $query .= " AND branch_id = :searchBranch";
            $params[':searchBranch'] = $searchBranch;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }


}