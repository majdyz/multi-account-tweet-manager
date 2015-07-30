<?php

namespace Media\Controllers;

use \App;
use \View;
use \Menu;
use \Admin\BaseController;
use Abraham\TwitterOAuth\TwitterOAuth;
use \Media;
use \TweetMedia;
use \TwitterAccount;
use \User;
use \Response;

class MediaController extends BaseController
{
    const UPLOAD_PATH = 'uploads/';

    public function __construct()
    {
        parent::__construct();
        Menu::get('admin_sidebar')->setActiveMenu('media');
    }

    public function index()
    {
        $this->data['title'] = 'Media';
        $this->data['medias'] = User::find(\Sentry::getUser()->id)->medias()->get();
        View::display('@media/media/index.twig', $this->data);
    }

    public function upload()
    {
        $uploadfile = self::UPLOAD_PATH . basename($_FILES['userfile']['name']);
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            $media = new Media;
            $media->name = $_POST['name'];
            $media->url = $this->siteUrl($uploadfile);
            $media->user_id = \Sentry::getUser()->id;
            $media->save();
            Response::redirect($this->siteUrl('admin/media/' . $media->id));
        };
    }

    public function show($id)
    {
        $model = $this->findMedia($id);
        if (is_null($model) || $model->user_id !== \Sentry::getUser()->id) {
            \App::notFound();
        }

        $this->data['model'] = $model;
        $this->data['title'] = 'View ' . $this->data['model']->name;
        View::display('@media/media/view.twig', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Upload Media';
        View::display('@media/media/create.twig', $this->data);
    }

    public function destroy($id)
    {
        $model = $this->findMedia($id);
        if (is_null($model) || $model->user_id !== \Sentry::getUser()->id) {
            \App::notFound();
        }

        $filepath = self::UPLOAD_PATH . basename($model->url);

        if(unlink($filepath)){
            $model->delete();
        }

        Response::redirect($this->siteUrl('admin/media'));
    }

    protected function findMedia($id)
    {
        if (($model = Media::find($id)) != null) {
            return $model;
        }
        App::notFound();
    }
}