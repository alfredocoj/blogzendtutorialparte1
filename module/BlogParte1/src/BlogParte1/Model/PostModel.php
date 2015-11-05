<?php

namespace BlogParte1\Model;

use Core\Model\TableGateway;

class PostModel extends TableGateway
{

    /**
     * Retorna os posts em formato apropriado para campos select.
     *
     * @return array Os posts.
     *
     */
    public function getPostsToPopuleSelect()
    {

        $sql = "SELECT
                    id as id,
                    title as title
                FROM
                    posts
                ORDER BY
                    post_date";
        $posts = $this->executeSelect($sql);
        echo "<pre>";var_dump($posts);exit;

        foreach ($posts as $key => $value) {
            $retorno[$value->id] = $value->title;
        }

        return $retorno;
    }
}
