<?php
App::uses('AppController', 'Controller');
/**
 * Collections Controller
 *
 * @property Collection $Collection
 * @property AclComponent $Acl
 */
class CollectionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Acl');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Collection->recursive = 0;
		$this->set('collections', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Collection->id = $id;
		if (!$this->Collection->exists()) {
			throw new NotFoundException(__('Invalid collection'));
		}
		$this->set('collection', $this->Collection->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
         //   $this->layout = null;
		if ($this->request->is('post')) {
			$this->Collection->create();
			if ($this->Collection->save($this->request->data)) {
				$this->Session->setFlash(__('The collection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The collection could not be saved. Please, try again.'));
			}
		}
		$fournisseurs = $this->Collection->Fournisseur->find('list');
		$categories = $this->Collection->Categorie->find('list');
		$editeurs = $this->Collection->Editeur->find('list');
		$this->set(compact('fournisseurs', 'categories', 'editeurs'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Collection->id = $id;
		if (!$this->Collection->exists()) {
			throw new NotFoundException(__('Invalid collection'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Collection->save($this->request->data)) {
				$this->Session->setFlash(__('The collection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The collection could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Collection->read(null, $id);
		}
		$fournisseurs = $this->Collection->Fournisseur->find('list');
		$categories = $this->Collection->Categorie->find('list');
		$editeurs = $this->Collection->Editeur->find('list');
		$this->set(compact('fournisseurs', 'categories', 'editeurs'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Collection->id = $id;
		if (!$this->Collection->exists()) {
			throw new NotFoundException(__('Invalid collection'));
		}
		if ($this->Collection->delete()) {
			$this->Session->setFlash(__('Collection deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Collection was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
