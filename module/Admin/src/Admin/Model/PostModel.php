<?php

namespace Admin\Model;

use Core\Model\BaseModel;

class PostModel extends BaseModel
{
    protected $adapter;

    /**
     * Retorna os posts em formato apropriado para campos select.
     *
     * @return array Os posts.
     *
     */
    public function getPostsToPopuleSelect()
    {
        $this->adapter = new \Zend\Db\Adapter\Adapter($this->confConnectionDB());

        $sql = "SELECT
                    id as id,
                    title as title
                FROM
                    posts
                ORDER BY
                    post_date";

        foreach ($this->adapter->query($sql)->execute() as $key => $value) {
            $retorno[$value['id']] = $value['title'];
        }

        return $retorno;
    }
}
