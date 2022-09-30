<?php
namespace app\controllers;

use mako\http\routing\Controller;
use mako\view\ViewFactory;
use mako\pixl\Image;
use mako\pixl\processors\ImageMagick;
class ImagesController extends Controller
{
	public function home(ViewFactory $view): string {
		chdir('/var/www/mako/uploads');
		$fileNames = array_diff(scandir('.'), array('.', '..'));
		$images = [];
		foreach($fileNames as $index => $fileName) {
			$images[$fileName] = 'data:image/' . pathinfo($fileName, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($fileName));
		}
		$this->view->assign('images', $images);
        return $view->render('home');
	}

	public function upload() {
		chdir('/var/www/mako/uploads');
		$imageFile = $this->request->getFiles()->get('image');
		$fileName = $imageFile->getReportedFilename();
		$imageFile->moveTo($fileName);
		$this->response->getHeaders()->add('Location', '/');
	}

	public function editGet(ViewFactory $view): string {
		chdir('/var/www/mako/uploads');
		$fileName = $this->request->getQuery()->get('filename');
		$image = new Image($fileName, new ImageMagick());
		$dimensions = $image->getDimensions();
		$this->view->assign('fileName', $fileName);
		$this->view->assign('dimensions', $dimensions);
		return $view->render('edit');
	}

	public function editPost() {
		chdir('/var/www/mako/uploads');
		$post = $this->request->getPost();
		$fileName = $post->get('filename');
		$degrees = $post->get('degrees');
		$image = new Image($fileName, new ImageMagick());
		$image->rotate($degrees);
		$image->save();
		$this->response->getHeaders()->add('Location', '/');
	}
}

