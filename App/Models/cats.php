<?php
class Cats extends Artemis_Model
{

   public function getAll()
   {
       _p($this->db->find()->fetchAll());
   }
}