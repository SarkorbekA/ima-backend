<?php

namespace App\Contracts;

use App\DTO\ArticleDTO;
use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

interface IArticleRepository
{
    public function getAllArticles(): Paginator;

    public function changeStatus(Category $category): void;

    public function getArticleById(int $article_id): ?Category;

    public function getArticleByAlias(string $articleAlias): ?Category;

    public function createArticle(ArticleDTO $articleDTO): ?Category;
    public function updateArticle(ArticleDTO $articleDTO, Category $article): Category;
    public function deleteArticle(Category $article): void;


}
