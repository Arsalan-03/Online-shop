<?php

namespace Request;

class ReviewRequest extends Request
{
    public function getProductId(): int
    {
        return $this->body['product_id'];
    }
    public function getRating(): int
    {
        return $this->body['rating'];
    }
    public function getAuthor(): string
    {
        return $this->body['author'];
    }
    public function getReviewText(): string
    {
        return $this->body['review-text'];
    }

    public function validate(): array
    {
        $errors = [];
        //Валидация Оценки
        if (isset($this->body['rating'])) {
            $rating = (int)$this->body['rating'];

            if ($rating < 0 || $rating > 5) {
                $errors['rating'] = 'Отзыв не может быть меньше 0 и больше 5';
            }
        } else{
            $errors['rating'] = 'Заполните поле Оценка';
        }

        //Валидация автора
        if (isset($this->body['author'])) {
            $author = $this->body['author'];
            if (strlen($author) < 2 || strlen($author) > 50) {
                $errors['author'] = "Недопустимое количество букв в поле Name";
            }
        } else {
            $errors['author'] = 'Заполните поле Автор';
        }

        //Валидация Отзыва-текст
        if (isset($this->body['review-text'])) {
            $reviewText = $this->body['review-text'];
            if (strlen($reviewText) < 2 || strlen($reviewText) > 255) {
                $errors['review-text'] = 'Недопустимое количество букв в поле Ваш Отзыв';
            }
        } else {
            $errors['review-text'] = 'Заполните поле Ваш Отзыв';
        }
        return $errors;
    }
}