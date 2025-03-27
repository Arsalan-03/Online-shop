<?php

namespace Models;

class Review extends Model
{
    private $id;
    private $userId;
    private $productId;
    private $rating;
    private $author;
    private $reviewText;
    private $date;

    protected static function getTableName(): string
    {
        return 'reviews';
    }

    public static function add(int $userId, int $productId, int $rating, string $author, string $reviewText): void
    {
        $tableName = static::getTableName();
        $currentDate = date("Y-m-d H:i:s");
        $statement = static::getPdo()->prepare(
            "INSERT INTO $tableName (user_id, product_id, rating, author, review_text, date) 
                    VALUES (:user_id, :product_id, :rating, :author, :reviewText, :date)"
        );
        $statement->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => $rating,
            'author' => $author,
            'reviewText' => $reviewText,
            'date' => $currentDate
        ]);
    }

    public static function getById(int $productId): array
    {
        $tableName = static::getTableName();
        $statement = static::getPdo()->prepare("SELECT * FROM $tableName WHERE product_id = :product_id");
        $statement->execute(['product_id' => $productId]);
        $reviews = $statement->fetchAll();

        $newReview = [];
        foreach ($reviews as $review) {
            $newReview[] = static::hydrate($review);
        }
        return $newReview;
    }

    private static function hydrate(array $reviews): self|null
    {
        if (!$reviews) {
            return null;
        }

        $obj = new self();
        $obj->id = $reviews['id'];
        $obj->userId = $reviews['user_id'];
        $obj->productId = $reviews['product_id'];
        $obj->rating = $reviews['rating'];
        $obj->author = $reviews['author'];
        $obj->reviewText = $reviews['review_text'];
        $obj->date = $reviews['date'];

        return $obj;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getReviewText()
    {
        return $this->reviewText;
    }

    public function getDate()
    {
        return $this->date;
    }

}