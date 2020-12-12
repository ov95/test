<?php

namespace Views;

use Engine\Database\OPdo;
use Engine\Template\Builder;
use Models\Comment;
use Models\Product;

class Cms
{
    private $header;
    private $cms;
    private $footer;
    private $postModel;

    public function __construct()
    {
        $this->postModel = new Product(new OPdo());
        $this->commentModel = new Comment(new OPdo());

        $this->header   = new Builder('Header.tpl');
        $this->cms     = new Builder('Cms.tpl');
        $this->footer   = new Builder('Footer.tpl');
    }

    public function render()
    {
        $this->header->set('title', 'Citrus Shop | CMS');
        $this->footer->set('year', date('Y'));

        $this->cms->set('title', 'Citrus CMS');

        // Build comment grid
        $commentSection = $this->buildComments();
        $this->cms->set('commentSection', $commentSection);

        // Templates are loaded in sequence meaning order is important
        $templates = array(
            $this->header,
            $this->cms,
            $this->footer
        );

        // Render entire View 
        $content = $this->cms->merge($templates);

        $rendered = new Builder('Rendered.tpl');
        $rendered->set('content', $content);

        return $rendered->render();
    }

    private function buildComments()
    {
        $comments = $this->commentModel->getAll();

        if (!$comments) {
            $infoBuilder = new Builder('Info.tpl');
            $infoBuilder->set('info', "There are no comments currently");
            return $infoBuilder->render();
        }

        $commentBuilder = new Builder('CmsComment.tpl');

        $html = "";

        $commentCount = count($comments);
        for ($i = 0; $i < $commentCount; $i += 1) {

            $infoClass = $comments[$i]->approved == STATUS_ACTIVE ? 'is-info is-light' : 'is-warning is-light';
            $buttonText = $comments[$i]->approved == STATUS_ACTIVE ? 'DISABLE' : 'ENABLE';

            $commentBuilder->set('name', $comments[$i]->name);
            $commentBuilder->set('email', $comments[$i]->email);
            $commentBuilder->set('text', $comments[$i]->text);
            $commentBuilder->set('infoClass', $infoClass);
            $commentBuilder->set('buttonText', $buttonText);
            $commentBuilder->set('hCommentId', $comments[$i]->id);

            $html .= $commentBuilder->render();
        }

        return $html;
    }
}
