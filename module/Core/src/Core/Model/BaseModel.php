<?php

namespace Core\Model;
use Doctrine\DBAL\DBALException;

class BaseModel extends BaseServiceModel
{
   protected $entity;

   public function setEntity($entity)
   {
      $this->entity = $entity;

      return $this;
   }

   /*
   * Carrega toda os itens
   */
   public function findAll()
   {
      $repository = $this->getEntityManager()->getRepository($this->entity);

      return $repository->findAll();
   }

   /*
   * Carrega todo os itens passando o id com oparametro
   */
   public function getById($id)
   {
      return $this->getEntityManager()->find($this->entity, $id);
   }

   /*
   * Conta todos os itens
   */
   public function count()
   {
      $qb = $this->getEntityManager()->createQueryBuilder();
      $qb->select('count(e)')->from($this->entity, 'e');

      return $qb->getQuery()->getSingleScalarResult();
   }

   /*
   * Carrega os itens passando um campo e o valor
   * Ex. array($attributes => $value)
   */
   public function getByAttributes($array)
   {
      return $this->getEntityManager()->getRepository($this->entity)->findBy($array);
   }

   //Popula Select
   public function getFindAllItemSelect($attributes_id,$attributes_label)
   {
      $repository = $this->getEntityManager()->getRepository($this->entity);
      $data = $repository->findAll();

      //$obj = [];
      $obj = array();
      foreach ($data as $key => $value) {
         $obj[$value->$attributes_id] = $value->$attributes_label;
      }

      return $obj;
   }
   public function getAllItensToSelectByAttributesJsonReturn($attributes, $attributeId, $attributeLabel) {
      $data = $this->getEntityManager()->getRepository($this->entity)->findBy($attributes);

      $obj = array();
      foreach ($data as $key => $value) {
         $obj[] = array($attributeId => $value->$attributeId,  $attributeLabel => $value->$attributeLabel);
      }
      return $obj;
   }

   //Salva
   public function save($data)
   {
      $repository = $this->getEntityManager();
      $repository->persist($data);
      $repository->flush();

      return $repository;
   }

   //Update
   public function update($data,$id)
   {
      $repository = $this->getEntityManager();

      $update = $repository->find($this->entity, $data->$id);
      $update->exchangeArray($data->getArrayCopy());
      $repository->flush();

      return $data;
   }

   //Delete
   public function delete($id)
   {

        $repository = $this->getEntityManager();

        $delete = $repository->find($this->entity, $id);

        if(sizeof($delete) != 0){
           try {
                $repository->remove($delete);
                $repository->flush();

                return true;
           } catch (DBALException $e) {
              return false;
           }
        } else {
           return false;
        }
   }
}
