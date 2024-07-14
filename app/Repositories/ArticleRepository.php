<?php

namespace App\Repositories;

use App\Contracts\IArticleRepository;
use App\DTO\ArticleDTO;
use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class ArticleRepository implements IArticleRepository
{
    public function getAllArticles(): Paginator
    {
        return Category::with('items')->simplePaginate(15);
    }

    public function getAllIds(): Collection
    {
        return Category::pluck('id');
    }

    public function changeStatus(Category $category): void
    {
        $category->is_active = $category->is_active ? 0 : 1;
        $category->save();
    }

    public function getArticleById(int $article_id): ?Category
    {
        /** @var Category|null $article */

        $article = Category::query()->find($article_id);

        return $article;
    }

    public function getArticleByAlias(string $articleAlias): ?Category
    {
        /** @var Category|null $article */
        $article = Category::query()
            ->where('alias', $articleAlias)
            ->first();

        return $article;
    }
    public function createArticle(ArticleDTO $articleDTO): ?Category
    {
        $article = new Category();
        $article->title = $articleDTO->getTitle();
        $article->side = $articleDTO->getSide();
        $article->alias = $articleDTO->getAlias();
        $article->is_active = $articleDTO->getIsActive() ?? true;
        $article->save();

        return $article;
    }

    public function updateArticle(ArticleDTO $articleDTO, Category $article): Category
    {
        $article->title = $articleDTO->getTitle();
        $article->side = $articleDTO->getSide();
        $article->alias = $articleDTO->getAlias();
        $article->is_active = $articleDTO->getIsActive() ?? false;
        $article->save();

        return $article;
    }
    public function deleteArticle(Category $article): void
    {
        $article->delete();
    }

}
