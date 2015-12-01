<?php

namespace BlogParte1\Model;

class PostModel extends BaseModel
{

    function __construct()
    {
        $this->setEntity("BlogParte1\Entity\Post");
    }

    /**
     * Retorna os posts em formato apropriado para campos select.
     *
     * @return array Os posts.
     *
     */
    public function getPostsToPopuleSelect()
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT
                    id as id,
                    title as title
                FROM
                    posts
                ORDER BY
                    post_date";
        $posts = $repository->executeQuery($sql)->fetchAll(\PDO::FETCH_CLASS);

        foreach ($posts as $key => $value) {
            $retorno[$value->id] = $value->title;
        }

        return $retorno;
    }
}
