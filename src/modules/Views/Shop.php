<?php

namespace Views;

use Engine\Database\OPdo;
use Engine\Template\Builder;
use Models\Comment;
use Models\Product;

class Shop
{
    private $header;
    private $shop;
    private $footer;
    private $postModel;

    public function __construct()
    {
        $this->postModel = new Product(new OPdo());
        $this->commentModel = new Comment(new OPdo());

        $this->header   = new Builder('Header.tpl');
        $this->shop     = new Builder('Shop.tpl');
        $this->footer   = new Builder('Footer.tpl');
    }

    public function render()
    {
        $this->header->set('title', 'Citrus Shop | Shop');
        $this->footer->set('year', date('Y'));

        $this->shop->set('title', 'Citrus Shop');

        // Build post grid
        $productsGrid = $this->buildProducts();
        $this->shop->set('productsGrid', $productsGrid);
        
        // Build comment grid
        $commentSection = $this->buildComments();
        $this->shop->set('commentSection', $commentSection);

        // Templates are loaded in sequence meaning order is important
        $templates = array(
            $this->header,
            $this->shop,
            $this->footer
        );

        // Render entire View 
        $content = $this->shop->merge($templates);

        $rendered = new Builder('Rendered.tpl');
        $rendered->set('content', $content);

        return $rendered->render();
    }

    private function buildProducts()
    {
        $posts = $this->postModel->getAll();

        if (!$posts) {
            $infoBuilder = new Builder('Info.tpl');
            $infoBuilder->set('info', "There are no posts currently");
            return $infoBuilder->render();
        }


        $postBuilder = new Builder('Product.tpl');

        $html = "";

        $ctr = 0;
        for ($i = 0; $i < POSTS_PER_PAGE / POSTS_PER_ROW; $i += 1) {

            if ($i % POSTS_PER_ROW == 0) {
                $html .= "<div class=\"tile is-ancestor\">";
            }

            for ($j = 0; $j < 3; $j++) {

                if (!$posts[$ctr])
                    break;

                $postBuilder->set('title', $posts[$ctr]->title);
                $postBuilder->set('image', IMAGE_FOLDER_PATH . 'plains.jpg');
                $postBuilder->set('description', $posts[$ctr]->description);
                $html .= $postBuilder->render();

                if ($j == POSTS_PER_ROW - 1) {
                    if ($ctr == POSTS_PER_PAGE - 1) {
                        $html .= "";
                    } else {

                        $html .= "</div><div class=\"tile is-ancestor\">";
                    }
                }

                $ctr += 1;
            }
        }
        $html .= "</div>";
        return $html;
    }

    private function buildComments()
    {
        $comments = $this->commentModel->getAllApproved();

        if (!$comments) {
            $infoBuilder = new Builder('Info.tpl');
            $infoBuilder->set('info', "There are no comments currently");
            return $infoBuilder->render();
        }

        $commentBuilder = new Builder('Comment.tpl');

        $html = "<div class=\"tile is-child\">";

        $commentCount = count($comments);
        for ($i = 0; $i < $commentCount; $i += 1) {

            $commentBuilder->set('name', $comments[$i]->name);
            $commentBuilder->set('email', $comments[$i]->email);
            $commentBuilder->set('text', $comments[$i]->text);

            $html .= $commentBuilder->render();
        }
        $html .= "</div>";
        return $html;
    }
}
