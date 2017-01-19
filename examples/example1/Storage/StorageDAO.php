<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DataMapper\Storage;

/**
 * Description of CRUDStorage
 *
 * @author d.lanec
 */
interface StorageDAO {

	public function fetchRow($id);

	public function fetchAll();

	public function insert(array $data);

	public function update($id, array $data);

	public function delete($id);
}
